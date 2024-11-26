<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
  header("Location: login.php");
  exit();
}

if (isset($_COOKIE['user_id'])) {
  $_SESSION['user_id'] = $_COOKIE['user_id'];
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT u.username,u.email,u.imie,u.nazwisko,k.nr_tel,a.ulica,a.nr_domu,a.nr_mieszkania,a.miasto,a.kod_pocztowy
FROM uzytkownicy u
LEFT JOIN adresy a ON u.id_uzytkownika=a.id_uzytkownika
LEFT JOIN kontakty k ON u.id_uzytkownika=k.id_uzytkownika
WHERE u.id_uzytkownika=?");

$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $imie = $_POST['imie'];
  $nazwisko = $_POST['nazwisko'];
  $nr_tel = $_POST['nr_tel'];
  $ulica = $_POST['ulica'];
  $nr_domu = $_POST['nr_domu'];
  $nr_mieszkania = $_POST['nr_mieszkania'] ?? null;
  $miasto = $_POST['miasto'];
  $kod_pocztowy = $_POST['kod_pocztowy'];

  $updateUser = $conn->prepare("UPDATE uzytkownicy SET imie=?,nazwisko=? WHERE id_uzytkownika=?");
  $updateUser->bind_param("ssi", $imie, $nazwisko, $user_id);
  $updateUser->execute();

  $updateContact = $conn->prepare("REPLACE INTO kontakty (nr_tel,email,id_uzytkownika) VALUES (?,?,?)");
  $updateContact->bind_param("ssi", $nr_tel, $user['email'], $user_id);
  $updateContact->execute();

  $updateAddress = $conn->prepare("REPLACE INTO adresy (ulica,nr_domu,nr_mieszkania,miasto,kod_pocztowy,id_uzytkownika) VALUES (?,?,?,?,?,?)");
  $updateAddress->bind_param("sssssi", $ulica, $nr_domu, $nr_mieszkania, $miasto, $kod_pocztowy, $user_id);
  $updateAddress->execute();

  $_SESSION['update_success'] = "Dane zostały pomyślnie zaktualizowane!";
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
  <div id="popup"
    style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background-color:#28a745; color:white; padding:15px; border-radius:5px; z-index:1000;">
    <span id="popup-message"></span>
  </div>

  <div class="container mt-5">
    <h2 class="text-center text-primary">Witamy, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <h4 class="text-center mb-4">Jeżeli masz chwilę czasu, uzupełnij dane konta podając resztę potrzebnych informacji!
    </h4>

    <div class="content-wrapper">
      <div class="form-container">
        <form method="POST" action="" class="mx-auto" style="max-width: 600px;">
          <div class="form-group mb-3">
            <label for="imie" class="form-label">Imię</label>
            <input type="text" class="form-control" id="imie" name="imie"
              value="<?php echo htmlspecialchars($user['imie']); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="nazwisko" class="form-label">Nazwisko</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko"
              value="<?php echo htmlspecialchars($user['nazwisko']); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="nr_tel" class="form-label">Numer telefonu</label>
            <input type="text" class="form-control" id="nr_tel" name="nr_tel"
              value="<?php echo htmlspecialchars($user['nr_tel'] ?? ''); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="ulica" class="form-label">Ulica</label>
            <input type="text" class="form-control" id="ulica" name="ulica"
              value="<?php echo htmlspecialchars($user['ulica'] ?? ''); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="nr_domu" class="form-label">Numer domu</label>
            <input type="text" class="form-control" id="nr_domu" name="nr_domu"
              value="<?php echo htmlspecialchars($user['nr_domu'] ?? ''); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="nr_mieszkania" class="form-label">Numer mieszkania (opcjonalnie)</label>
            <input type="text" class="form-control" id="nr_mieszkania" name="nr_mieszkania"
              value="<?php echo htmlspecialchars($user['nr_mieszkania'] ?? ''); ?>">
          </div>
          <div class="form-group mb-3">
            <label for="miasto" class="form-label">Miasto</label>
            <input type="text" class="form-control" id="miasto" name="miasto"
              value="<?php echo htmlspecialchars($user['miasto'] ?? ''); ?>" required>
          </div>
          <div class="form-group mb-3">
            <label for="kod_pocztowy" class="form-label">Kod pocztowy</label>
            <input type="text" class="form-control" id="kod_pocztowy" name="kod_pocztowy"
              value="<?php echo htmlspecialchars($user['kod_pocztowy'] ?? ''); ?>" required>
          </div>
          <button type="submit" class="btn btn-success w-100 mb-3">Zaktualizuj dane</button>
        </form>
      </div>
      <div class="lists-container">
        <h2>Lista ulubionych przedmiotów</h2>
        <?php
        $ulubione_kw = $conn->prepare("SELECT ulubione.id_ulubione,produkty.nazwa FROM ulubione 
                                       JOIN produkty ON ulubione.id_produktu =produkty.id_produktu
                                       WHERE ulubione.id_uzytkownika =?");
        $ulubione_kw->bind_param("i", $user_id);
        $ulubione_kw->execute();
        $ulubione_wynik = $ulubione_kw->get_result();

        if ($ulubione_wynik->num_rows > 0) {
          echo "<ul class='list-group'>";
          while ($row = $ulubione_wynik->fetch_assoc()) {
            echo "<li class='list-group-item'>" . htmlspecialchars($row['nazwa']) . "</li>";
          }
          echo "</ul>";
        } else {
          echo "<p>Nie masz żadnych ulubionych przedmiotów.</p>";
        }
        $ulubione_kw->close();
        ?>

        <h2 class="mt-5">Lista zamówień</h2>
        <?php
        $zamowienia_kw = $conn->prepare("SELECT id_zamowienia,data_zamowienia, username,email,imie,nazwisko FROM zamowienia 
                                        WHERE id_uzytkownika =?");
        $zamowienia_kw->bind_param("i", $user_id);
        $zamowienia_kw->execute();
        $zamowienia_wynik = $zamowienia_kw->get_result();

        if ($zamowienia_wynik->num_rows > 0) {
          echo "<table class='table table-striped'>";
          echo "<thead><tr><th>ID Zamówienia</th><th>Data Zamówienia</th><th>Username</th><th>Email</th><th>Imię</th><th>Nazwisko</th></tr></thead><tbody>";
          while ($row = $zamowienia_wynik->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['id_zamowienia']) . "</td>
                      <td>" . htmlspecialchars($row['data_zamowienia']) . "</td>
                      <td>" . htmlspecialchars($row['username']) . "</td>
                      <td>" . htmlspecialchars($row['email']) . "</td>
                      <td>" . htmlspecialchars($row['imie']) . "</td>
                      <td>" . htmlspecialchars($row['nazwisko']) . "</td>
                  </tr>";
          }
          echo "</tbody></table>";
        } else {
          echo "<p>Nie masz żadnych zamówień.</p>";
        }
        $zamowienia_kw->close();
        ?>
        <br>
        <a href="wyloguj.php">
          <button type="button" class="btn btn-secondary w-100">Wyloguj</button>
        </a>
      </div>
    </div>
  </div>

  <script>
    window.onload = function () {
      <?php if (isset($_SESSION['update_success'])): ?>
        document.getElementById('popup-message').textContent = "<?php echo $_SESSION['update_success']; ?>";
        document.getElementById('popup').style.display = 'block';

        setTimeout(function () {
          document.getElementById('popup').style.display = 'none';
        }, 3000);

        <?php unset($_SESSION['update_success']); ?>
      <?php endif; ?>
    };
  </script>

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Arial', sans-serif;
    }

    .navbar-custom-font {
      font-family: 'Arial', sans-serif;
    }

    .form-group input {
      border-radius: 10px;
    }

    .btn {
      border-radius: 8px;
    }

    table th,
    table td {
      text-align: center;
    }

    /* Ustawienie kontenera z formularzem po lewej stronie i listami po prawej */
    .content-wrapper {
      display: flex;
      justify-content: space-between;
      /* Ustawienie elementów na lewą i prawą stronę */
      gap: 10px;
      /* Odstęp między sekcjami */
      margin-top: 10px;
    }

    .form-container {
      width: 48%;
      /* Szerokość formularza */
    }

    .lists-container {
      width: 48%;
      /* Szerokość sekcji z listami */
    }

    /* Dostosowanie tabeli i list */
    table {
      width: 100%;
    }

    .list-group-item {
      padding: 10px;
      font-size: 1rem;
    }

    .form-control {
      height: 37px;
    }
  </style>
</body>


</html>