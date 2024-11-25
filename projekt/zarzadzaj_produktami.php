<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['admin_id'])&&!isset($_SESSION['employee_id'])){
    header("Location: login.php");
    exit();
}

$wiadomosc = "";
if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['add_product'])){
    $nazwa =$_POST['nazwa'];
    $id_kategorii=$_POST['id_kategorii'];
    $id_dostawcy =$_POST['id_dostawcy'];
    $cena=$_POST['cena'];
    $parametry=$_POST['parametry'];

    if (isset($_FILES["zdjecie"]) && $_FILES["zdjecie"]["error"]==0){
        $target_dir="css/img/";
        $file_name=basename($_FILES["zdjecie"]["name"]);
        $target_file=$target_dir.$file_name;
        $upload_zdjecia=1;
        $typ_zdjecia=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $sprawdz_czyObraz=getimagesize($_FILES["zdjecie"]["tmp_name"]);
        if ($sprawdz_czyObraz===false){
            $wiadomosc="Plik nie jest obrazem.";
            $upload_zdjecia=0;
        }

        if (file_exists($target_file)){
            $wiadomosc="Plik już istnieje.";
            $upload_zdjecia=0;
        }

        if ($_FILES["zdjecie"]["size"]>5000000){ // 5 megabajtuw
            $wiadomosc="Plik jest za duży.";
            $upload_zdjecia=0;
        }

        if (!in_array($typ_zdjecia,['jpg','jpeg','png'])){
            $wiadomosc="Dozwolone są tylko pliki JPG, JPEG i PNG.";
            $upload_zdjecia=0;
        }

        if ($upload_zdjecia===1){
            if (move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $target_file)){
                $query = $conn->prepare("INSERT INTO produkty (nazwa, id_kategorii, id_dostawcy, cena, parametry, zdjecie) VALUES (?, ?, ?, ?, ?, ?)");
                $query->bind_param("siidss",$nazwa,$id_kategorii,$id_dostawcy,$cena,$parametry,$target_file);

                if ($query->execute()){
                    $wiadomosc="Produkt został dodany!";
                } else {
                    $wiadomosc="Błąd podczas dodawania produktu! ".$conn->error;
                }
            } else {
                $wiadomosc="Wystąpił błąd podczas przesyłania pliku.";
            }
        }
    }else{
        $wiadomosc="Nie przesłano pliku lub wystąpił błąd.";
    }
}


if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['edit_product'])){
    $id=$_POST['id'];
    $nazwa=$_POST['nazwa'];
    $id_kategorii=$_POST['id_kategorii'];
    $id_dostawcy=$_POST['id_dostawcy'];
    $cena=$_POST['cena'];
    $parametry=$_POST['parametry'];

    $query =$conn->prepare("UPDATE produkty SET nazwa = ?, id_kategorii = ?, id_dostawcy = ?, cena = ?, parametry = ? WHERE id_produktu = ?");
    $query->bind_param("siidsi",$nazwa,$id_kategorii,$id_dostawcy,$cena,$parametry,$id);

    if ($query->execute()){
        $wiadomosc="Dane produktu zostały zapisane!";
    }else{
        $wiadomosc="Błąd podczas edycji produktu! ".$conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD']==='POST' &&isset($_POST['delete_product'])){
    $id=$_POST['id'];
    $query=$conn->prepare("DELETE FROM produkty WHERE id_produktu =?");
    $query->bind_param("i",$id);

    if ($query->execute()){
        $wiadomosc="Produkt został usunięty!";
    }else{
        $wiadomosc="Błąd podczas usuwania produktu!";
    }
}
$query =$conn->prepare("SELECT produkty.id_produktu, produkty.nazwa, kategorie.id_kategorii, kategorie.nazwa_kategorii, 
                         dostawcy.id_dostawcy, dostawcy.nazwa_dostawcy, produkty.cena, produkty.parametry, produkty.zdjecie
                         FROM produkty
                         LEFT JOIN kategorie ON produkty.id_kategorii=kategorie.id_kategorii
                         LEFT JOIN dostawcy ON produkty.id_dostawcy=dostawcy.id_dostawcy");
$query->execute();
$products =$query->get_result();
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
                <h2 class="card-title">Dodaj produkt</h2>
                <form method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="nazwa" class="form-control" placeholder="Nazwa produktu" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="id_kategorii" class="form-control" placeholder="ID Kategorii" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="id_dostawcy" class="form-control" placeholder="ID Dostawcy" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="cena" class="form-control" placeholder="Cena" required>
                    </div>
                    <div class="col-md-2">
                        <input type="file" name="zdjecie" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <textarea name="parametry" class="form-control" placeholder="Parametry produktu" rows="3"></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="add_product" class="btn btn-primary w-50 buy">Dodaj produkt</button>
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
                                <input type="text" name="nazwa" value="<?php echo htmlspecialchars($product['nazwa']); ?>" class="form-control form-control-sm mb-1" required>
                                <input type="number" name="id_kategorii" value="<?php echo htmlspecialchars($product['id_kategorii']); ?>" class="form-control form-control-sm mb-1" required>
                                <input type="number" name="id_dostawcy" value="<?php echo htmlspecialchars($product['id_dostawcy']); ?>" class="form-control form-control-sm mb-1" required>
                                <input type="number" step="0.01" name="cena" value="<?php echo htmlspecialchars($product['cena']); ?>" class="form-control form-control-sm mb-1" required>
                                <textarea name="parametry" class="form-control form-control-sm mb-1" placeholder="Parametry produktu" rows="2"><?php echo htmlspecialchars($product['parametry']); ?></textarea>
                                <button type="submit" name="edit_product" class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                            </form>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten produkt?');">
                                <input type="hidden" name="id" value="<?php echo $product['id_produktu']; ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger btn-sm w-100">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
