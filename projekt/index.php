<?php
require_once 'database.php';
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Strona Główna</title>

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
              <a class="nav-link" href="#">Strona główna <span class="sr-only">(Aktualnie włączone)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Galeria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Kontakt</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
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
            <i class="fa-solid fa-user fa-xl fa-fw navicon"></i>
          </a>
          <a class="nav-link" href="#">
            <i class="fa-solid fa-cart-shopping fa-xl fa-fw navicon"></i>
          </a>
        </div>
    </div>
  </nav>

  <div class="d-flex justify-content-center">
    <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img
            src="https://static.vecteezy.com/system/resources/thumbnails/003/810/922/small/horizontal-banner-for-black-friday-sale-black-balls-with-shiny-ribbons-golden-letters-vector.jpg"
            class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://www.apple.com/v/iphone-16/c/images/meta/iphone-16_overview__fcivqu9d5t6q_og.png"
            class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://storage-asset.msi.com/global/picture/apluscontent/reseller/1663812116.jpeg"
            class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-md-3">
        <div class="highlighted-product mb-4">
          <div class="text-center">
            <span class="borderp">Wyjątkowa cena</span>
            <img src="./css/img/iphone16.png" alt="Featured iPhone" class="img-fluid">
            <h3 class="mb-2">iPhone 16</h3>
            <p class="text-muted">Cena: 4999 PLN</p>
            <a href="#" class="btn btn-primary">Dodaj do koszyka</a>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row">
          <div class="col-md-4 product-card">
            <div class="product">
              <img src="./css/img/lenovoIdeaPad.png" alt="lenovo idea pad">
              <h5 class="mb-2">Lenovo Idea Pad Slim 3-15</h5>
              <br>
              <p class="text-muted leftprice">Cena: 2099 PLN</p>
            </div>
          </div>

          <div class="col-md-4 product-card">
            <div class="product">
              <img src="./css/img/lenovoIdeaPad.png" alt="lenovo idea pad">
              <h5 class="mb-2">Lenovo Idea Pad Slim 3-15</h5>
              <br>
              <p class="text-muted leftprice">Cena: 2099 PLN</p>
            </div>
          </div>

          <div class="col-md-4 product-card">
            <div class="product">
              <img src="./css/img/lenovoIdeaPad.png" alt="lenovo idea pad">
              <h5 class="mb-2">Lenovo Idea Pad Slim 3-15</h5>
              <br>
              <p class="text-muted leftprice">Cena: 2099 PLN</p>
            </div>
          </div>

          <div class="col-md-4 product-card">
            <div class="product">
              <img src="./css/img/lenovoIdeaPad.png" alt="lenovo idea pad">
              <h5 class="mb-2">Lenovo Idea Pad Slim 3-15</h5>
              <br>
              <p class="text-muted leftprice">Cena: 2099 PLN</p>
            </div>
          </div>

          <div class="col-md-4 product-card">
            <div class="product">
              <img src="./css/img/lenovoIdeaPad.png" alt="lenovo idea pad">
              <h5 class="mb-2">Lenovo Idea Pad Slim 3-15</h5>
              <br>
              <p class="text-muted leftprice">Cena: 2099 PLN</p>
            </div>
          </div>

          <div class="col-md-4 product-card">
            <div class="product">
              <img src="./css/img/lenovoIdeaPad.png" alt="lenovo idea pad">
              <h5 class="mb-2">Lenovo Idea Pad Slim 3-15</h5>
              <br>
              <p class="text-muted leftprice">Cena: 2099 PLN</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>