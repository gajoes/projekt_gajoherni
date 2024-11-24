<?php
require_once 'database.php';
session_start();
if (!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$wiadomosc =""; 
if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['add_employee'])){
    $username =$_POST['username'];
    $email=$_POST['email'];
    $password =password_hash($_POST['password'], PASSWORD_BCRYPT);
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];

    $query =$conn->prepare("INSERT INTO Pracownicy (username, email, haslo, imie, nazwisko) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss",$username,$email,$password,$imie,$nazwisko);

    if ($query->execute()){
        $wiadomosc ="Pracownik został dodany!";
    } else{
        $wiadomosc="Błąd podczas dodawania pracownika!";
    }
}

if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['edit_employee'])){
    $id =$_POST['id'];
    $username =$_POST['username'];
    $email=$_POST['email'];
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];

    $query =$conn->prepare("UPDATE Pracownicy SET username = ?, email = ?, imie = ?, nazwisko = ? WHERE id_prac = ?");
    $query->bind_param("ssssi",$username,$email,$imie,$nazwisko,$id);

    if ($query->execute()){
        $wiadomosc ="Dane pracownika zostały zapisane!";
    } else{
        $wiadomosc="Błąd podczas edycji pracownika!";
    }
}

if ($_SERVER['REQUEST_METHOD'] ==='POST' &&isset($_POST['delete_employee'])){
    $id=$_POST['id'];

    $query =$conn->prepare("DELETE FROM Pracownicy WHERE id_prac = ?");
    $query->bind_param("i",$id);

    if ($query->execute()){
        $wiadomosc ="Pracownik został usunięty!";
    } else{
        $wiadomosc="Błąd podczas usuwania pracownika!";
    }
}

$query =$conn->prepare("SELECT id_prac, username, email, imie, nazwisko FROM Pracownicy");
$query->execute();
$employees =$query->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie pracownikami</title>
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
            <h2 class="card-title">Dodaj pracownika</h2>
            <form method="POST" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="username" class="form-control" placeholder="Nazwa użytkownika" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-2">
                    <input type="password" name="password" class="form-control" placeholder="Hasło" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="imie" class="form-control" placeholder="Imię" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="nazwisko" class="form-control" placeholder="Nazwisko" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add_employee" class="btn btn-primary w-50">Dodaj pracownika</button>
                </div>
            </form>
        </div>
    </div>
    <h2 class="text-center">Lista pracowników</h2>
    <table class="table table-light table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nazwa użytkownika</th>
                <th>Email</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Zmiany</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($employee =$employees->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['id_prac']); ?></td>
                    <td><?php echo htmlspecialchars($employee['username']); ?></td>
                    <td><?php echo htmlspecialchars($employee['email']); ?></td>
                    <td><?php echo htmlspecialchars($employee['imie']); ?></td>
                    <td><?php echo htmlspecialchars($employee['nazwisko']); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $employee['id_prac']; ?>">
                            <input type="text" name="username" value="<?php echo htmlspecialchars($employee['username']); ?>" class="form-control form-control-sm mb-1" required>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" class="form-control form-control-sm mb-1" required>
                            <input type="text" name="imie" value="<?php echo htmlspecialchars($employee['imie']); ?>" class="form-control form-control-sm mb-1" required>
                            <input type="text" name="nazwisko" value="<?php echo htmlspecialchars($employee['nazwisko']); ?>" class="form-control form-control-sm mb-1" required>
                            <button type="submit" name="edit_employee" class="btn btn-warning btn-sm w-100 mb-2">Edytuj</button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $employee['id_prac']; ?>">
                            <button type="submit" name="delete_employee" class="btn btn-danger btn-sm w-100">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
