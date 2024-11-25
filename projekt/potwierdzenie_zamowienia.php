<?php
require_once 'database.php';
session_start();

if (!isset($_GET['zamowienie'])){
    die('Nieprawidłowy identyfikator zamówienia.');
}
$id_zamowienia = (int)$_GET['zamowienie'];
$sql="SELECT z.id_zamowienia,z.username,z.email,z.imie,z.nazwisko,z.data_zamowienia,za.ulica,za.nr_domu,za.nr_mieszkania,za.miasto,za.kod_pocztowy
        FROM zamowienia z
        JOIN zamowienia_adresy za ON z.id_zamowienia =za.id_zamowienia
        WHERE z.id_zamowienia=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id_zamowienia);
$stmt->execute();
$result=$stmt->get_result();

if ($result->num_rows===0){
    die('Nie znaleziono zamówienia o podanym identyfikatorze.');
}

$zamowienie = $result->fetch_assoc();
$sql="SELECT p.nazwa,zp.ilosc,p.cena
        FROM zamowienia_produkty zp
        JOIN produkty p ON zp.id_produktu = p.id_produktu
        WHERE zp.id_zamowienia=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id_zamowienia);
$stmt->execute();
$produkty=$stmt->get_result();


$suma=0;
foreach ($produkty as $produkt){
    $suma+=$produkt['cena']*$produkt['ilosc'];
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdzenie Zamówienia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-4">
    <h2>Dziękujemy za złożenie zamówienia!</h2>
    <br>
    <h3>Szczegóły zamówienia:</h3>
    <br>
    <p><strong>ID zamówienia:</strong> <?php echo htmlspecialchars($zamowienie['id_zamowienia']); ?></p>
    <p><strong>Data zamówienia:</strong> <?php echo htmlspecialchars($zamowienie['data_zamowienia']); ?></p>
    <h4>Dane kupującego:</h4>
    <br>
    <p><strong>Imię i nazwisko:</strong> <?php echo htmlspecialchars($zamowienie['imie'].' '.$zamowienie['nazwisko']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($zamowienie['email']); ?></p>
    <h4>Adres dostawy:</h4>
    <p>
        <?php echo htmlspecialchars($zamowienie['ulica'].' '.$zamowienie['nr_domu'].($zamowienie['nr_mieszkania'] ? '/'.$zamowienie['nr_mieszkania'] : '')); ?><br>
        <?php echo htmlspecialchars($zamowienie['kod_pocztowy'].' '.$zamowienie['miasto']); ?>
    </p>
    <h4>Produkty</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nazwa produktu</th>
                <th>Ilość</th>
                <th>Cena jednostkowa</th>
                <th>Wartość</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $produkty->data_seek(0);
            while ($produkt=$produkty->fetch_assoc()):
                $wartosc=$produkt['cena']*$produkt['ilosc'];
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($produkt['nazwa']); ?></td>
                    <td><?php echo htmlspecialchars($produkt['ilosc']); ?></td>
                    <td><?php echo number_format($produkt['cena'],2); ?> PLN</td>
                    <td><?php echo number_format($wartosc,2); ?> PLN</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h4>Łączna kwota zamówienia: <?php echo number_format($suma, 2); ?> PLN</h4>
    <a href="index.php" class="btn btn-primary">Powrót do strony głównej</a>
</div>
</body>
</html>
