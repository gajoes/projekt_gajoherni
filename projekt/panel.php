<?php
require_once 'database.php';
session_start();

if(!isset($_SESSION['user_id'])&& !isset($_COOKIE['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_COOKIE['user_id'])){
    $_SESSION['user_id']=$_COOKIE['user_id'];
}

$user_id=$_SESSION['user_id'];

$query=$conn->prepare("SELECT u.username,u.email,u.imie,u.nazwisko,k.nr_tel,a.ulica,a.nr_domu,a.nr_mieszkania,a.miasto,a.kod_pocztowy
FROM Uzytkownicy u
LEFT JOIN Adresy a ON u.id_uzytkownika=a.id_uzytkownika
LEFT JOIN Kontakty k ON u.id_uzytkownika=k.id_uzytkownika
WHERE u.id_uzytkownika=?");

$query->bind_param("i",$user_id);
$query->execute();
$result=$query->get_result();
$user=$result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];
    $nr_tel=$_POST['nr_tel'];
    $ulica=$_POST['ulica'];
    $nr_domu=$_POST['nr_domu'];
    $nr_mieszkania=$_POST['nr_mieszkania'] ?? null;
    $miasto=$_POST['miasto'];
    $kod_pocztowy=$_POST['kod_pocztowy'];

    $updateUser=$conn->prepare("UPDATE Uzytkownicy SET imie=?,nazwisko=? WHERE id_uzytkownika=?");
    $updateUser->bind_param("ssi",$imie,$nazwisko,$user_id);
    $updateUser->execute();

    $updateContact=$conn->prepare("REPLACE INTO Kontakty (nr_tel,email,id_uzytkownika) VALUES (?,?,?)");
    $updateContact->bind_param("ssi",$nr_tel,$user['email'],$user_id);
    $updateContact->execute();

    $updateAddress=$conn->prepare("REPLACE INTO Adresy (ulica,nr_domu,nr_mieszkania,miasto,kod_pocztowy,id_uzytkownika) VALUES (?,?,?,?,?,?)");
    $updateAddress->bind_param("sssssi",$ulica,$nr_domu,$nr_mieszkania,$miasto,$kod_pocztowy,$user_id);
    $updateAddress->execute();

    $_SESSION['update_success']="Dane zostały pomyślnie zaktualizowane!";
    header("Location:panel.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>
    <link rel="stylesheet" href="css/style.css">
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
              <a class="nav-link" href="#produkty">Zakupy</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              </div>
            </li>
          </ul>
        </div>

        <div class="d-flex align-items-center">
          <a class="nav-link" href="login.php">
            <i class="fa-solid fa-user fa-xl fa-fw navicon"></i>
          </a>
          <a class="nav-link" href="#">
            <i class="fa-solid fa-cart-shopping fa-xl fa-fw navicon"></i>
          </a>
        </div>
    </div>
  </nav>
      <div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background-color:#28a745; color:white; padding:15px; border-radius:5px; z-index:1000;">
      <span id="popup-message"></span>
      </div>
<div class="container mt-5 contFormularz">
    <h2>Witamy, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <h4>Jeżeli masz chwilę czasu, dokończ konfigurację konta podając resztę potrzebnych danych!</h4>
    <form method="POST" action="">
        <div class="form-group">
            <label for="imie">Imię</label>
            <input type="text" class="form-control" id="imie" name="imie" value="<?php echo htmlspecialchars($user['imie']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" value="<?php echo htmlspecialchars($user['nazwisko']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nr_tel">Numer telefonu</label>
            <input type="text" class="form-control" id="nr_tel" name="nr_tel" value="<?php echo htmlspecialchars($user['nr_tel'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="ulica">Ulica</label>
            <input type="text" class="form-control" id="ulica" name="ulica" value="<?php echo htmlspecialchars($user['ulica'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="nr_domu">Numer domu</label>
            <input type="text" class="form-control" id="nr_domu" name="nr_domu" value="<?php echo htmlspecialchars($user['nr_domu'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="nr_mieszkania">Numer mieszkania (opcjonalnie)</label>
            <input type="text" class="form-control" id="nr_mieszkania" name="nr_mieszkania" value="<?php echo htmlspecialchars($user['nr_mieszkania'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="miasto">Miasto</label>
            <input type="text" class="form-control" id="miasto" name="miasto" value="<?php echo htmlspecialchars($user['miasto'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="kod_pocztowy">Kod pocztowy</label>
            <input type="text" class="form-control" id="kod_pocztowy" name="kod_pocztowy" value="<?php echo htmlspecialchars($user['kod_pocztowy'] ?? ''); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" class="btnDane">Zaktualizuj dane</button>
    </form>
    <a href="wyloguj.php">
        <button type="button" class="btn btn-secondary mt-3" class="btnWyloguj">Wyloguj</button>
    </a>
</div>

<script>

window.onload=function(){
  <?php if(isset($_SESSION['update_success'])):?>
    document.getElementById('popup-message').textContent="<?php echo $_SESSION['update_success']; ?>";
    document.getElementById('popup').style.display='block';

    setTimeout(function(){
      document.getElementById('popup').style.display='none';
    },3000);
  
    <?php unset($_SESSION['update_success']); ?>
    <?php endif; ?>

};

</script>

<style>
  .contFormularz{
    max-width: 600px;
    margin-left:0;
    margin-right: auto;
    padding: 20px;
    color: black;
}
  .form-group{
    margin-bottom: 15px;
}
input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"]{
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>

</body>
</html>