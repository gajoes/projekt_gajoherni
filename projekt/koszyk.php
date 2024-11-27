<?php
require_once 'database.php';
session_start();
$koszyk = [];
$razem = 0;

if (isset($_SESSION['id_uzytkownika'])) {
  $id_uzytkownika = $_SESSION['id_uzytkownika'];
  $sql = "SELECT k.id_koszyka,p.id_produktu,p.nazwa,p.cena,k.ilosc, (p.cena *k.ilosc) AS suma
            FROM koszyk k
            JOIN produkty p ON k.id_produktu=p.id_produktu
            WHERE k.id_uzytkownika = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_uzytkownika);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $koszyk[] = $row;
    $razem += $row['suma'];
  }
} else {
  if (isset($_SESSION['koszyk']) && !empty($_SESSION['koszyk'])) {
    $sessionKoszyk = $_SESSION['koszyk'];
    unset($sessionKoszyk['suma']);
    $ids = implode(',', array_keys($sessionKoszyk));
    $ids = mysqli_real_escape_string($conn, $ids);
    $sql = "SELECT id_produktu, nazwa, cena FROM produkty WHERE id_produktu IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      $id_produktu = $row['id_produktu'];
      $ilosc = $_SESSION['koszyk'][$id_produktu];
      $suma = $row['cena'] * $ilosc;
      $koszyk[] = [
        'id_produktu' => $id_produktu,
        'nazwa' => $row['nazwa'],
        'cena' => $row['cena'],
        'ilosc' => $ilosc,
        'suma' => $suma
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
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-elements-font">
    <div class="container-fluid">
      <a class="navbar-brand">
        <img src="./css/img/Tech.png" width="30" height="30" class="d-inline-block align-top brand-logo-sizing"
          alt="Jurzyk">
        <a class="navbar-brand navbar-custom-font"><span class="logop1">B</span><span class="logop2">Y</span><span
            class="logop3">T</span><span class="logop4">E</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="./index.php">Strona główna <span class="sr-only">(Aktualnie włączone)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./about.php">O nas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./kontakt.php">Kontakt</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="index.php">Zakupy</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              </div>
            </li>
          </ul>
        </div>

        <div class="d-flex align-items-center">
          <a class="nav-link" href="login.php">
            <i class="fa-solid fa-user fa-xl fa-fw navicon"></i>
          </a>
          <a class="nav-link" href="koszyk.php">
            <i class="fa-solid fa-cart-shopping fa-xl fa-fw navicon"></i>
          </a>
        </div>
    </div>
  </nav>
<br>
<br>
<br>
<br>
  <div class="containerArrow">
    <a class="strzalka" href="index.php"><i class="arrow right"></i>Wróć</a>
  </div>
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
          foreach ($koszyk as $item) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($item['nazwa']) . '</td>';
            echo '<td>' . number_format($item['cena'], 2) . ' PLN</td>';
            echo '<td>';
            echo '<input type="number" name="ilosc[' . $item['id_produktu'] . ']" value="' . $item['ilosc'] . '" min="1" class="form-control">';
            echo '</td>';
            echo '<td>' . number_format($item['suma'], 2) . ' PLN</td>';
            echo '<td><a href="usun_z_koszyka.php?id_produktu=' . $item['id_produktu'] . '" class="btn btn-danger btn-sm">Usuń</a></td>';
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

  <td colspan="5">
    <a href="zamowienie.php" class="btn btn-primary w-100">Przejdź do zakupu</a>
  </td>
</tr>
<tr>
  <td colspan="5">
    <a href="status_zamowienia.php" class="btn btn-secondary w-100">Zobacz status zamówienia</a>
  </td>
</tr>
        </tfoot>
      </table>
    </form>
  </div>
  <script>
document.addEventListener('DOMContentLoaded',function (){
    document.querySelectorAll('input[name^="ilosc"]').forEach(input =>{
        input.addEventListener('change', function (){
            const idProduktu=this.name.match(/\d+/)[0];
            const ilosc=this.value;

            fetch('ilosc_w_koszyku.php',{
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_produktu=${idProduktu}&ilosc=${ilosc}`
            })
            .then(response=>response.json())
            .then(data=>{
                if (data.success){
                    location.reload();
                }else{
                    alert('Błąd aktualizacji koszyka.');
                }
            });
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>