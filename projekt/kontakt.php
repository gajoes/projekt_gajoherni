<?php
require_once 'database.php';
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontakt</title>

  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            <li class="nav-item">
              <a class="nav-link" href="./regulamin.php">Regulamin</a>
            </li>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            </div>
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
  <div class="container mt-5 navcwe">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h3 class="text-center mb-5">Skontaktuj się z nami za pomocą poniższych danych.</h3>
    <br>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h4 class="mb-4">Dane kontaktowe</h4>
        <p class="icon-hover"><i class="fas fa-map-marker-alt flip przerwai" id="pinpoint"></i>ul. Cytrynowa 5, 08-110
          Grabianów,
          Polska</p>
        <p class="icon-hover"><i class="fas fa-phone-alt shake przerwai"></i>+48 123 456 789</p>
        <p class="icon-hover"><i class="fas fa-envelope bounce  przerwai"></i><a
            href="mailto:kontakt@firma.pl">kontaktBYTE@gmail.com</a>
        </p>
        <p class="icon-hover"><i class="fas fa-clock spin przerwai"></i>Poniedziałek - Piątek: 9:00 - 17:00</p>
      </div>
    </div>
    <br>
    <div class="text-center mt-5">
      <h4>Znajdź nas na mediach społecznościowych</h4>
      <br>
      <a href="https://facebook.com" target="_blank" class="btn btn-outline-primary mx-2 icon-hover">
        <i class="fab fa-facebook-f"></i> Facebook
      </a>
      <a href="https://twitter.com" target="_blank" class="btn btn-outline-info mx-2 icon-hover">
        <i class="fab fa-twitter"></i> Twitter
      </a>
      <a href="https://instagram.com" target="_blank" class="btn btn-outline-danger mx-2 icon-hover">
        <i class="fab fa-instagram"></i> Instagram
      </a>
      <a href="https://linkedin.com" target="_blank" class="btn btn-outline-secondary mx-2 icon-hover">
        <i class="fab fa-linkedin"></i> LinkedIn
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>