<?php
require_once 'database.php';
session_start();
if(!isset($_SESSION['admin_id']) && !isset($_SESSION['employee_id'])){
    header("Location: login.php");
    exit();
}

$wiadomosc="";
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_order'])){
    $id_zamowienia=$_POST['id'];
    $email=$_POST['email'];
    $nr_tel=$_POST['nr_tel'];
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];
    $status=$_POST['status'];

    $query_user=$conn->prepare("SELECT id_uzytkownika FROM zamowienia WHERE id_zamowienia = ?");
    $query_user->bind_param("i",$id_zamowienia);
    $query_user->execute();
    $result=$query_user->get_result();
    $user=$result->fetch_assoc();
    $id_uzytkownika=$user['id_uzytkownika'];

    $query=$conn->prepare("UPDATE zamowienia SET email =?, imie =?, nazwisko =?, status =? WHERE id_zamowienia =?");
    $query->bind_param("ssssi",$email,$imie,$nazwisko,$status,$id_zamowienia);
    if($query->execute()){
        $query_tel=$conn->prepare("UPDATE kontakty SET nr_tel =? WHERE id_uzytkownika =?");
        $query_tel->bind_param("si",$nr_tel,$id_uzytkownika);
        if($query_tel->execute()){
            $wiadomosc="Dane zamówienia zostały zapisane!";
            header("Location: zarzadzaj_zamowieniami.php?wiadomosc=".urlencode($wiadomosc));
            exit();
        }else{
            $wiadomosc="Błąd podczas aktualizacji numeru telefonu!";
        }
    }else{
        $wiadomosc="Błąd podczas edycji zamówienia!";
    }
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: zarzadzanie_zamowieniami.php");
    exit();
}

$id_zamowienia=intval($_GET['id']);
$query=$conn->prepare("SELECT z.id_zamowienia, u.username, z.email, z.imie, z.nazwisko, z.data_zamowienia, z.id_uzytkownika, 
                        GROUP_CONCAT(DISTINCT CONCAT(p.nazwa, ' (Ilość: ', zp.ilosc, ')') SEPARATOR ', ') AS produkty, 
                        k.nr_tel, z.status, 
                        CONCAT(za.ulica, ' ', za.nr_domu, '/', za.nr_mieszkania, ', ', za.miasto, ' ', za.kod_pocztowy) AS adres 
                        FROM zamowienia z
                        LEFT JOIN zamowienia_produkty zp ON z.id_zamowienia = zp.id_zamowienia
                        LEFT JOIN produkty p ON zp.id_produktu = p.id_produktu
                        LEFT JOIN zamowienia_adresy za ON z.id_zamowienia = za.id_zamowienia
                        LEFT JOIN kontakty k ON z.id_uzytkownika = k.id_uzytkownika 
                        LEFT JOIN uzytkownicy u ON z.id_uzytkownika = u.id_uzytkownika
                        WHERE z.id_zamowienia = ?
                        GROUP BY z.id_zamowienia");
$query->bind_param("i",$id_zamowienia);
$query->execute();
$zamowienie=$query->get_result()->fetch_assoc();

if(!$zamowienie){
    $wiadomosc="Nie znaleziono zamówienia o podanym ID.";
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja Zamówienia</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-elements-font">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="./css/img/Tech.png" width="30" height="30" class="d-inline-block align-top brand-logo-sizing" alt="Jurzyk">
                <a class="navbar-brand navbar-custom-font"><span class="logop1">B</span><span class="logop2">Y</span><span class="logop3">T</span><span class="logop4">E</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
    <br><br><br>
    <div class="containerArrow">
        <a class="strzalka" href="zarzadzanie_zamowieniami.php"><i class="arrow right"></i>Wróć</a>
    </div>
    <div class="container mt-5">
        <?php if(!empty($wiadomosc)): ?>
            <div class="alert alert-info text-center">
                <?php echo htmlspecialchars($wiadomosc); ?>
            </div>
        <?php endif; ?>
        <?php if($zamowienie): ?>
            <h2 class="text-center">Edycja Zamówienia o ID: <?php echo htmlspecialchars($zamowienie['id_zamowienia']); ?></h2>
            <form method="POST" class="mt-4">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($zamowienie['id_zamowienia']); ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Nazwa użytkownika</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($zamowienie['username']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($zamowienie['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nr_tel" class="form-label">Numer telefonu</label>
                    <input type="text" id="nr_tel" name="nr_tel" class="form-control" value="<?php echo htmlspecialchars($zamowienie['nr_tel']); ?>" pattern="\d{9,15}" required>
                </div>
                <div class="mb-3">
                    <label for="imie" class="form-label">Imię</label>
                    <input type="text" id="imie" name="imie" class="form-control" value="<?php echo htmlspecialchars($zamowienie['imie']); ?>" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="nazwisko" class="form-label">Nazwisko</label>
                    <input type="text" id="nazwisko" name="nazwisko" class="form-control" value="<?php echo htmlspecialchars($zamowienie['nazwisko']); ?>" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="Oczekujące" <?php if($zamowienie['status']=='Oczekujące') echo 'selected'; ?>>Oczekujące</option>
                        <option value="W trakcie" <?php if($zamowienie['status']=='W trakcie') echo 'selected'; ?>>W trakcie</option>
                        <option value="Zrealizowane" <?php if($zamowienie['status']=='Zrealizowane') echo 'selected'; ?>>Zrealizowane</option>
                        <option value="Anulowane" <?php if($zamowienie['status']=='Anulowane') echo 'selected'; ?>>Anulowane</option>
                    </select>
                </div>
                <button type="submit" name="edit_order" class="btn btn-primary">Zapisz</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger text-center">
                <?php echo htmlspecialchars($wiadomosc); ?>
            </div>
        <?php endif; ?>
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
    </style>
</body>
</html>
