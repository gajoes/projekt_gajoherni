<?php
require_once 'database.php';
session_start();
header('Content-Type: application/json');

$min_cena=isset($_GET['min_cena']) ? intval($_GET['min_cena']) : 0;
$max_cena=isset($_GET['max_cena']) ? intval($_GET['max_cena']) : 0;
$wybrana_kat=isset($_GET['id_kategorii']) ? intval($_GET['id_kategorii']) : 0;
$wyszukaj=isset($_GET['wyszukaj']) ? $conn->real_escape_string($_GET['wyszukaj']) : '';
$sql_produkty="SELECT * FROM produkty WHERE 1";
$parametr=[];
$typy="";

if (!empty($wyszukaj)){
    $sql_produkty.=" AND nazwa LIKE ?";
    $parametr[]="%$wyszukaj%";
    $typy.="s";
}

if ($wybrana_kat>0){
    $sql_produkty.=" AND id_kategorii =?";
    $parametr[]=$wybrana_kat;
    $typy.="i";
}

if ($min_cena>0){
    $sql_produkty.=" AND cena >=?";
    $parametr[]=$min_cena;
    $typy.="i";
}

if ($max_cena>0){
    $sql_produkty.=" AND cena <=?";
    $parametr[]=$max_cena;
    $typy.="i";
}

$sql_produkty.=" ORDER BY RAND()";
$stmt=$conn->prepare($sql_produkty);

if ($typy&&$stmt){
    $stmt->bind_param($typy, ...$parametr);
}

$stmt->execute();
$result=$stmt->get_result();

$ulubione=array();
if (isset($_SESSION['user_id'])){
    $id_uzytkownika=$_SESSION['user_id'];
    $stmt_ulubione=$conn->prepare("SELECT id_produktu FROM ulubione WHERE id_uzytkownika =?");
    $stmt_ulubione->bind_param("i",$id_uzytkownika);
    $stmt_ulubione->execute();
    $result_ulubione=$stmt_ulubione->get_result();
    while ($row=$result_ulubione->fetch_assoc()){
        $ulubione[]=$row['id_produktu'];
    }
    $stmt_ulubione->close();
}
$produkty_html='';

if ($result->num_rows>0){
    while ($produkt=$result->fetch_assoc()){
        $produkty_html.='<div class="col-md-4 product-card mb-4">';
        $produkty_html.='<div class="product text-center position-relative">';
        $produkty_html.='<div class="heart-icon">';
        $produkty_html.='<i class="fa-heart '.(in_array($produkt['id_produktu'],$ulubione) ? 'fas filled-heart' : 'far empty-heart').'" data-product-id="'.$produkt['id_produktu'].'"></i>';
        $produkty_html.='</div>';
        $produkty_html.='<img src="'.htmlspecialchars($produkt['zdjecie']).'" alt="'.htmlspecialchars($produkt['nazwa']).'" class="img-fluid mb-2">';
        $produkty_html.='<h5 class="mb-2">'.htmlspecialchars($produkt['nazwa']).'</h5>';
        $produkty_html.='<p class="text-muted">Cena: '.number_format($produkt['cena'],2,',',' ').' PLN</p>';
        $produkty_html.='<form method="POST" action="dodaj_do_koszyka.php" class="add-to-cart-form">';
        $produkty_html.='<input type="hidden" name="id_produktu" value="'.$produkt['id_produktu'].'">';
        $produkty_html.='<button type="submit" class="btn btn-primary">Dodaj do koszyka</button>';
        $produkty_html.='</form>';
        $produkty_html.='</div>';
        $produkty_html.='</div>';
    }
}else{
    $produkty_html='<p>Brak produktów do wyświetlenia.</p>';
}
echo json_encode(["status"=>"success","produkty_html"=>$produkty_html]);
?>
