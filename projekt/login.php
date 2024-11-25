<?php
require_once 'database.php';
session_start();
$popup_message="";
$popup_type="";

if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['register'])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query=$conn->prepare("SELECT * FROM Uzytkownicy WHERE email =? OR username =?");
    $query->bind_param("ss",$email,$username);
    $query->execute();
    $result=$query->get_result();

    if ($result->num_rows>0){
        $popup_message="Taki użytkownik już jest zarejestrowany!";
        $popup_type="error";
    }else{
        $query=$conn->prepare("INSERT INTO Uzytkownicy (username,email,haslo) VALUES (?, ?, ?)");
        $query->bind_param("sss",$username,$email,$password);

        if ($query->execute()){
            $popup_message="Pomyślnie zarejestrowano użytkownika!";
            $popup_type="success";
        }else{
            $popup_message="Nie udało się zarejestrować użytkownika!";
            $popup_type="error";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] ==='POST'&&isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];

    $query=$conn->prepare("SELECT * FROM Uzytkownicy WHERE username =?");
    if (!$query){
        die("Przygotowanie zapytania nie powiodło się!".$conn->error);
    }
    $query->bind_param("s",$username);
    $query->execute();
    $result=$query->get_result();
    $user=$result->fetch_assoc();

    if ($user&&password_verify($password,$user['haslo'])){
        if ($user['rola']==='admin'){
            $_SESSION['admin_id']=$user['id_uzytkownika'];
            header("Location: panel_admina.php");
            exit();
        }
        $_SESSION['user_id']=$user['id_uzytkownika'];

        if (isset($_POST['remember'])){
            setcookie('user_id',$user['id_uzytkownika'],time()+(86400 * 10),"/");
        }
        header("Location: panel.php");
        exit();
    }else{
        $query=$conn->prepare("SELECT * FROM Pracownicy WHERE username = ?");
        if (!$query){
            die("Przygotowanie zapytania nie pyklo ".$conn->error);
        }
        $query->bind_param("s",$username);
        $query->execute();
        $result=$query->get_result();
        $employee=$result->fetch_assoc();

        if ($employee&&password_verify($password, $employee['haslo'])){
            $_SESSION['employee_id']=$employee['id_prac'];
            
            if (isset($_POST['remember'])){
                setcookie('employee_id',$employee['id_prac'], time()+(86400 * 10),"/");
            }
            header("Location: panel_pracownika.php");
            exit();
        }else{
            $popup_message="Zły login lub hasło!";
            $popup_type="error";
        }
    }
}
if (isset($_SESSION['admin_id'])){
    header("Location: panel_admina.php");
    exit();
}elseif (isset($_SESSION['employee_id']) || isset($_COOKIE['employee_id'])){
    header("Location: panel_pracownika.php");
    exit();
}elseif (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])){
    header("Location: panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto</title>
    <link rel="stylesheet" href="./css/stylesLogin.css">
</head>
<body>
<div id="popup" class="popup-wiadomosc">
    <span id="popup-message"></span>
</div>
<div class="containerMain">
    <div class="containerArrow">
        <a class="strzalka" href="index.php"><i class="arrow right"></i>Wróć</a>
    </div>
    <div class="container">
        <div class="btnContainer">
            <div id="btnPosition"></div>
            <button type="button" class="btn" onclick="login()">Zaloguj się</button>
            <button type="button" class="btn" id="prawo" onclick="rejestracja()">Rejestracja</button>
        </div>
        <form id="login" class="forms" method="POST" action="">
            <input type="text" class="data" name="username" placeholder="Username" required>
            <input type="password" class="data" name="password" placeholder="Hasło" required>
            <p class="zapomnialesHasla"><a href="forgotPassword.php">Zapomniałeś hasła?</a></p>
            <input type="checkbox" name="remember" class="eulaCheck"><span class="eula">Zapamiętaj mnie</span>
            <button type="submit" name="login" class="btn-submit">Zaloguj się</button>
        </form>
        <form id="rejestracja" class="forms" method="POST" action="">
            <input type="text" class="data" name="username" placeholder="Username" required>
            <input type="password" class="data" name="password" placeholder="Hasło" required>
            <input type="email" class="data" name="email" placeholder="Email" required>
            <input type="checkbox" class="eulaCheck" required><span class="eula">Zgadzam się na warunki i kondycje</span>
            <button type="submit" name="register" class="btn-submit">Zarejestruj się</button>
        </form>
    </div>
</div>
<script>
    var x=document.getElementById("login");
    var y=document.getElementById("rejestracja");
    var z=document.getElementById("btnPosition");
    var popup=document.getElementById("popup");

    function rejestracja(){
        x.style.left ="-400px";
        y.style.left="50px";
        z.style.left="145px";
    }
    function login() {
        x.style.left="50px";
        y.style.left="450px";
        z.style.left="0px";
    }
    function showPopup(message,type){
        document.getElementById('popup-message').textContent=message;
        popup.classList.add(type,'show');
        setTimeout(function (){
            popup.classList.remove('show');
        },3000);
    }
    <?php if (!empty($popup_message)){ ?>
    showPopup("<?php echo $popup_message; ?>","<?php echo $popup_type; ?>");
    <?php } ?>
</script>
</body>
</html>