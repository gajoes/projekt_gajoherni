<?php
require_once 'database.php';
session_start();

if(!isset($_SESSION['user_id'])&& !isset($_COOKIE['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_COOKIE['user_id'])){
    $_SESSION['user_id']=$_COOKIE['user_id'];
}

$user_id=$_SESSION['user_id'];
echo "Witamy!"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>
</head>
<body>
    <a href="wyloguj.php">
    <button type="button" class="btn btn-primary">Wyloguj</button>
    </a>
</body>
</html>