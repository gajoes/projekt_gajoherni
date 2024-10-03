<?php

$host = 'mysql.ct8.pl';
$dbname = 'm50521_baza_danych';
$username = 'm50521_admin';
$password = 'n5XY7NnRdSp4gEh';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Połączenie przerwane" . $conn->connect_error);
}

return $conn;
