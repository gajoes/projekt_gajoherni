<?php

$host = 'localhost';
$dbname = 'database';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Połączenie przerwane" . $conn->connect_error);
}

return $conn;
