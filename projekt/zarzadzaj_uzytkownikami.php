<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$wiadomosc =""; 
if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['add_user'])){
    $username =$_POST['username'];
    $email=$_POST['email'];
    $password =password_hash($_POST['password'], PASSWORD_BCRYPT);
    $notatka =$_POST['notatka'];

    $query =$conn->prepare("INSERT INTO Uzytkownicy (username, email, haslo, notatka) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss",$username,$email,$password,$notatka);

    if ($query->execute()){
        $wiadomosc="Użytkownik został dodany!";
    } else{
        $wiadomosc="Błąd podczas dodawania użytkownika!";
    }
}

if ($_SERVER['REQUEST_METHOD'] ==='POST'&&isset($_POST['edit_user'])){
    $id =$_POST['id'];
    $username =$_POST['username'];
    $email=$_POST['email'];
    $notatka =$_POST['notatka'];

    $query =$conn->prepare("UPDATE Uzytkownicy SET username = ?, email = ?, notatka = ? WHERE id_uzytkownika = ?");
    $query->bind_param("sssi",$username,$email,$notatka,$id);
    if ($query->execute()){
        $wiadomosc ="Dane użytkownika zostały zapisane!";
    } else{
        $wiadomosc="Błąd podczas edycji użytkownika!";
    }
}

if ($_SERVER['REQUEST_METHOD'] ==='POST' &&isset($_POST['delete_user'])){
    $id=$_POST['id'];

    $query =$conn->prepare("DELETE FROM Uzytkownicy WHERE id_uzytkownika = ?");
    $query-> bind_param("i",$id);

    if ($query->execute()){
        $wiadomosc ="Użytkownik został usunięty!";
    } else{
        $wiadomosc="Błąd podczas usuwania użytkownika!";
    }
}
$query =$conn->prepare("SELECT id_uzytkownika, username, email, notatka FROM Uzytkownicy");
$query->execute();
$users =$query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie użytkownikami</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light text-dark">
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-elements-font">
    <div class="container-fluid">
      <a class="navbar-brand">
        <img src="./css/img/Tech.png" width="30" height="30" class="d-inline-block align-top brand-logo-sizing"
          alt="Jurzyk">
        <a class="navbar-brand navbar-custom-font"><span class="logop1">B</span><span class="logop2">Y</span><span
            class="logop3">T</span><span class="logop4">E</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="./index.php">Strona główna <span class="sr-only">(Aktualnie włączone)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./about.php">O nas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./kontakt.php">Kontakt</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="#produkty">Zakupy</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              </div>
            </li>
          </ul>
        </div>

        <div class="d-flex align-items-center">
          <a class="nav-link" href="login.php">
            <i class="fa-solid fa-user fa-xl fa-fw navicon"></i>
          </a>
          <a class="nav-link" href="#">
            <i class="fa-solid fa-cart-shopping fa-xl fa-fw navicon"></i>
          </a>
        </div>
    </div>
  </nav>

<div class="container mt-5">
    <?php if (!empty($wiadomosc)): ?>
        <div class="alert alert-info text-center">
            <?php echo htmlspecialchars($wiadomosc); ?>
        </div>
    <?php endif; ?>

    <div class="card bg-white mb-5 text-dark text-center border-light shadow-sm">
        <div class="card-body">
            <h2 class="card-title">Dodaj użytkownika</h2>
            <form method="POST" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="username" class="form-control" placeholder="Nazwa użytkownika" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-3">
                    <input type="password" name="password" class="form-control" placeholder="Hasło" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="notatka" class="form-control" placeholder="Notatka">
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add_user" class="btn btn-primary w-50">Dodaj użytkownika</button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="text-center">Lista użytkowników</h2>
    <table class="table table-light table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nazwa użytkownika</th>
                <th>Email</th>
                <th>Notatka</th>
                <th>Zmiany</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($user=$users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id_uzytkownika']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['notatka']); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user['id_uzytkownika']; ?>">
                            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="form-control form-control-sm mb-1" required>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control form-control-sm mb-1" required>
                            <input type="text" name="notatka" placeholder="notatka" value="<?php echo htmlspecialchars($user['notatka']); ?>" class="form-control form-control-sm mb-1">
                            <button type="submit" name="edit_user" class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user['id_uzytkownika']; ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger btn-sm w-100">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>