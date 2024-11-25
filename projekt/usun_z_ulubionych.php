<?php
require_once 'database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','message'=>'Musisz być zalogowany, aby usunąć produkt z ulubionych']);
    exit();
}else{
    $id_uzytkownika=$_SESSION['user_id'];
    if (isset($_POST['id_produktu'])){
        $id_produktu=intval($_POST['id_produktu']);
        $stmt=$conn->prepare("DELETE FROM ulubione WHERE id_uzytkownika =? AND id_produktu =?");
        $stmt->bind_param("ii",$id_uzytkownika,$id_produktu);
        if ($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Produkt został usunięty z ulubionych']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Nie można usunąć produktu z ulubionych']);
        }
        $stmt->close();
    }else{
        echo json_encode(['status'=>'error','message'=>'Błąd']);
    }
    exit();
}
?>
