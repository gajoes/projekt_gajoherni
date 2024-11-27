<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$wiadomosc = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nr_tel=$_POST['nr_tel'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $notatka = $_POST['notatka'];

    $query = $conn->prepare("INSERT INTO uzytkownicy (username, email, haslo, notatka) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss", $username, $email, $password, $notatka);

    if ($query->execute()){
        $user_id=$conn->insert_id;

        $query_tel=$conn->prepare("INSERT INTO kontakty (nr_tel, id_uzytkownika) VALUES (?, ?)");
        $query_tel->bind_param("si",$nr_tel,$user_id);

        if ($query_tel->execute()){
            $wiadomosc="Użytkownik został dodany!";
        }else{
            $wiadomosc="Błąd podczas dodawania numeru telefonu!";
        }
    }else{
        $wiadomosc="Błąd podczas dodawania użytkownika!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nr_tel=$_POST['nr_tel'];
    $notatka = $_POST['notatka'];

    $query = $conn->prepare("UPDATE uzytkownicy SET username = ?, email = ?, notatka = ? WHERE id_uzytkownika = ?");
    $query->bind_param("sssi", $username, $email, $notatka, $id);

    if ($query->execute()){
        $query_tel=$conn->prepare("UPDATE kontakty SET nr_tel = ? WHERE id_uzytkownika = ?");
        $query_tel->bind_param("si",$nr_tel, $id);
        if ($query_tel->execute()){
            $wiadomosc="Dane użytkownika zostały zapisane!";
        }else{
            $wiadomosc="Błąd podczas aktualizacji numeru telefonu!";
        }
    }else{
        $wiadomosc="Błąd podczas edycji użytkownika!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $id = $_POST['id'];
    $query_tel=$conn->prepare("DELETE FROM kontakty WHERE id_uzytkownika = ?");
    $query_tel->bind_param("i", $id);
    $query_tel->execute();
    $query = $conn->prepare("DELETE FROM uzytkownicy WHERE id_uzytkownika = ?");
    $query->bind_param("i", $id);

    if ($query->execute()){
        $wiadomosc="Użytkownik został usunięty!";
    } else {
        $wiadomosc="Błąd podczas usuwania użytkownika!";
    }
}
$query = $conn->prepare("
    SELECT u.id_uzytkownika, u.username, u.email, k.nr_tel, u.notatka
    FROM uzytkownicy u
    LEFT JOIN kontakty k ON u.id_uzytkownika = k.id_uzytkownika
");
$query->execute();
$users = $query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie użytkownikami</title>
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
                <h2 class="card-title">Dodaj użytkownika</h2>
                <form method="POST" class="row g-3">
                    <div class="col-md-2">
                        <input type="text" name="username" class="form-control" placeholder="Nazwa użytkownika" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                    </div>
                    <div class="col-md-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="nr_tel" class="form-control" placeholder="Numer telefonu" pattern="\d{9,15}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="password" name="password" class="form-control" placeholder="Hasło" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="notatka" class="form-control" placeholder="Notatka" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+">
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="add_user" class="btn btn-primary w-50 buy">Dodaj
                            użytkownika</button>
                    </div>
                </form>
            </div>
        </div>

        <h2 class="text-center">Lista użytkowników</h2>
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nazwa użytkownika</th>
                    <th>Email</th>
                    <th>Numer telefonu</th>
                    <th>Notatka</th>
                    <th>Zmiany</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id_uzytkownika']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['nr_tel']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['notatka']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $user['id_uzytkownika']; ?>">
                                <input type="text" name="username"
                                    value="<?php echo htmlspecialchars($user['username']); ?>"
                                    class="form-control form-control-sm mb-1" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                                    class="form-control form-control-sm mb-1" required>
                                <input type="nr_tel" name="nr_tel" value="<?php echo htmlspecialchars($user['nr_tel']); ?>"
                                    class="form-control form-control-sm mb-1" pattern="\d{9,15}" required>
                                <input type="text" name="notatka" placeholder="notatka"
                                    value="<?php echo htmlspecialchars($user['notatka']); ?>"
                                    class="form-control form-control-sm mb-1">
                                <button type="submit" name="edit_user"
                                    class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $user['id_uzytkownika']; ?>">
                                <button type="submit" name="delete_user" class="btn btn-danger btn-sm w-100">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>