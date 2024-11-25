<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$wiadomosc = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
    $tytul = $_POST['tytul'];
    $tresc = $_POST['tresc'];

    $query = $conn->prepare("INSERT INTO aktualnosci (tytul, tresc) VALUES (?, ?)");
    $query->bind_param("ss", $tytul, $tresc);

    if ($query->execute()) {
        $wiadomosc = "Aktualność dodana!";
    } else {
        $wiadomosc = "Nie da się dodać aktualności!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_news'])) {
    $id = $_POST['id'];
    $tytul = $_POST['tytul'];
    $tresc = $_POST['tresc'];

    $query = $conn->prepare("UPDATE aktualnosci SET tytul = ?, tresc = ? WHERE id_aktualnosci = ?");
    $query->bind_param("ssi", $tytul, $tresc, $id);

    if ($query->execute()) {
        $wiadomosc = "Aktualność została edytowana!";
    } else {
        $wiadomosc = "Nie da się edytować aktualności!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_news'])) {
    $id = $_POST['id'];

    $query = $conn->prepare("DELETE FROM aktualnosci WHERE id_aktualnosci = ?");
    $query->bind_param("i", $id);

    if ($query->execute()) {
        $wiadomosc = "Aktualność została usunięta!";
    } else {
        $wiadomosc = "Nie da się usunąć aktualności!";
    }
}

$query = $conn->prepare("SELECT * FROM aktualnosci ORDER BY data_utworzenia DESC");
$query->execute();
$aktualnosci = $query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie aktualnościami</title>
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
        <h2 class="text-center">Lista aktualności</h2>
        <form method="POST" class="mb-4">
            <h4>Dodaj nową aktualność</h4>
            <div class="mb-3">
                <label for="tytul" class="form-label">Tytuł</label>
                <input type="text" class="form-control" id="tytul" name="tytul" required>
            </div>
            <div class="mb-3">
                <label for="tresc" class="form-label">Treść</label>
                <textarea class="form-control" id="tresc" name="tresc" rows="3" required></textarea>
            </div>
            <button type="submit" name="add_news" class="btn btn-success">Dodaj aktualność</button>
        </form>
        <table class="table table-light table-hover border">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tytuł</th>
                    <th>Treść</th>
                    <th>Data</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($aktualnosc = $aktualnosci->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aktualnosc['id_aktualnosci']); ?></td>
                        <td><?php echo htmlspecialchars($aktualnosc['tytul']); ?></td>
                        <td><?php echo htmlspecialchars(substr($aktualnosc['tresc'], 0, 50)); ?></td>
                        <td><?php echo htmlspecialchars($aktualnosc['data_utworzenia']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $aktualnosc['id_aktualnosci']; ?>">
                                <input type="text" name="tytul"
                                    value="<?php echo htmlspecialchars($aktualnosc['tytul']); ?>"
                                    class="form-control form-control-sm mb-1" required>
                                <textarea name="tresc" class="form-control form-control-sm mb-1" rows="2"
                                    required><?php echo htmlspecialchars($aktualnosc['tresc']); ?></textarea>
                                <button type="submit" name="edit_news"
                                    class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $aktualnosc['id_aktualnosci']; ?>">
                                <button type="submit" name="delete_news" class="btn btn-danger btn-sm w-100">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>