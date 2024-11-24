<?php
require_once 'database.php';
session_start();
$koszyk=[];
$razem=0;

if (isset($_SESSION['id_uzytkownika'])){
    $id_uzytkownika = $_SESSION['id_uzytkownika'];
    $sql="SELECT k.id_koszyka,p.id_produktu,p.nazwa,p.cena,k.ilosc, (p.cena *k.ilosc) AS suma
            FROM koszyk k
            JOIN produkty p ON k.id_produktu=p.id_produktu
            WHERE k.id_uzytkownika = ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $id_uzytkownika);
    $stmt->execute();
    $result=$stmt->get_result();
    while ($row=$result->fetch_assoc()){
        $koszyk[]=$row;
        $razem+=$row['suma'];
    }
}else{
    if (isset($_SESSION['koszyk'])&& !empty($_SESSION['koszyk'])){
        $sessionKoszyk = $_SESSION['koszyk'];
        unset($sessionKoszyk['suma']);
        $ids = implode(',',array_keys($sessionKoszyk));
        $ids=mysqli_real_escape_string($conn,$ids);
        $sql="SELECT id_produktu, nazwa, cena FROM produkty WHERE id_produktu IN ($ids)";
        $result = $conn->query($sql);
        while ($row=$result->fetch_assoc()){
            $id_produktu=$row['id_produktu'];
            $ilosc=$_SESSION['koszyk'][$id_produktu];
            $suma=$row['cena']*$ilosc;
            $koszyk[]=[
                'id_produktu' =>$id_produktu,
                'nazwa'=>$row['nazwa'],
                'cena'=>$row['cena'],
                'ilosc'=>$ilosc,
                'suma'=>$suma
            ];
            $razem += $suma;
        }
    }
}
$_SESSION['suma_koszyka'] = $razem;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koszyk</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container mt-4">
    <h3>Koszyk</h3>
    <form method="POST" action="ilosc_w_koszyku.php">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Produkt</th>
            <th>Cena</th>
            <th>Ilość</th>
            <th>Suma</th>
            <th>Usuń</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($koszyk as $item){
              echo '<tr>';
              echo '<td>'.htmlspecialchars($item['nazwa']).'</td>';
              echo '<td>'.number_format($item['cena'], 2).' PLN</td>';
              echo '<td>';
              echo '<input type="number" name="ilosc['.$item['id_produktu'].']" value="'.$item['ilosc'].'" min="1" class="form-control">';
              echo '</td>';
              echo '<td>'.number_format($item['suma'], 2).' PLN</td>';
              echo '<td><a href="usun_z_koszyka.php?id_produktu='.$item['id_produktu'].'" class="btn btn-danger btn-sm">Usuń</a></td>';
              echo '</tr>';
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"><strong>Łączna suma:</strong></td>
            <td colspan="2"><?php echo number_format($razem, 2); ?> PLN</td>
          </tr>
          <tr>
  <td colspan="3">
    <button type="submit" class="btn btn-success">Zaktualizuj koszyk</button>
  </td>
  <td colspan="2">
    <a href="zamowienie.php" class="btn btn-primary w-100">Przejdź do zakupu</a>
  </td>
</tr>
        </tfoot>
      </table>
    </form>
  </div>
</body>
</html>