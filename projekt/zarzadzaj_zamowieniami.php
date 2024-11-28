<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$wiadomosc = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_order'])) {
    $id_zamowienia = $_POST['id'];
    $email = $_POST['email'];
    $nr_tel = $_POST['nr_tel'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $status = $_POST['status'];

    $query_user = $conn->prepare("SELECT id_uzytkownika FROM zamowienia WHERE id_zamowienia = ?");
    $query_user->bind_param("i", $id_zamowienia);
    $query_user->execute();
    $result = $query_user->get_result();
    $user = $result->fetch_assoc();
    $id_uzytkownika = $user['id_uzytkownika'];

    $query = $conn->prepare("UPDATE zamowienia SET email = ?, imie = ?, nazwisko = ?, status =? WHERE id_zamowienia = ?");
    $query->bind_param("sssis", $email, $imie, $nazwisko, $id_zamowienia, $status);

    if ($query->execute()){
        $query_tel=$conn->prepare("UPDATE kontakty SET nr_tel = ? WHERE id_uzytkownika = ?");
        $query_tel->bind_param("si",$nr_tel,$id_uzytkownika);
        if ($query_tel->execute()){
            $wiadomosc="Dane zamówienia zostały zapisane!";
        }else{
            $wiadomosc="Błąd podczas aktualizacji numeru telefonu!";
        }
    }else{
        $wiadomosc="Błąd podczas edycji zamówienia!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $id = $_POST['id'];

    $query_tel=$conn->prepare("DELETE FROM kontakty WHERE id_uzytkownika = ?");
    $query_tel->bind_param("i", $id);
    $query_tel->execute();
    $query = $conn->prepare("DELETE FROM uzytkownicy WHERE id_uzytkownika = ?");
    $query->bind_param("i", $id);

    if ($query->execute()) {
        $wiadomosc = "Zamówienie zostało usunięte!";
    } else {
        $wiadomosc = "Błąd podczas usuwania zamówienia!";
    }
}

$query = $conn->prepare("SELECT z.id_zamowienia, u.username, z.email, z.imie, z.nazwisko, z.data_zamowienia, z.id_uzytkownika, 
                        GROUP_CONCAT(DISTINCT CONCAT(p.nazwa, ' (Ilość: ', zp.ilosc, ')') SEPARATOR ', ') AS produkty, k.nr_tel, z.status, 
                        CONCAT(za.ulica, ' ', za.nr_domu, '/', za.nr_mieszkania, ', ', za.miasto, ' ', za.kod_pocztowy) AS adres FROM zamowienia z
                        LEFT JOIN zamowienia_produkty zp ON z.id_zamowienia = zp.id_zamowienia
                        LEFT JOIN produkty p ON zp.id_produktu = p.id_produktu
                        LEFT JOIN zamowienia_adresy za ON z.id_zamowienia = za.id_zamowienia
                        LEFT JOIN kontakty k ON z.id_uzytkownika = k.id_uzytkownika
                        LEFT JOIN uzytkownicy u ON z.id_uzytkownika = u.id_uzytkownika
                        GROUP BY z.id_zamowienia");
$szukaj=$_GET['szukaj']??'';
$query_szukaj="SELECT z.id_zamowienia,u.username,z.email,z.imie,z.nazwisko,z.data_zamowienia,z.id_uzytkownika,
GROUP_CONCAT(DISTINCT CONCAT(p.nazwa,' (Ilość: ',zp.ilosc,')') SEPARATOR ', ') AS produkty,k.nr_tel,z.status,
CONCAT(za.ulica,' ',za.nr_domu,'/',za.nr_mieszkania,', ',za.miasto,' ',za.kod_pocztowy) AS adres FROM zamowienia z
LEFT JOIN zamowienia_produkty zp ON z.id_zamowienia=zp.id_zamowienia
LEFT JOIN produkty p ON zp.id_produktu=p.id_produktu
LEFT JOIN zamowienia_adresy za ON z.id_zamowienia=za.id_zamowienia
LEFT JOIN kontakty k ON z.id_uzytkownika=k.id_uzytkownika
LEFT JOIN uzytkownicy u ON z.id_uzytkownika=u.id_uzytkownika";

if(!empty($szukaj)){
$szukaj_warunki='%'.$szukaj.'%';
$query_szukaj.=" WHERE z.email LIKE ? OR z.imie LIKE ? OR z.nazwisko LIKE ? OR z.status LIKE ? OR u.username LIKE ? OR k.nr_tel LIKE ? OR p.nazwa LIKE ? OR za.ulica LIKE ? OR z.id_zamowienia LIKE ?";
}
$query_szukaj.=" GROUP BY z.id_zamowienia";

$query=$conn->prepare($query_szukaj);

if(!empty($szukaj)){
$query->bind_param("sssssssss",$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki);
}
$query->execute();
$orders = $query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie zamówieniami</title>
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
        <h2 class="text-center">Lista zamówień</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Numer telefonu</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Data zamówienia</th>
                    <th>Produkt</th>
                    <th>Adres</th>
                    <th>ID użytkownika</th>
                    <th>Status</th>
                    <th>Zmiany</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id_zamowienia']); ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['nr_tel']); ?></td>
                        <td><?php echo htmlspecialchars($order['imie']); ?></td>
                        <td><?php echo htmlspecialchars($order['nazwisko']); ?></td>
                        <td><?php echo htmlspecialchars($order['data_zamowienia']); ?></td>
                        <td><?php echo htmlspecialchars($order['produkty']); ?></td>
                        <td><?php echo htmlspecialchars($order['adres']); ?></td>
                        <td><?php echo htmlspecialchars($order['id_uzytkownika']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td>
                        <form method="POST" class="d-inline zmiany">
                            <input type="hidden" name="id" value="<?php echo $order['id_zamowienia']; ?>">
                            <input type="text" name="username" placeholder="Nazwa użytkownika" value="<?php echo htmlspecialchars($order['username']); ?>"
                                class="form-control form-control-sm mb-1" readonly>
                            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($order['email']); ?>"
                                class="form-control form-control-sm mb-1" required>
                            <input type="text" name="nr_tel" placeholder="Numer telefonu" value="<?php echo htmlspecialchars($order['nr_tel']); ?>"
                                class="form-control form-control-sm mb-1" pattern="\d{9,15}" required>
                            <input type="text" name="imie" placeholder="Imie" value="<?php echo htmlspecialchars($order['imie']); ?>"
                                class="form-control form-control-sm mb-1" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                            <input type="text" name="nazwisko" placeholder="Nazwisko" value="<?php echo htmlspecialchars($order['nazwisko']); ?>"
                                class="form-control form-control-sm mb-1" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                            <select name="status" class="form-control form-control-sm mb-1">
                                <option value="Oczekujące" <?php if ($order['status'] == 'Oczekujące') echo 'selected'; ?>>Oczekujące</option>
                                <option value="W trakcie" <?php if ($order['status'] == 'W trakcie') echo 'selected'; ?>>W trakcie</option>
                                <option value="Zrealizowane" <?php if ($order['status'] == 'Zrealizowane') echo 'selected'; ?>>Zrealizowane</option>
                                <option value="Anulowane" <?php if ($order['status'] == 'Anulowane') echo 'selected'; ?>>Anulowane</option>
                            </select>
                            <button type="submit" name="edit_order" class="btn btn-warning btn-sm w-100">Edytuj</button>
                        </form>

                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $order['id_zamowienia']; ?>">
                                <button type="submit" name="delete_order" class="btn btn-danger btn-sm w-100">Usuń</button>
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
</body>]
</html>