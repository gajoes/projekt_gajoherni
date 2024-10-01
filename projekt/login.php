<?php
require_once 'database.php';
session_start();

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['register'])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query=$conn->prepare("SELECT * FROM Uzytkownicy WHERE email=? OR username=? ");
    $query->bind_param("ss",$email,$username);
    $query->execute();
    $result=$query->get_result();

    if($result->num_rows>0){
        echo "Taki użytkownik już istnieje!";
    }else{
        $query=$conn->prepare("INSERT INTO Uzytkownicy (username, email, haslo) VALUES (?, ?, ?)");
        $query->bind_param("sss",$username,$email,$password);

        if($query->execute()){
            echo "Zostałeś pomyślnie zarejestrowany!";
        }else{
            echo "Rejestracja się nie powiodła!";
        }
    }
}

if($_SERVER['REQUEST_METHOD']==='POST'&& isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];

    $query=$conn->prepare("SELECT * FROM Uzytkownicy WHERE username=?");
    if(!$query){
        die("Przygotowanie query się nie powiodło!".$conn->error);
    }

    $query->bind_param("s",$username);
    $query->execute();
    $result=$query->get_result();
    $user=$result->fetch_assoc();

    if($user&&password_verify($password,$user['haslo'])){
        $_SESSION['user_id']=$user['id_uzytkownika'];

        if(isset($_POST['remember'])){
            setcookie('user_id',$user['id_uzytkownika'],time()+(86400*10),"/");
        }

        header("Location: panel.php");
        exit();
    }else{
        echo "Zły login lub hasło!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Konto</title>
<link rel="stylesheet" href="./stylesLogin.css">
</head>
<body>
<div class="containerMain">
<div class="container">
<div class="btnContainer">
<div id="btnPosition"></div>
<button type="button" class="btn" onclick="login()">Zaloguj się</button>
<button type="button" class="btn" id="prawo" onclick="rejestracja()">    Rejestracja</button>
</div>
<form id="login" class="forms" method="POST" action="">
<input type="text" class="data" name="username" placeholder="Username" required>
<input type="password" class="data" name="password" placeholder="Hasło" required>
<p class="zapomnialesHasla"><a href="forgotPassword.php">Zapomniałeś hasła?</a></p>
<input type="checkbox" class="eulaCheck"><span class="eula">Zapamiętaj mnie</span>
<button type="submit" name="login" class="btn-submit">Zaloguj się</button>
</form>
<form id="rejestracja"class="forms" method="POST" action="">
<input type="text" class="data" name="username" placeholder="Username" required>
<input type="password" class="data" name="password" placeholder="Hasło" required>
<input type="email" class="data" name="email" placeholder="Email" required>
<input type="checkbox" class="eulaCheck"><span class="eula">Zgadzam sie na warunki i kondycje</span>
<button type="submit" name="register" class="btn-submit">Zarejestruj sie</button>
</form>
</div>
</div>
<script>
var x = document.getElementById("login");
var y = document.getElementById("rejestracja");
var z = document.getElementById("btnPosition");

function rejestracja(){
x.style.left = "-400px";
y.style.left = "50px";
z.style.left = "145px";
}

function login(){
x.style.left = "50px";
y.style.left = "450px";
z.style.left = "0px";
}

</script>
</body>
</html>