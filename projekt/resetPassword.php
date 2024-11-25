<?php

$token = $_GET["token"];

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
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset hasła</title>
  <link rel="stylesheet" href="./css/stylesLogin.css">
</head>
<body>
  <div class="containerMain">
    <div class="container">
      <p class="forgetText">Ustaw nowe hasło</p>
      <form id="login" class="forms" method="POST" action="processResetPassword.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="password" id="password" class="data" name="password" placeholder="Nowe hasło" required>
        <input type="password" id="confirm_password" class="data" name="confirm_password" placeholder="Powtórz hasło" required>
        <button type="submit" class="btn-submit">Ustaw</button>
      </form>
    </div>
  </div>
</body>
<script>
  document.getElementById('login').onsubmit = function () {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    if (password !== confirm) {
      alert('Hasła nie pasują do siebie!');
      return false;
    }
    return true;
  };
</script>
</html>