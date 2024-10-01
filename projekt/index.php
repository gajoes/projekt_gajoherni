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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-elements-font">
        <div class="container-fluid">
        <a class="navbar-brand">
            <img src="https://www.tygodniksiedlecki.com/wp-content/uploads/2023/06/1679304184007_466747_337016932_521814090125248_6226818314851252904_n.jpg" width="30" height="30" class="d-inline-block align-top brand-logo-sizing" alt="Jurzyk">
        <a class="navbar-brand navbar-custom-font">Sklep</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
    <div class="d-flex justify-content-center">
      <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRW2v0bE_CpovbGGkZN1LTbwCwvvz6Y6OJcyw&s" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>First slide label</h5>
              <p>Some representative placeholder content for the first slide.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://www.sportdata.org/kickboxing/competitor_pics/105423.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Second slide label</h5>
              <p>Some representative placeholder content for the first slide.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://www.tygodniksiedlecki.com/wp-content/uploads/2023/06/1679304184007_466747_337016932_521814090125248_6226818314851252904_n.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Third slide label</h5>
              <p>Some representative placeholder content for the first slide.</p>
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

  <div class="d-block card-product">
    <div class="card w-50 mb-3">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Button</a>
      </div>
    </div>
    
    <div class="card w-50">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Button</a>
      </div>
    </div>
  </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>