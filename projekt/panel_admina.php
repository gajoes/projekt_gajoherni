<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admina</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-elements-font">
        <div class="container-fluid">
        <a class="navbar-brand">
            <img src="./css/img/logo.webp" width="30" height="30" class="d-inline-block align-top brand-logo-sizing" alt="Jurzyk">
        <a class="navbar-brand navbar-custom-font">Sklep</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Strona główna</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Galeria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Kontakt</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Oferta
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Usługi</a>
                <a class="dropdown-item" href="#">Zakupy</a>
                <a class="dropdown-item" href="#">Merchendise</a>
              </div>
            </li>
          </ul>
        </div>

        <div class="d-flex align-items-center">
            <a class="nav-link" href="login.php">
                <img src="https://www.pngkit.com/png/full/88-885453_login-white-on-clear-user-icon.png" alt="Logowanie" class="nav-right-bar" style="margin-right:20px;" width="20" height="20">
            </a>
            <a class="nav-link" href="#">
                <img src="https://static-00.iconduck.com/assets.00/checkout-icon-2048x2048-8k7j8q1t.png" alt="Koszyk" class="nav-right-bar" width="20" height="20">
            </a>
        </div>
        </div>
      </nav>
      <div class="container mt-5" id="wybor">
    <h1 class=" mb-4">Panel Admina</h1>
    <div class="row">
        <div class="col-md-3">
            <a href="zarzadzaj_uzytkownikami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj użytkownikami</a>
            <a href="zarzadzaj_pracownikami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj pracownikami</a>
            <a href="zarzadzaj_produktami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj produktami</a>
        </div>
    </div>
</div>

<style>
    #wybor{
        overflow:hidden;
        float:left;
    }
    h1{
        color:white;
    }
    .col-md-3{
        border: 4px solid white;
        border-radius:25px;
        padding-top:15px;
    }
</style>

</body>
</html>