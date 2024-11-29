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

    $aktualne_zdjecie=$conn->prepare("SELECT zdjecie FROM produkty WHERE id_produktu =?");
        $aktualne_zdjecie->bind_param("i",$id);
        $aktualne_zdjecie->execute();
        $aktualneZdjecie_wynik=$aktualne_zdjecie->get_result();
        if ($aktualneZdjecie_wynik->num_rows>0){
            $aktualny_produkt=$aktualneZdjecie_wynik->fetch_assoc();
            $zdjatko=$aktualny_produkt['zdjecie'];
        }else{
            $zdjatko=null;
        }
        $new_zdjecie=$zdjatko;

        if (isset($_FILES['zdjecie'])&&$_FILES['zdjecie']['error']===0){
            $target_dir="./css/img/";
            $file_name=basename($_FILES["zdjecie"]["name"]);
            $target_file=$target_dir . $file_name;
            $upload_zdjecia=1;
            $typ_zdjecia=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $sprawdz_czyObraz=getimagesize($_FILES["zdjecie"]["tmp_name"]);
            if ($sprawdz_czyObraz===false){
                $wiadomosc="Plik nie jest obrazem.";
                $upload_zdjecia=0;
            }

            if (file_exists($target_file)){
                $wiadomosc="Plik już istnieje.";
                $upload_zdjecia=0;
            }

            if ($_FILES["zdjecie"]["size"] > 5000000){ // 5 megabajtuw
                $wiadomosc="Plik jest za duży.";
                $upload_zdjecia=0;
            }

            if (!in_array($typ_zdjecia,['jpg','jpeg','png'])){
                $wiadomosc="Dozwolone są tylko pliki JPG, JPEG i PNG.";
                $upload_zdjecia=0;
            }

            if ($upload_zdjecia===1){
                if (move_uploaded_file($_FILES["zdjecie"]["tmp_name"],$target_file)){
                    $new_zdjecie = $target_file;
                    if ($zdjatko && file_exists($zdjatko)){
                        unlink($zdjatko);
                    }
                }else{
                    $wiadomosc="Wystąpił błąd podczas przesyłania pliku.";
                }
            }
        }

        $query = $conn->prepare("UPDATE produkty SET nazwa =?, id_kategorii =?, id_dostawcy =?, cena =?, parametry =?, zdjecie =? WHERE id_produktu =?");
        $query->bind_param("siidssi",$nazwa,$id_kategorii,$id_dostawcy,$cena,$parametry,$new_zdjecie,$id);

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
$query =$conn->prepare("SELECT produkty.id_produktu, produkty.nazwa, kategorie.id_kategorii, kategorie.nazwa_kategorii, dostawcy.id_dostawcy, dostawcy.nazwa_dostawcy, produkty.cena, produkty.parametry, produkty.zdjecie FROM produkty
                         LEFT JOIN kategorie ON produkty.id_kategorii=kategorie.id_kategorii
                         LEFT JOIN dostawcy ON produkty.id_dostawcy=dostawcy.id_dostawcy");

$szukaj=$_GET['szukaj'] ?? '';
$query_szukaj="SELECT produkty.id_produktu, produkty.nazwa, kategorie.id_kategorii, kategorie.nazwa_kategorii, dostawcy.id_dostawcy, dostawcy.nazwa_dostawcy, produkty.cena, produkty.parametry, produkty.zdjecie FROM produkty
                 LEFT JOIN kategorie ON produkty.id_kategorii=kategorie.id_kategorii
                 LEFT JOIN dostawcy ON produkty.id_dostawcy=dostawcy.id_dostawcy";

if (!empty($szukaj)) {
    $szukaj_warunki='%'.$szukaj.'%';
    $query_szukaj .=" WHERE produkty.nazwa LIKE ? OR kategorie.nazwa_kategorii LIKE ? OR 
                        dostawcy.nazwa_dostawcy LIKE ? OR produkty.cena LIKE ?";
}

$query=$conn->prepare($query_szukaj);

if (!empty($szukaj)){
    $query->bind_param("ssss",$szukaj_warunki,$szukaj_warunki,$szukaj_warunki,$szukaj_warunki);
}

$query->execute();
$products =$query->get_result();

$kw_kategorie=$conn->prepare("SELECT id_kategorii,nazwa_kategorii FROM kategorie");
$kw_kategorie->execute();
$kategorie=$kw_kategorie->get_result();

$kw_dostawcy=$conn->prepare("SELECT id_dostawcy,nazwa_dostawcy FROM dostawcy");
$kw_dostawcy->execute();
$dostawcy=$kw_dostawcy->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie produktami</title>
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
                <h2 class="card-title">Dodaj produkt</h2>
                <form method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="nazwa" class="form-control" placeholder="Nazwa produktu" required>
                    </div>
                    <div class="col-md-3">
                    <select name="id_kategorii" class="form-control" required>
            <option value="" disabled selected>Wybierz kategorię</option>
            <?php while ($kategoria=$kategorie->fetch_assoc()): ?>
                <option value="<?php echo $kategoria['id_kategorii']; ?>">
                    <?php echo htmlspecialchars($kategoria['nazwa_kategorii']); ?>
                </option>
            <?php endwhile; ?>
        </select>
                    </div>
                    <div class="col-md-2">
                    <select name="id_dostawcy" class="form-control" required>
            <option value="" disabled selected>Wybierz dostawcę</option>
            <?php while ($dostawca=$dostawcy->fetch_assoc()): ?>
                <option value="<?php echo $dostawca['id_dostawcy']; ?>">
                    <?php echo htmlspecialchars($dostawca['nazwa_dostawcy']); ?>
                </option>
            <?php endwhile; ?>
        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="cena" class="form-control" placeholder="Cena" required>
                    </div>
                    <div class="col-md-2">
                        <input type="file" name="zdjecie" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <textarea name="parametry" class="form-control" placeholder="Parametry produktu" rows="3" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]+" required></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="add_product" class="btn btn-primary w-50 buy">Dodaj produkt</button>
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
                        <button class="btn btn-warning btn-sm w-100 mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#editForm<?php echo $product['id_produktu']; ?>" aria-expanded="false" aria-controls="editForm<?php echo $product['id_produktu']; ?>">Edytuj</button>
                            <div class="collapse" id="editForm<?php echo $product['id_produktu']; ?>">
                                <form method="POST" enctype="multipart/form-data" class="mt-2">
                                    <input type="hidden" name="id" value="<?php echo $product['id_produktu']; ?>">
                                    <div class="mb-2">
                                        <input type="text" name="nazwa" placeholder="Nazwa produktu" value="<?php echo htmlspecialchars($product['nazwa']); ?>" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                    <select name="id_kategorii" class="form-control form-control-sm mb-1" required>
                                <?php
                                $kw_kategorie->execute();
                                $kategorie=$kw_kategorie->get_result();
                                while ($kategoria=$kategorie->fetch_assoc()): ?>
                                    <option value="<?php echo $kategoria['id_kategorii']; ?>" 
                                        <?php if ($kategoria['id_kategorii']==$product['id_kategorii']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($kategoria['nazwa_kategorii']); ?>
                                    </option>
                                <?php endwhile; ?>
                                </select>
                                <select name="id_dostawcy" class="form-control form-control-sm mb-1" required>
                                <?php
                                $kw_dostawcy->execute();
                                $dostawcy=$kw_dostawcy->get_result();
                                while ($dostawca=$dostawcy->fetch_assoc()): ?>
                                    <option value="<?php echo $dostawca['id_dostawcy']; ?>" 
                                        <?php if ($dostawca['id_dostawcy']==$product['id_dostawcy']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($dostawca['nazwa_dostawcy']); ?>
                                    </option>
                                <?php endwhile; ?>
                                </select>
                                    </div>
                                    <div class="mb-2">
                                        <input type="number" step="0.01" name="cena" placeholder="Cena" value="<?php echo htmlspecialchars($product['cena']); ?>" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="parametry" class="form-control form-control-sm" placeholder="Parametry produktu" rows="2" required><?php echo htmlspecialchars($product['parametry']); ?></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <input type="file" name="zdjecie" class="form-control form-control-sm">
                                    </div>
                                    <button type="submit" name="edit_product" class="btn btn-primary btn-sm w-100">Zapisz</button>
                                </form>
                            </div>
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
