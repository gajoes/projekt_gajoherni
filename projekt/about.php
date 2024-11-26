<LI?php require_once 'database.php' ; ?>

  <!DOCTYPE html>
  <html lang="pl">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O nas</title>

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
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 navcwe">
          <h2 id="onasab">O nas</h2>
          <p>
            Jesteśmy nowoczesnym sklepem internetowym, który specjalizuje się w sprzedaży urządzeń technologicznych
            najwyższej jakości. Oferujemy szeroką gamę produktów, w tym najnowsze modele telefonów, komputerów,
            laptopów,
            tabletów oraz akcesoriów, które zaspokoją potrzeby zarówno osób prywatnych, jak i firm.
          </p>
          <p>
            Naszą misją jest dostarczanie klientom najnowszych technologii, które upraszczają życie, poprawiają komfort
            pracy i zapewniają doskonałe wrażenia z użytkowania. W naszej ofercie znajdują się produkty od renomowanych
            producentów, które cechują się niezawodnością, nowoczesnym designem i innowacyjnymi rozwiązaniami.
          </p>
          <p>
            Wszystkie urządzenia, które oferujemy, są starannie selekcjonowane, aby zapewnić naszym klientom pełną
            satysfakcję z zakupu. Dążymy do tego, by każdy klient znalazł u nas sprzęt idealnie dopasowany do swoich
            potrzeb, niezależnie od tego, czy szuka najnowszego telefonu, czy wydajnego komputera do pracy i rozrywki.
          </p>
          <p>
            Nasza firma to zespół pasjonatów technologii, którzy dbają o każdy szczegół – od dokładnego opisu produktów
            po
            szybkie i bezpieczne zakupy online. Staramy się, aby zakupy w naszym sklepie były przyjemnością i by nasza
            obsługa klienta spełniała najwyższe standardy.
          </p>
          <p>
            Zaufaj nam i odkryj najlepsze urządzenia technologiczne w atrakcyjnych cenach.
          </p>
        </div>

        <div class="col-md-6 navcwe">
          <img id="aboutusimg" src="./css/img/aboutus.png" alt="Zdjęcie sklepu" class="img-fluid rounded">
        </div>
      </div>
    </div>
    <br>
    <br>
    <footer class="bg-light text-center py-4 mt-5">
      <p>&copy; 2024 BYTE . Wszystkie prawa zastrzeżone.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>