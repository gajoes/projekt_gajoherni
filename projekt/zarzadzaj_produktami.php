<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$wiadomosc = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nazwa = $_POST['nazwa'];
    $id_kategorii = $_POST['id_kategorii'];
    $id_dostawcy = $_POST['id_dostawcy'];
    $cena = $_POST['cena'];

    $query = $conn->prepare("INSERT INTO produkty (nazwa, id_kategorii, id_dostawcy, cena) VALUES (?, ?, ?, ?)");
    $query->bind_param("siid", $nazwa, $id_kategorii, $id_dostawcy, $cena);

    if ($query->execute()) {
        $wiadomosc = "Produkt został dodany!";
    } else {
        $wiadomosc = "Błąd podczas dodawania produktu!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $nazwa = $_POST['nazwa'];
    $id_kategorii = $_POST['id_kategorii'];
    $id_dostawcy = $_POST['id_dostawcy'];
    $cena = $_POST['cena'];

    $query = $conn->prepare("UPDATE produkty SET nazwa = ?, id_kategorii = ?, id_dostawcy = ?, cena = ? WHERE id_produktu = ?");
    $query->bind_param("siidi", $nazwa, $id_kategorii, $id_dostawcy, $cena, $id);

    if ($query->execute()) {
        $wiadomosc = "Dane produktu zostały zapisane!";
    } else {
        $wiadomosc = "Błąd podczas edycji produktu!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $id = $_POST['id'];

    $query = $conn->prepare("DELETE FROM produkty WHERE id_produktu = ?");
    $query->bind_param("i", $id);

    if ($query->execute()) {
        $wiadomosc = "Produkt został usunięty!";
    } else {
        $wiadomosc = "Błąd podczas usuwania produktu!";
    }
}

$query = $conn->prepare("SELECT produkty.id_produktu, produkty.nazwa, Kategorie.id_kategorii, Kategorie.nazwa_kategorii, 
                         Dostawcy.id_dostawcy, Dostawcy.nazwa_dostawcy, produkty.cena
                         FROM produkty
                         LEFT JOIN Kategorie ON produkty.id_kategorii = Kategorie.id_kategorii
                         LEFT JOIN Dostawcy ON produkty.id_dostawcy = Dostawcy.id_dostawcy");
$query->execute();
$products = $query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie produktami</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
</head>

<body class="bg-light text-dark">
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-elements-font">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="./css/img/Tech.png" width="30" height="30" class="d-inline-block align-top brand-logo-sizing"
                    alt="Jurzyk">
                <a class="navbar-brand navbar-custom-font"><span class="logop1">B</span><span
                        class="logop2">Y</span><span class="logop3">T</span><span class="logop4">E</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
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
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-cart-shopping fa-xl fa-fw navicon"></i>
                    </a>
                </div>
        </div>
    </nav>
    <div class="containerArrow">
        <a class="strzalka" href="panel.php"><i class="arrow right"></i>Wróć</a>
    </div>
    <div class="container mt-5">
        <?php if (!empty($wiadomosc)): ?>
            <div class="alert alert-info text-center">
                <?php echo htmlspecialchars($wiadomosc); ?>
            </div>
        <?php endif; ?>
        <div class="card bg-white mb-5 text-dark text-center border-light shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Dodaj produkt</h2>
                <form method="POST" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="nazwa" class="form-control" placeholder="Nazwa produktu" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="id_kategorii" class="form-control" placeholder="ID Kategorii"
                            required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="id_dostawcy" class="form-control" placeholder="ID Dostawcy" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="cena" class="form-control" placeholder="Cena" required>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="add_product" class="btn btn-primary w-50">Dodaj produkt</button>
                    </div>
                </form>
            </div>
        </div>
        <h2 class="text-center">Lista produktów</h2>
        <table class="table table-light table-hover border">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Kategoria</th>
                    <th>Dostawca</th>
                    <th>Cena</th>
                    <th>Zmiany</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id_produktu']); ?></td>
                        <td><?php echo htmlspecialchars($product['nazwa']); ?></td>
                        <td><?php echo htmlspecialchars($product['nazwa_kategorii']); ?></td>
                        <td><?php echo htmlspecialchars($product['nazwa_dostawcy']); ?></td>
                        <td><?php echo htmlspecialchars($product['cena']); ?> PLN</td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $product['id_produktu']; ?>">
                                <input type="text" name="nazwa" value="<?php echo htmlspecialchars($product['nazwa']); ?>"
                                    class="form-control form-control-sm mb-1" required>
                                <input type="number" name="id_kategorii"
                                    value="<?php echo htmlspecialchars($product['id_kategorii']); ?>"
                                    class="form-control form-control-sm mb-1" required>
                                <input type="number" name="id_dostawcy"
                                    value="<?php echo htmlspecialchars($product['id_dostawcy']); ?>"
                                    class="form-control form-control-sm mb-1" required>
                                <input type="number" step="0.01" name="cena"
                                    value="<?php echo htmlspecialchars($product['cena']); ?>"
                                    class="form-control form-control-sm mb-1" required>
                                <button type="submit" name="edit_product"
                                    class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $product['id_produktu']; ?>">
                                <button type="submit" name="delete_product"
                                    class="btn btn-danger btn-sm w-100">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>