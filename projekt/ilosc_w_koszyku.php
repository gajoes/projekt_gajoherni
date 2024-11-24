<?php
require_once 'database.php';
session_start();

if (isset($_SESSION['id_uzytkownika'])){
    $id_uzytkownika=$_SESSION['id_uzytkownika'];

    if (isset($_POST['ilosc'])){
        foreach ($_POST['ilosc'] as $id_produktu =>$ilosc){
            $ilosc=intval($ilosc);
            if ($ilosc > 0) {
                $sql="UPDATE koszyk SET ilosc = ? WHERE id_uzytkownika = ? AND id_produktu = ?";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param("iii",$ilosc,$id_uzytkownika,$id_produktu);
                $stmt->execute();
            }
        }
    }
}else{
    if (isset($_POST['ilosc'])){
        foreach ($_POST['ilosc'] as $id_produktu =>$ilosc){
            $ilosc =intval($ilosc);
            if ($ilosc>0){
                $_SESSION['koszyk'][$id_produktu]=$ilosc;
            }else{
                unset($_SESSION['koszyk'][$id_produktu]);
            }
        }
    }
}

header("Location: koszyk.php?message=Koszyk został zaktualizowany.");
exit();
?>
