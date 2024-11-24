<?php
require_once 'database.php';
session_start();
$id_produktu=intval($_POST['id_produktu']);
$ilosc=1;

if (isset($_SESSION['id_uzytkownika'])){
    $id_uzytkownika=$_SESSION['id_uzytkownika'];
    $sql="INSERT INTO koszyk (id_uzytkownika, id_produktu, ilosc) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE ilosc = ilosc + VALUES(ilosc)";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("iii",$id_uzytkownika,$id_produktu,$ilosc);

    if ($stmt->execute()){
        header("Location: index.php?message=Produkt został dodany do koszyka.");
    }else{
        header("Location: index.php?error=Nie udało się dodać produktu do koszyka.");
    }
}else{
    if (!isset($_SESSION['koszyk'])){
        $_SESSION['koszyk']=[];
    }
    if (isset($_SESSION['koszyk'][$id_produktu])){
        $_SESSION['koszyk'][$id_produktu]+=$ilosc;
    }else{
        $_SESSION['koszyk'][$id_produktu]=$ilosc;
    }
        header("Location: index.php?message=Produkt został dodany do koszyka.");
}
?>
