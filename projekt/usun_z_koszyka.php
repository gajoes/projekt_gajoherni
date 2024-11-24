<?php
require_once 'database.php';
session_start();
$id_produktu=intval($_GET['id_produktu']);

if (isset($_SESSION['id_uzytkownika'])){
    $id_uzytkownika=$_SESSION['id_uzytkownika'];
    $sql ="DELETE FROM koszyk WHERE id_uzytkownika = ? AND id_produktu = ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ii",$id_uzytkownika,$id_produktu);

    if ($stmt->execute()){
        header("Location: koszyk.php?message=Produkt został usunięty z koszyka.");
    }else{
        header("Location: koszyk.php?error=Nie udało się usunąć produktu z koszyka.");
    }
}else{
    if (isset($_SESSION['koszyk'][$id_produktu])){
        unset($_SESSION['koszyk'][$id_produktu]);
        header("Location: koszyk.php?message=Produkt został usunięty z koszyka.");
    }else{
        header("Location: koszyk.php?error=Produkt nie znajduje się w koszyku.");
    }
}

exit();
?>
