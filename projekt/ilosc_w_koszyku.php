<?php
require_once 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['id_produktu'],$_POST['ilosc'])){
    $id_produktu=intval($_POST['id_produktu']);
    $ilosc=intval($_POST['ilosc']);
    $wynik=['success'=>false,'total'=>0];

    if ($ilosc>0){
        if (isset($_SESSION['id_uzytkownika'])){
            $id_uzytkownika=$_SESSION['id_uzytkownika'];
            $sql= "UPDATE koszyk SET ilosc =? WHERE id_uzytkownika =? AND id_produktu =?";
            $stmt=$conn->prepare($sql);
            $stmt->bind_param("iii",$ilosc,$id_uzytkownika,$id_produktu);
            $stmt->execute();
        }else{
            $_SESSION['koszyk'][$id_produktu]=$ilosc;
        }
        $wynik['total']=calculateCartTotal($conn);
        $wynik['success']=true;
    }
    echo json_encode($wynik);
    exit();
}
function calculateCartTotal($conn){
    $total=0;
    if (isset($_SESSION['id_uzytkownika'])){
        $id_uzytkownika=$_SESSION['id_uzytkownika'];
        $sql="SELECT SUM(p.cena * k.ilosc) AS total
                FROM koszyk k
                JOIN produkty p ON k.id_produktu = p.id_produktu
                WHERE k.id_uzytkownika =?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("i",$id_uzytkownika);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();
    }elseif(isset($_SESSION['koszyk'])){
        foreach ($_SESSION['koszyk'] as $id_produktu=>$ilosc){
            $stmt=$conn->prepare("SELECT cena FROM produkty WHERE id_produktu =?");
            $stmt->bind_param("i",$id_produktu);
            $stmt->execute();
            $stmt->bind_result($price);
            $stmt->fetch();
            $stmt->close();
            $total+=$price *$ilosc;
        }
    }
    return $total;
}
?>