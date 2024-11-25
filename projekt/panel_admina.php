<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column" style="height: 100vh;">
  <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-elements-font">
    <div class="container-fluid">
      <a class="navbar-brand">
        <img src="./css/img/Tech.png" width="30" height="30" class="d-inline-block align-top brand-logo-sizing"
          alt="Jurzyk">
        <a class="navbar-brand navbar-custom-font"><span class="logop1">B</span><span class="logop2">Y</span><span
            class="logop3">T</span><span class="logop4">E</span></a>
      </a>
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
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div class="container-fluid d-flex flex-column flex-grow-1" id="wybor">
    <h1 class="admin-title text-center mb-4">Panel Admina</h1>
    <br>
    <br>
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_uzytkownikami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-users fa-3x mb-3"></i>
          <div>Zarządzaj użytkownikami</div>
        </a>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_pracownikami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-user-tie fa-3x mb-3"></i>
          <div>Zarządzaj pracownikami</div>
        </a>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_produktami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-box fa-3x mb-3"></i>
          <div>Zarządzaj produktami</div>
        </a>
      </div>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_zamowieniami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-shopping-cart fa-3x mb-3"></i>
          <div>Zarządzaj zamówieniami</div>
        </a>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex justify-content-center align-items-center">
        <a href="zarzadzaj_kategoriami.php" class="btn btn-light text-center w-100 p-4 rounded shadow-sm">
          <i class="fa-solid fa-tags fa-3x mb-3"></i>
          <div>Zarządzaj kategoriami</div>
        </a>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex justify-content-center align-items-center">
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
      flex-grow: 1;
      margin-top: 20px;
    }

    #wybor h1 {
      color: black;
      font-size: 2rem;
      text-align: center;
    }

    #wybor .row {
      display: flex;
      justify-content: center;
      gap: 50px;
      flex-wrap: wrap;
    }

    #wybor .col-12,
    #wybor .col-sm-6,
    #wybor .col-md-4,
    #wybor .col-lg-2 {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      margin-bottom: 40px;
    }

    #wybor .btn-light {
      background-color: #f8f9fa;
      color: black;
      border-radius: 10px;
      padding: 30px;
      width: 100%;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border: none;
      transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
    }

    #wybor .btn-light:hover {
      background-color: #e2e6ea;
      transform: scale(1.1);
    }

    #wybor .btn-light i {
      color: black;
      transition: color 0.3s ease;
    }

    #wybor .btn-light:hover i {
      color: black;
    }

    #wybor .btn-light div {
      font-size: 1.2rem;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    #wybor .btn-light:hover div {
      color: #000;
    }
    .wyloguj{
      text-align: center;
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>