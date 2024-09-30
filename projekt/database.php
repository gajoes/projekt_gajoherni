<?php

$host = 'mysql.ct8.pl';
$dbname = 'm50521_baza_danych';
$user = 'm50521_admin';
$pass = 'n5XY7NnRdSp4gEh';

try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
    $pdo->query('SET NAMES utf8');
} catch (PDOException $e) {
    echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    exit();
}

?>

