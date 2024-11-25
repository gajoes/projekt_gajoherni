<?php
require_once 'database.php';
session_start();

$isLoggedIn=isset($_SESSION['user_id']);
$user_id=$isLoggedIn ? $_SESSION['user_id'] : null;
$formData=[
    'email'=>'',
    'imie'=>'',
    'nazwisko'=>'',
    'ulica'=>'',
    'nr_domu'=>'',
    'nr_mieszkania'=>'',
    'miasto'=>'',
    'kod_pocztowy'=>''
];

if ($isLoggedIn){
    $sql="SELECT u.email,u.imie,u.nazwisko,a.ulica,a.nr_domu, a.nr_mieszkania,a.miasto,a.kod_pocztowy
            FROM uzytkownicy u
            LEFT JOIN adresy a ON u.id_uzytkownika =a.id_uzytkownika
            WHERE u.id_uzytkownika=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        foreach ($formData as $klucz=>$wartosc_klucz){
            if (!empty($data[$klucz])){
                $formData[$klucz]=$data[$klucz];
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $formData= [
        'email'=>$_POST['email'] ?? '',
        'imie'=>$_POST['imie'] ?? '',
        'nazwisko'=> $_POST['nazwisko'] ?? '',
        'ulica'=>$_POST['ulica'] ?? '',
        'nr_domu'=>$_POST['nr_domu'] ?? '',
        'nr_mieszkania'=>$_POST['nr_mieszkania'] ?? '',
        'miasto'=>$_POST['miasto'] ?? '',
        'kod_pocztowy'=>$_POST['kod_pocztowy'] ?? ''
    ];
    $errors = [];
    foreach ($formData as $klucz=>$wartosc_klucz){
        if (empty($wartosc_klucz)&&$klucz !=='nr_mieszkania'){
            $errors[]="Pole $klucz jest wymagane.";
        }
    }
    if (empty($errors)){
        if (isset($_SESSION['koszyk'])&& !empty($_SESSION['koszyk'])){
            $suma=calculateCartTotal($_SESSION['koszyk'],$conn);
            $_SESSION['zamowienie']=array_merge($formData,[
                'id_uzytkownika'=>$user_id,
                'koszyk'=>$_SESSION['koszyk'],
                'suma'=> $suma
            ]);
            header('Location: platnosc.php');
            exit;
        }else{
            $errors[]="Twój koszyk jest pusty.";
        }
    }
}
function calculateCartTotal($koszyk, $conn){
    $razem=0;
    foreach ($koszyk as $product_id=>$ilosc){
        $stmt=$conn->prepare("SELECT cena FROM produkty WHERE id_produktu=?");
        $stmt->bind_param("i",$product_id);
        $stmt->execute();
        $stmt->bind_result($cena);
        $stmt->fetch();
        $stmt->close();
        $razem += $cena*$ilosc;
    }
    return $razem;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h3>Formularz zamówienia</h3>
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($formData['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Imię:</label>
                <input type="text" name="imie" class="form-control" value="<?php echo htmlspecialchars($formData['imie']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nazwisko:</label>
                <input type="text" name="nazwisko" class="form-control" value="<?php echo htmlspecialchars($formData['nazwisko']); ?>" required>
            </div>
            <div class="form-group">
                <label>Ulica:</label>
                <input type="text" name="ulica" class="form-control" value="<?php echo htmlspecialchars($formData['ulica']); ?>" required>
            </div>
            <div class="form-group">
                <label>Numer domu:</label>
                <input type="text" name="nr_domu" class="form-control" value="<?php echo htmlspecialchars($formData['nr_domu']); ?>" required>
            </div>
            <div class="form-group">
                <label>Numer mieszkania (opcjonalne):</label>
                <input type="text" name="nr_mieszkania" class="form-control" value="<?php echo htmlspecialchars($formData['nr_mieszkania']); ?>">
            </div>
            <div class="form-group">
                <label>Miasto:</label>
                <input type="text" name="miasto" class="form-control" value="<?php echo htmlspecialchars($formData['miasto']); ?>" required>
            </div>
            <div class="form-group">
                <label>Kod pocztowy:</label>
                <input type="text" name="kod_pocztowy" class="form-control" value="<?php echo htmlspecialchars($formData['kod_pocztowy']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Złóż zamówienie</button>
        </form>
    </div>
</body>
</html>
