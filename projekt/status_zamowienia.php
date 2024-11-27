<?php
require_once 'database.php';

$status_zamowienia=null;
$error_message=null;

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $id_zamowienia=intval($_POST['id_zamowienia']);

    $query="SELECT p.zdjecie, p.nazwa, p.cena, p.parametry, z.status FROM zamowienia_produkty zp
        JOIN produkty p ON zp.id_produktu=p.id_produktu
        JOIN zamowienia z ON zp.id_zamowienia=z.id_zamowienia
        WHERE z.id_zamowienia =?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$id_zamowienia);
    $stmt->execute();
    $result=$stmt->get_result();

    if ($result->num_rows>0){
        $status_zamowienia=$result->fetch_all(MYSQLI_ASSOC);
    }else{
        $error_message="Nie znaleziono zamówienia z takim ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status zamówienia</title>
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
        <h2 class="text-center">Sprawdź status swojego zamówienia</h2>
        <form method="POST" class="text-center mt-4">
            <label for="id_zamowienia">Podaj ID zamówienia:</label>
            <input type="number" name="id_zamowienia" id="id_zamowienia" required class="form-control w-50 mx-auto">
            <button type="submit" class="btn btn-primary mt-3">Sprawdź</button>
        </form>

        <?php if ($error_message): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <?php if ($status_zamowienia): ?>
            <div class="order-details">
                <h3>Informacje o zamówieniu</h3>
                <?php foreach ($status_zamowienia as $produkt): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($produkt['zdjecie']); ?>" alt="<?php echo htmlspecialchars($produkt['nazwa']); ?>">
                        <h3><?php echo htmlspecialchars($produkt['nazwa']); ?></h3>
                        <p><strong>Cena:</strong> <?php echo number_format($produkt['cena'],2,',',' '); ?> PLN</p>
                        <p><strong>Parametry:</strong> <?php echo htmlspecialchars($produkt['parametry']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($produkt['status']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white py-4 mt-4 stopka">
        <div class="container text-center">
            <p>&copy; 2024 BYTE. Wszelkie prawa zastrzeżone.</p>
        </div>
    </footer>
    <style>
        .error-message {
            color: red;
            text-align: center;
        }

        .order-details {
            text-align: center;
            margin-top: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .product-card h3 {
            margin: 0 0 10px;
        }
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            width: 100%;
        }
    </style>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
