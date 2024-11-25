<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zapomniałeś Hasła?</title>
  <link rel="stylesheet" href="./css/stylesLogin.css">
</head>

<body>
  <div class="containerMain">
    <div class="container">
      <p class="forgetText">Zapomniałeś hasła?</p>
      <form id="login" class="forms" method="POST" action="sendPasswordReset.php">
        <input type="email" class="data" name="email" placeholder="E-mail" required>
        <br>
        <br>
        <br>
        <br>
        <button type="submit" name="login" class="btn-submit">Wyślij</button>
      </form>
    </div>
  </div>
</body>

</html>