<?php
require_once 'database.php';
session_start();

if (isset($_POST['id_produktu'])){
    $id_produktu=$_POST['id_produktu'];
    $ilosc=isset($_POST['ilosc']) ? (int)$_POST['ilosc'] :1;

    if (!isset($_SESSION['koszyk'])){
        $_SESSION['koszyk']=[];
    }

    if (isset($_SESSION['koszyk'][$id_produktu])){
        $_SESSION['koszyk'][$id_produktu]+=$ilosc;
    }else{
        $_SESSION['koszyk'][$id_produktu]=$ilosc;
    }
    echo json_encode(["status"=>"success","message"=>"Produkt został dodany do koszyka."]);
}else{
    echo json_encode(["status"=>"error","message"=>"Nie ma takiego produktu."]);
}
?>
