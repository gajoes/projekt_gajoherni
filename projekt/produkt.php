<?php
require_once 'database.php';

if (isset($_GET['id_produktu'])) {
  $id_produktu = intval($_GET['id_produktu']);
  $query = "SELECT * FROM produkty WHERE id_produktu =?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id_produktu);
  $stmt->execute();
  $result = $stmt->get_result();
  $produkt = $result->fetch_assoc();

  if (!$produkt) {
    die("Nie znaleziono takiego produktu.");
  }
} else {
  die("Niepoprawne ID produktu.");
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($produkt['nazwa']); ?> - Szczegóły Produktu</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="content-wrapper">
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
                <a class="nav-link" href="./index.php">Strona główna <span class="sr-only">(Aktualnie
                    włączone)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./about.php">O nas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./kontakt.php">Kontakt</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php">Zakupy</a>
              </li>
            </ul>
          </div>
      </div>
    </nav>
    <br>
    <br>
    <br>
    <br>
    <div class="containerArrow">
      <a class="strzalka" href="index.php"><i class="arrow right"></i>Wróć</a>
    </div>
    <div class="container mt-4 main-content">
      <div class="row justify-content-center">
        <div class="col-md-6 d-flex justify-content-center produkt-zdjecie">
          <img src="<?php echo htmlspecialchars($produkt['zdjecie']); ?>"
            alt="<?php echo htmlspecialchars($produkt['nazwa']); ?>" class="img-fluid rounded">
        </div>
        <div class="col-md-6 d-flex justify-content-center produkt-info">
          <div>
            <br>
            <br>
            <h1><?php echo htmlspecialchars($produkt['nazwa']); ?></h1>
            <p class="text-muted">Cena: <?php echo number_format($produkt['cena'], 2, ',', ' '); ?> PLN</p>
            <p class="parametry">Parametry: <?php echo htmlspecialchars($produkt['parametry']); ?></p>
            <form method="POST" action="dodaj_do_koszyka.php" class="add-to-cart-form">
              <input type="hidden" name="id_produktu" value="<?php echo $produkt['id_produktu']; ?>">
              <button type="submit" class="btn btn-primary buy">Dodaj do koszyka</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-4 stopka">
      <div class="container text-center">
        <p>&copy; 2024 BYTE. Wszelkie prawa zastrzeżone.</p>
      </div>
    </footer>
  </div>

  <script>
    $(document).ready(function () {
      $('form[action="dodaj_do_koszyka.php"]').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
          url: 'dodaj_do_koszyka.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              showPopup(response.message, 'green');
            } else {
              showPopup(response.message, 'red');
            }
          },
          error: function () {
            showPopup('Wystąpił błąd podczas dodawania produktu do koszyka', 'red');
          }
        });
      });

      function showPopup(message, color) {
        var popup = $('<div class="popup-message"></div>').text(message).css({
          'background-color': color,
          'color': 'white',
          'padding': '10px',
          'position': 'fixed',
          'top': '100px',
          'left': '50%',
          'transform': 'translateX(-50%)',
          'z-index': '10000',
          'border-radius': '6px',
          'box-shadow': '0 2px 4px rgba(0, 0, 0, 0.2)',
          'text-align': 'center',
          'max-width': '300px',
          'display': 'none'
        });
        $('body').append(popup);
        popup.fadeIn().delay(2000).fadeOut(function () {
          $(this).remove();
        });
      }
    });
  </script>
    <style>
    html,
    body {
      height: 100%;
      margin: 0;
    }

    .content-wrapper {
      min-height: 100%;
      display: flex;
      flex-direction: column;
    }

    .main-content {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      margin-bottom: 200px;
    }

    footer {
      margin-top: auto;
    }

    .produkt-info {
      text-align: center;
    }

    .produkt-zdjecie img {
      width: 100%;
      height: auto;
      max-height: 600px;
      object-fit: contain;
    }

    .produkt-zdjecie {
      width: 100%;
      max-width: 900px;
      max-height: 190px;
      margin: 0 auto;
      padding: 10px;
    }

    .containerArrow {
      text-align: center;
    }

    @media (max-width: 768px) {
      .produkt-zdjecie {
        width: 100%;
        max-width: 100%;
        padding: 0;
      }

      .produkt-info {
        width: 100%;
      }
    }
  </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>