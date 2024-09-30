<?php
require_once 'database.php';
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
<form id="login" class="forms">
<input type="text" class="data" placeholder="Username" required>
<input type="text" class="data" placeholder="Hasło" required>
<p class="zapomnialesHasla"><a href="forgotPassword.php">Zapomniałeś hasła?</a></p>
<input type="checkbox" class="eulaCheck"><span class="eula">Zapamiętaj mnie</span>
<button type="submit" class="btn-submit">Zaloguj się</button>
</form>
<form id="rejestracja"class="forms">
<input type="text" class="data" placeholder="Username" required>
<input type="text" class="data" placeholder="Hasło" required>
<input type="email" class="data" placeholder="Email" required>
<input type="checkbox" class="eulaCheck"><span class="eula">Zgadzam sie na warunki i kondycje</span>
<button type="submit" class="btn-submit">Zarejestruj sie</button>
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