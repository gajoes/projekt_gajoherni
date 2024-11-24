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
      <div class="container mt-5" id="wybor">
    <h1 class=" mb-4">Panel Admina</h1>
    <div class="row">
        <div class="col-md-3">
            <a href="zarzadzaj_uzytkownikami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj użytkownikami</a>
            <a href="zarzadzaj_pracownikami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj pracownikami</a>
            <a href="zarzadzaj_produktami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj produktami</a>
            <a href="zarzadzaj_zamowieniami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj zamówieniami</a>
            <a href="zarzadzaj_kategoriami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj kategoriami</a>
            <a href="zarzadzaj_dostawcami.php" class="btn btn-primary btn-lg w-100 mb-3">Zarządzaj dostawcami</a>
        </div>
    </div>
</div>

<style>
    #wybor{
        overflow:hidden;
        float:left;
    }
    h1{
        color:black;
    }
    .col-md-3{
        border: 4px solid black;
        border-radius:25px;
        padding-top:15px;
    }
</style>

</body>
</html>