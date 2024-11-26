<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM uzytkownicy
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null || strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Nieprawidłowy lub wygasły token.");
}

$new_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE uzytkownicy
        SET haslo = ?, reset_token_hash = NULL, reset_token_expires_at = NULL
        WHERE id_uzytkownika = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $new_password, $user["id_uzytkownika"]);
$stmt->execute();

echo "Hasło zostało pomyślnie zmienione.";
header("Location: login.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sukces</title>
  <link rel="stylesheet" href="./css/stylesLogin.css">
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