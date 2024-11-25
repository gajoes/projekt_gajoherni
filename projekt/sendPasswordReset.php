<?php

$email = $_POST["email"];
  
$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 15);

$mysqli = require __DIR__ . "/database.php";

if (!$mysqli instanceof mysqli) {
    die("Failed to connect to the database.");
}

$sql = "UPDATE uzytkownicy
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Database error: " . $mysqli->error);
}

$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Reset hasła";
    $mail->Body = <<<END
    Kliknij w <a href="http://gajohernie.ct8.pl/resetPassword.php?token=$token">ten link</a>, aby zresetować hasło.
    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Wiadomość nie mogła zostać wysłana: {$mail->ErrorInfo}";
    }
} else {
    echo "Nie znaleziono użytkownika z podanym e-mailem.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Odzyskiwanie hasła</title>
  <link rel="stylesheet" href="./css/stylesLogin.css">
</head>

<body>
  <div class="containerMain">
    <div class="container">
      <p class="forgetText">Wysłano email</p>
      <form id="login" class="forms" method="" action="">
        <p class="forgetText2">Możesz zamknąć tę stronę.</p>
      </form>
    </div>
  </div>
</body>

</html>