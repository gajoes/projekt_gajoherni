<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM Uzytkownicy
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$username = $result->fetch_assoc();

if ($username === null) {
  die("token not found");
}

if (strtotime($username["reset_token_expires_at"]) <= time()) {
  die("token has expired");
}

$haslo = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE Uzytkownicy
        SET haslo = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id_uzytkownika = ?";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
  die("MySQL prepare error: " . $mysqli->error);
}

$stmt->bind_param("ss", $haslo, $username["id_uzytkownika"]);

$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sukces</title>
  <link rel="stylesheet" href="stylesForgotPassword.css">
</head>

<body>
  <div class="containerMain">
    <div class="container">
    <p class="forgetText">Hasło zostało zaktualizowane</p>
      <form id="login" class="forms" method="" action="">
        <button type="button" name="login" class="btn-submit"><a href="./login.php">Login</a></button>
      </form>
    </div>
  </div>
</body>

</html>