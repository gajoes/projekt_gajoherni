<?php

$host = 'localhost';
$dbname = 'm50521_baza_danych';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Połączenie przerwane" . $conn->connect_error);
}

return $conn;
