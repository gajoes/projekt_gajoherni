<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$wiadomosc = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $nazwa_dostawcy = $_POST['nazwa_dostawcy'];
    $kraj_pochodzenia = $_POST['kraj_pochodzenia'];

    $query = $conn->prepare("INSERT INTO dostawcy (nazwa_dostawcy, kraj_pochodzenia) VALUES (?, ?)");
    $query->bind_param("ss", $nazwa_dostawcy, $kraj_pochodzenia);

    if ($query->execute()) {
        $wiadomosc = "Dostawca został dodany!";
    } else {
        $wiadomosc = "Błąd podczas dodawania dostawcy!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_supplier'])) {
    $id_dostawcy = $_POST['id_dostawcy'];
    $nazwa_dostawcy = $_POST['nazwa_dostawcy'];
    $kraj_pochodzenia = $_POST['kraj_pochodzenia'];

    $query = $conn->prepare("UPDATE dostawcy SET nazwa_dostawcy = ?, kraj_pochodzenia = ? WHERE id_dostawcy = ?");
    $query->bind_param("ssi", $nazwa_dostawcy, $kraj_pochodzenia, $id_dostawcy);

    if ($query->execute()) {
        $wiadomosc = "Dane dostawcy zostały zapisane!";
    } else {
        $wiadomosc = "Błąd podczas edycji dostawcy!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_supplier'])) {
    $id_dostawcy = $_POST['id_dostawcy'];

    $query = $conn->prepare("DELETE FROM dostawcy WHERE id_dostawcy = ?");
    $query->bind_param("i", $id_dostawcy);

    if ($query->execute()) {
        $wiadomosc = "Dostawca został usunięty!";
    } else {
        $wiadomosc = "Błąd podczas usuwania dostawcy!";
    }
}

$query = $conn->prepare("SELECT id_dostawcy, nazwa_dostawcy, kraj_pochodzenia FROM dostawcy");
$szukaj=$_GET['szukaj']??'';
$query_szukaj="SELECT id_dostawcy, nazwa_dostawcy, kraj_pochodzenia FROM dostawcy";

if(!empty($szukaj)){
$szukaj_warunki='%'.$szukaj.'%';
$query_szukaj.=" WHERE nazwa_dostawcy LIKE ? OR kraj_pochodzenia LIKE ? OR id_dostawcy LIKE ?";
}

$query=$conn->prepare($query_szukaj);

if(!empty($szukaj)){
$query->bind_param("sss",$szukaj_warunki,$szukaj_warunki,$szukaj_warunki);
}
$query->execute();
$suppliers = $query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie dostawcami</title>
    <link rel="stylesheet" href="style.css">
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
                <h2 class="card-title">Dodaj dostawcę</h2>
                <form method="POST" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="nazwa_dostawcy" class="form-control" placeholder="Nazwa dostawcy" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="kraj_pochodzenia" class="form-control" placeholder="Kraj pochodzenia" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="add_supplier" class="btn btn-primary w-50 buy">Dodaj
                            dostawcę</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card bg-white mb-3 text-dark text-center border-light shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-3 justify-content-center">
            <div class="col-md-6">
                <input type="text" name="szukaj" class="form-control" placeholder="Wpisz, aby wyszukać..." value="<?php echo htmlspecialchars($_GET['szukaj'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 buy">Szukaj</button>
            </div>
        </form>
    </div>
</div>
        <h2 class="text-center">Lista dostawców</h2>
        <table class="table table-light table-hover border">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nazwa dostawcy</th>
                    <th>Kraj pochodzenia</th>
                    <th>Zmiany</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($supplier = $suppliers->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($supplier['id_dostawcy']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['nazwa_dostawcy']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['kraj_pochodzenia']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id_dostawcy" value="<?php echo $supplier['id_dostawcy']; ?>">
                                <input type="text" name="nazwa_dostawcy" placeholder="Nazwa dostawcy"
                                    value="<?php echo htmlspecialchars($supplier['nazwa_dostawcy']); ?>"
                                    class="form-control form-control-sm mb-1" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                                <input type="text" name="kraj_pochodzenia" placeholder="Kraj pochodzenia dostawcy"
                                    value="<?php echo htmlspecialchars($supplier['kraj_pochodzenia']); ?>"
                                    class="form-control form-control-sm mb-1" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                                <button type="submit" name="edit_supplier"
                                    class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id_dostawcy" value="<?php echo $supplier['id_dostawcy']; ?>">
                                <button type="submit" name="delete_supplier"
                                    class="btn btn-danger btn-sm w-100">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        
        body{
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container{
            max-width: 95%;
            margin: 0 auto;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td{
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th{
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .btn{
            margin-top: 5px;
        }

        .zmiany input, .zmiany select{
            margin-bottom: 5px;
        }

    </style>
</body>
</html>