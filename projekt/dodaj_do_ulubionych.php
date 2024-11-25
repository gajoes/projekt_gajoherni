<?php
require_once 'database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','message' =>'Musisz być zalogowany, aby dodać produkt do ulubionych']);
    exit();
}else{
    $id_uzytkownika=$_SESSION['user_id'];
    if (isset($_POST['id_produktu'])){
        $id_produktu=intval($_POST['id_produktu']);
        $stmt=$conn->prepare("INSERT IGNORE INTO ulubione (id_uzytkownika,id_produktu) VALUES (?, ?)");
        $stmt->bind_param("ii",$id_uzytkownika,$id_produktu);
        if ($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Produkt został dodany do ulubionych']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Nie można dodać produktu do ulubionych']);
        }
        $stmt->close();
    }else{
        echo json_encode(['status'=>'error','message'=>'Błąd']);
    }
    exit();
}
?>