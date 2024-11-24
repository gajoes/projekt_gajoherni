<?php
require_once 'database.php';
session_start();

if(!isset($_SESSION['zamowienie'])){
    die('Brak danych zamówienia. Powrót do koszyka.');
}

$zamowienie=$_SESSION['zamowienie'];
$suma=$zamowienie['suma'];
$status_platnosci=false;

if($_SERVER['REQUEST_METHOD']==='POST'){
    $metoda_platnosci=$_POST['metoda_platnosci'] ?? '';
    $blik_kod=$_POST['blik_kod'] ?? '';
    $karta_numer= $_POST['karta_numer'] ?? '';
    $karta_data=$_POST['karta_data'] ?? '';
    $karta_cvv=$_POST['karta_cvv'] ?? '';
    $bledy= [];

    if($metoda_platnosci==='blik'){
        if(empty($blik_kod)||strlen($blik_kod)!==6||!ctype_digit($blik_kod)){
            $bledy[]='Wprowadź poprawny kod BLIK (6 cyfr).';
        }
    }elseif($metoda_platnosci==='karta'){
        if(empty($karta_numer)||strlen($karta_numer)!==16||!ctype_digit($karta_numer)){
            $bledy[]='Wprowadź poprawny numer karty (16 cyfr).';
        }
        if(empty($karta_data)||!preg_match('/^\d{2}\/\d{2}$/',$karta_data)){
            $bledy[]='Wprowadź poprawną datę ważności karty (MM/RR).';
        }
        if(empty($karta_cvv)||strlen($karta_cvv)!==3||!ctype_digit($karta_cvv)){
            $bledy[]='Wprowadź poprawny kod CVV (3 cyfry).';
        }
    }elseif(!in_array($metoda_platnosci,['pobranie','karta_na_miejscu'])){
        $bledy[] ='Wybierz metodę płatności.';
    }

    if(in_array($metoda_platnosci,['pobranie','karta_na_miejscu'])){
        $status_platnosci=true;
    }

    if(empty($bledy)){
        $status_platnosci =true;

        if($status_platnosci){
            $conn->begin_transaction();
            try{
                $username=$zamowienie['username'];
                $email=$zamowienie['email'];
                $imie=$zamowienie['imie'];
                $nazwisko=$zamowienie['nazwisko'];
                $id_uzytkownika=$zamowienie['id_uzytkownika']??null;

                $sql="INSERT INTO zamowienia (username,email,imie,nazwisko,data_zamowienia,id_uzytkownika)
                      VALUES(?,?,?,?,NOW(),?)";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param("ssssi",$username,$email,$imie,$nazwisko,$id_uzytkownika);
                $stmt->execute();
                $id_zamowienia=$conn->insert_id;

                $ulica=$zamowienie['ulica'];
                $nr_domu=$zamowienie['nr_domu'];
                $nr_mieszkania=$zamowienie['nr_mieszkania'];
                $miasto=$zamowienie['miasto'];
                $kod_pocztowy=$zamowienie['kod_pocztowy'];

                $sql="INSERT INTO zamowienia_adresy (id_zamowienia,ulica,nr_domu,nr_mieszkania,miasto,kod_pocztowy)
                      VALUES(?, ?, ?, ?, ?, ?)";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param("isssss",$id_zamowienia,$ulica, $nr_domu,$nr_mieszkania,$miasto,$kod_pocztowy);
                $stmt->execute();

                foreach($zamowienie['koszyk'] as $id_produktu=>$ilosc){
                    $sql="SELECT COUNT(*) FROM produkty WHERE id_produktu= ?";
                    $stmt_check=$conn->prepare($sql);
                    $stmt_check->bind_param("i",$id_produktu);
                    $stmt_check->execute();
                    $stmt_check->bind_result($count);
                    $stmt_check->fetch();
                    $stmt_check->close();

                    if($count>0){
                        $sql="INSERT INTO zamowienia_produkty (id_zamowienia,id_produktu,ilosc)
                              VALUES(?, ?, ?)";
                        $stmt=$conn->prepare($sql);
                        $stmt->bind_param("iii",$id_zamowienia,$id_produktu,$ilosc);
                        $stmt->execute();
                    }else{
                        throw new Exception("Produkt o ID $id_produktu nie istnieje w bazie danych.");
                    }
                }
                $conn->commit();
                unset($_SESSION['zamowienie'], $_SESSION['koszyk']);
                header("Location: potwierdzenie_zamowienia.php?zamowienie= $id_zamowienia");
                exit;
            }catch(Exception$e){
                $conn->rollback();
                $bledy[]= "Wystąpił błąd podczas tworzenia twojego zamówienia: ".$e->getMessage();
            }
        }else{
            $bledy[]='Wystąpił problem z płatnością. Spróbuj ponownie.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Płatność</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-4">
    <h3>Finalizacja płatności</h3>
    <p>Kwota do zapłaty:<strong><?php echo number_format($suma,2);?> PLN</strong></p>

    <?php if(!empty($bledy)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($bledy as $blad):?>
                    <li><?php echo htmlspecialchars($blad); ?> </li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>

    <form method="POST" action="platnosc.php">
        <h4>Wybierz metodę płatności:</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="metoda_platnosci" id="blik" value="blik" <?php echo(isset($_POST['metoda_platnosci'])&&$_POST['metoda_platnosci']==='blik') ? 'checked' : '';?>>
            <label class="form-check-label"for="blik">BLIK</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="metoda_platnosci" id="karta" value="karta" <?php echo(isset($_POST['metoda_platnosci'])&&$_POST['metoda_platnosci']=== 'karta') ? 'checked' : '';?>>
            <label class="form-check-label" for="karta">Karta kredytowa</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="metoda_platnosci" id="pobranie" value="pobranie" <?php echo(isset($_POST['metoda_platnosci'])&&$_POST['metoda_platnosci']==='pobranie') ? 'checked' : '';?>>
            <label class="form-check-label"for="pobranie">Za pobraniem</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="metoda_platnosci" id="karta_na_miejscu" value="karta_na_miejscu" <?php echo(isset($_POST['metoda_platnosci'])&&$_POST['metoda_platnosci']==='karta_na_miejscu')?'checked' : '';?>>
            <label class="form-check-label" for="karta_na_miejscu">Kartą na miejscu</label>
        </div>
        <div id="blik-form" style="display:none;margin-top:20px;">
            <label for="blik_kod" class="form-label">Kod BLIK:</label>
            <input type="text" class="form-control" id="blik_kod" name="blik_kod" maxlength="6">
        </div>
        <div id="karta-form" style="display:none;margin-top:20px;">
            <label for="karta_numer" class="form-label">Numer karty:</label>
            <input type="text" class="form-control" id="karta_numer" name="karta_numer" maxlength="16">
            <label for="karta_data" class="form-label">Data ważności (MM/RR):</label>
            <input type="text" class="form-control" id="karta_data" name="karta_ data" maxlength="5">
            <label for="karta_cvv"class="form-label">Kod CVV:</label>
            <input type="text" class="form-control" id="karta_cvv" name="karta_cvv" maxlength="3">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Zapłać</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const metodaPlatnosci=document.getElementsByName('metoda_platnosci');
        const blikForm=document.getElementById('blik-form');
        const kartaForm=document.getElementById('karta-form');

        metodaPlatnosci.forEach(function (radio){
            radio.addEventListener('change', function(){
                if(this.value==='blik'){
                    blikForm.style.display='block';
                    kartaForm.style.display='none';
                }else if(this.value==='karta'){
                    blikForm.style.display='none';
                    kartaForm.style.display='block';
                }else{
                    blikForm.style.display='none';
                    kartaForm.style.display='none';
                }
            });
        });
        const checkedMethod=document.querySelector('input[name="metoda_platnosci"] : checked');
        if(checkedMethod){
            if(checkedMethod.value==='blik'){
                blikForm.style.display= 'block';
            }else if(checkedMethod.value==='karta'){
                kartaForm.style.display='block';
            }else{
                blikForm.style.display='none';
                kartaForm.style.display='none';
            }
        }
    });
</script>
</body>
</html>