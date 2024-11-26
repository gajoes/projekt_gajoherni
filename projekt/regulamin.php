<?php
require_once 'database.php';
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regulamin</title>

  <link rel="stylesheet" href="./css/style.css">
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
  <div class="container regulamin-container">
    <h1 class="regulamin-title">Regulamin Usługi</h1>
    <br>
    <br>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="2" class="text-center">Treść Regulaminu</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row" class="col-2">1. Wstęp</th>
          <td class="col-10">
            Niniejszy regulamin określa zasady korzystania z naszej usługi, która jest dostępna przez naszą platformę
            internetową.
            Korzystając z naszej usługi, użytkownicy muszą zaakceptować warunki zawarte w regulaminie. Usługa jest
            dostępna
            dla wszystkich użytkowników, którzy spełniają określone wymagania i są w pełni świadomi zasad korzystania z
            platformy.
            Zachęcamy do zapoznania się ze szczegółami dotyczącymi korzystania z platformy przed jej użyciem.
            Korzystanie z usługi
            jest równoznaczne z akceptacją warunków regulaminu.
          </td>
        </tr>

        <tr>
          <th scope="row">2. Warunki korzystania</th>
          <td>
            Usługa jest dostępna tylko dla osób pełnoletnich, które ukończyły 18. rok życia. Użytkownik, który korzysta
            z naszej platformy,
            musi posiadać pełną zdolność do czynności prawnych i ponosi odpowiedzialność za wszelkie działania
            podejmowane w ramach
            korzystania z usługi. Zarejestrowany użytkownik ma obowiązek wprowadzenia prawdziwych danych podczas
            rejestracji i aktualizacji swojego konta,
            jeśli zajdą jakiekolwiek zmiany. Każdy użytkownik ma prawo do usunięcia swojego konta w każdej chwili.
            Należy również przestrzegać
            zasad dotyczących bezpieczeństwa korzystania z platformy, w tym utrzymania hasła w poufności.
          </td>
        </tr>
        <tr>
          <th scope="row">3. Odpowiedzialność</th>
          <td>
            Platforma zapewnia dostęp do treści udostępnianych przez użytkowników oraz innych dostawców treści, jednak
            nie ponosi
            odpowiedzialności za jakiekolwiek konsekwencje wynikające z korzystania z tych treści. Użytkownicy platformy
            są
            odpowiedzialni za swoje decyzje i działania, w tym za publikowanie treści, ich wykorzystanie oraz interakcje
            z innymi
            użytkownikami. W szczególności, platforma nie odpowiada za szkody spowodowane przez nielegalne lub szkodliwe
            treści,
            które mogą być publikowane przez innych użytkowników. Użytkownicy są zobowiązani do przestrzegania
            obowiązujących
            przepisów prawa oraz norm etycznych w trakcie korzystania z usługi.
          </td>
        </tr>
        <tr>
          <th scope="row">4. Zasady prywatności</th>
          <td>
            Ochrona prywatności naszych użytkowników jest dla nas priorytetem. W tym celu przestrzegamy wszystkich
            przepisów dotyczących
            ochrony danych osobowych, w tym RODO (Rozporządzenie o Ochronie Danych Osobowych) oraz innych krajowych i
            międzynarodowych
            regulacji w zakresie ochrony danych. Zbieramy dane osobowe użytkowników tylko w niezbędnym zakresie, aby
            umożliwić
            korzystanie z naszej platformy. Użytkownik ma prawo do wglądu w swoje dane osobowe, ich modyfikacji, a także
            do żądania ich
            usunięcia. Szczegóły dotyczące ochrony danych osobowych można znaleźć w naszej Polityce Prywatności, która
            jest dostępna
            na naszej stronie internetowej. Platforma nie udostępnia danych użytkowników osobom trzecim bez ich zgody, z
            wyjątkiem
            przypadków przewidzianych przez prawo.
          </td>
        </tr>

      </tbody>
    </table>
    <footer class="bg-light text-center py-4 mt-5">
      <p>&copy; 2024 BYTE . Wszystkie prawa zastrzeżone.</p>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>