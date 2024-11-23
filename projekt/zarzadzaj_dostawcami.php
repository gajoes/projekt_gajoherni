<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$wiadomosc =""; 
if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['add_category'])){
    $nazwa_kategorii =$_POST['nazwa_kategorii'];

    $query =$conn->prepare("INSERT INTO Kategorie (nazwa_kategorii) VALUES (?)");
    $query->bind_param("s",$nazwa_kategorii);

    if ($query->execute()){
        $wiadomosc ="Kategoria została dodana!";
    } else{
        $wiadomosc="Błąd podczas dodawania kategorii!";
    }
}

if ($_SERVER['REQUEST_METHOD']==='POST' &&isset($_POST['edit_category'])){
    $id_kategorii =$_POST['id_kategorii'];
    $nazwa_kategorii =$_POST['nazwa_kategorii'];

    $query =$conn->prepare("UPDATE Kategorie SET nazwa_kategorii = ? WHERE id_kategorii = ?");
    $query->bind_param("si",$nazwa_kategorii,$id_kategorii);

    if ($query->execute()){
        $wiadomosc ="Dane kategorii zostały zapisane!";
    } else{
        $wiadomosc="Błąd podczas edycji kategorii!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST['delete_category'])){
    $id_kategorii =$_POST['id_kategorii'];

    $query =$conn->prepare("DELETE FROM Kategorie WHERE id_kategorii = ?");
    $query->bind_param("i",$id_kategorii);

    if ($query->execute()){
        $wiadomosc="Kategoria została usunięta!";
    } else{
        $wiadomosc="Błąd podczas usuwania kategorii!";
    }
}

$query =$conn->prepare("SELECT id_kategorii, nazwa_kategorii FROM Kategorie");
$query->execute();
$categories =$query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie kategoriami</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light text-dark">
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-elements-font border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="./css/img/logo.webp" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            Sklep
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Strona główna</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Galeria</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kontakt</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <?php if (!empty($wiadomosc)): ?>
        <div class="alert alert-info text-center">
            <?php echo htmlspecialchars($wiadomosc); ?>
        </div>
    <?php endif; ?>

    <div class="card bg-white mb-5 text-dark text-center border-light shadow-sm">
        <div class="card-body">
            <h2 class="card-title">Dodaj kategorię</h2>
            <form method="POST" class="row g-3">
                <div class="col-md-12">
                    <input type="text" name="nazwa_kategorii" class="form-control" placeholder="Nazwa kategorii" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add_category" class="btn btn-primary w-50">Dodaj kategorię</button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="text-center">Lista kategorii</h2>
    <table class="table table-light table-hover border">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nazwa kategorii</th>
                <th>Zmiany</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($category =$categories->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id_kategorii']); ?></td>
                    <td><?php echo htmlspecialchars($category['nazwa_kategorii']); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id_kategorii" value="<?php echo $category['id_kategorii']; ?>">
                            <input type="text" name="nazwa_kategorii" value="<?php echo htmlspecialchars($category['nazwa_kategorii']); ?>" class="form-control form-control-sm mb-1" required>
                            <button type="submit" name="edit_category" class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id_kategorii" value="<?php echo $category['id_kategorii']; ?>">
                            <button type="submit" name="delete_category" class="btn btn-danger btn-sm w-100">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
