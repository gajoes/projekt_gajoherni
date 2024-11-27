<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['employee_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Pracownika</title>
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
  <br>
  <br>
  <br>
  <br>
  <div class="container-fluid d-flex flex-column flex-grow-1" id="wybor">
    <h1 class="admin-title text-center mb-4">Panel Pracownika</h1>
    <br><br>
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_produktami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-box fa-3x mb-3"></i>
          <div>Zarządzaj produktami</div>
        </a>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_zamowieniami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-shopping-cart fa-3x mb-3"></i>
          <div>Zarządzaj zamówieniami</div>
        </a>
      </div>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_kategoriami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-tags fa-3x mb-3"></i>
          <div>Zarządzaj kategoriami</div>
        </a>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_dostawcami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-truck fa-3x mb-3"></i>
          <div>Zarządzaj dostawcami</div>
        </a>
      </div>
    </div>

    <a href="wyloguj.php" class="wyloguj">
      <button type="button" class="btn btn-secondary mt-3">Wyloguj</button>
    </a>
  </div>


  <style>
    #wybor {
      overflow: hidden;
      float: left;
    }

    h1 {
      color: black;
    }

    .col-md-3 {
      border: 4px solid black;
      border-radius: 25px;
      padding-top: 15px;
    }

    .wyloguj {
      text-align: center;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>