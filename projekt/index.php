<?php
require_once 'database.php';
session_start();
$sql_kategorie="SELECT * FROM kategorie";
$wynik_kategorie=$conn->query($sql_kategorie);
$min_cena=isset($_GET['min_cena']) ? intval($_GET['min_cena']) : 0;
$max_cena=isset($_GET['max_cena']) ? intval($_GET['max_cena']) : 20000;
$wybrana_kat=isset($_GET['id_kategorii']) ? intval($_GET['id_kategorii']) : 0;
$query_wybrane="SELECT * FROM produkty ORDER BY RAND() LIMIT 3";
$wynik_wybrane=$conn->query($query_wybrane);
$sql_produkty="SELECT * FROM produkty WHERE 1";
if ($wybrana_kat>0){
    $sql_produkty.=" AND id_kategorii=$wybrana_kat";
}
if ($min_cena>0){
    $sql_produkty.=" AND cena>=$min_cena";
}
if ($max_cena>0){
    $sql_produkty.=" AND cena<=$max_cena";
}
$wynik_produkty=$conn->query($sql_produkty);

if ($wybrana_kat>0){
    $sql_produkty .=" AND id_kategorii=$wybrana_kat";
}

$wynik_produkty=$conn->query($sql_produkty);

$ulubione=array();
if (isset($_SESSION['user_id'])){
    $id_uzytkownika=$_SESSION['user_id'];
    $stmt=$conn->prepare("SELECT id_produktu FROM ulubione WHERE id_uzytkownika = ?");
    $stmt->bind_param("i",$id_uzytkownika);
    $stmt->execute();
    $result=$stmt->get_result();
    while ($row=$result->fetch_assoc()){
        $ulubione[]=$row['id_produktu'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Strona Główna</title>

  <link rel="stylesheet" href="css/style.css">
  <script src="https://kit.fontawesome.com/78fa2015f8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
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
          <a class="nav-link" href="koszyk.php">
            <i class="fa-solid fa-cart-shopping fa-xl fa-fw navicon"></i>
          </a>
        </div>
    </div>
  </nav>
  <div class="d-flex justify-content-center">
    <div id="carouselExampleRide" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img
            src="https://static.vecteezy.com/system/resources/thumbnails/003/810/922/small/horizontal-banner-for-black-friday-sale-black-balls-with-shiny-ribbons-golden-letters-vector.jpg"
            class="d-block w-100" alt="blackfriday">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://www.apple.com/v/iphone-16/c/images/meta/iphone-16_overview__fcivqu9d5t6q_og.png"
            class="d-block w-100" alt="iphone">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://storage-asset.msi.com/global/picture/apluscontent/reseller/1663812116.jpeg"
            class="d-block w-100" alt="nvidia">
          <div class="carousel-caption d-none d-md-block">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <div class="container-fluid mt-4">
    <div class="row align-items-center">
      <div class="col-md-3 d-flex flex-column justify-content-center">
        <div class="highlighted-product mb-4">
          <div class="text-center">
            <span class="borderp">Wyjątkowa cena</span>
            <img src="./css/img/iphone16.png" alt="Featured iPhone" class="img-fluid">
            <h3 class="mb-2">iPhone 16</h3>
            <p class="text-muted">Cena: 4999 PLN</p>
            <a href="#" class="btn btn-primary">Dodaj do koszyka</a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
    <div class="selected-for-you d-flex flex-column justify-content-center">
        <h4 class="mb-4">Wybrane dla Ciebie</h4>
        <div class="row">
            <?php
            if ($wynik_wybrane->num_rows>0){
                while ($wybrany = $wynik_wybrane->fetch_assoc()){
                    echo '<div class="col-md-4 product-card mb-4">';
                    echo '<div class="product text-center position-relative">';
                    echo '<div class="heart-icon">';
                    echo '<i class="fa-heart ';
                    if (in_array($wybrany['id_produktu'],$ulubione)){
                        echo 'fas filled-heart"';
                    }else{
                        echo 'far empty-heart"';
                    }
                    echo ' data-product-id="'.$wybrany['id_produktu'].'"></i>';
                    echo '</div>';
                    echo '<img src="'.htmlspecialchars($wybrany['zdjecie']).'" alt="'.htmlspecialchars($wybrany['nazwa']).'" class="img-fluid mb-2">';
                    echo '<h5 class="mb-2">' . htmlspecialchars($wybrany['nazwa']).'</h5>';
                    echo '<p class="text-muted">Cena: '.number_format($wybrany['cena'],2).' PLN</p>';
                    echo '<form method="POST" action="dodaj_do_koszyka.php">';
                    echo '<input type="hidden" name="id_produktu" value="'.$wybrany['id_produktu'] . '">';
                    echo '<button type="submit" class="btn btn-primary">Dodaj do koszyka</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
      <div class="container-fluid mt-4">
        <div class="row">
          <div class="col-md-3">
            <div class="categories mb-4">
              <h5>Filtrowanie:</h5>
              <form method="GET" action="index.php">
                <div class="mb-3">
                  <label for="min_cena" class="form-label">Cena minimalna:</label>
                  <input type="number" class="form-control" id="min_cena" name="min_cena"
                    value="<?php echo $min_cena; ?>" min="0">
                </div>
                <div class="mb-3">
                  <label for="max_cena" class="form-label">Cena maksymalna:</label>
                  <input type="number" class="form-control" id="max_cena" name="max_cena"
                    value="<?php echo $max_cena; ?>" min="0">
                </div>
                <button type="submit" class="btn btn-primary w-100 filtrujbtn">Filtruj</button>
              </form>
              <hr>
              <h5>Kategorie:</h5>
              <ul class="list-group">
                <li class="list-group-item">
                  <a href="index.php" class="text-decoration-none">Wszystkie</a>
                </li>
                <?php
                if ($wynik_kategorie->num_rows > 0) {
                  while ($kategoria = $wynik_kategorie->fetch_assoc()) {
                    echo '<li class="list-group-item">';
                    echo '<a href="index.php?id_kategorii=' . $kategoria['id_kategorii'] . '" class="text-decoration-none">';
                    echo htmlspecialchars($kategoria['nazwa_kategorii']);
                    echo '</a>';
                    echo '</li>';
                  }
                } else {
                  echo '<li class="list-group-item">Brak kategorii.</li>';
                }
            }else{
                echo '<li class="list-group-item">Brak kategorii.</li>';
            }
            ?>
          </ul>
        </div>
      </div>
      <div class="col-md-9" id="produkty">
        <div class="row">
          <?php
          if ($wynik_produkty->num_rows>0){
            while ($produkt=$wynik_produkty->fetch_assoc()){
                echo '<div class="col-md-4 product-card mb-4">';
                echo '<div class="product text-center position-relative">';
                echo '<div class="heart-icon">';
                echo '<i class="fa-heart ';
                if (in_array($produkt['id_produktu'], $ulubione)){
                    echo 'fas filled-heart"';
                }else{
                    echo 'far empty-heart"';
                }
                echo ' data-product-id="'.$produkt['id_produktu'].'"></i>';
                echo '</div>';
                echo '<img src="'.htmlspecialchars($produkt['zdjecie']).'" alt="'.htmlspecialchars($produkt['nazwa']).'" class="img-fluid mb-2">';
                echo '<h5 class="mb-2">'.htmlspecialchars($produkt['nazwa']).'</h5>';
                echo '<p class="text-muted">Cena: '.number_format($produkt['cena'],2).' PLN</p>';
                echo '<form method="POST" action="dodaj_do_koszyka.php">';
                echo '<input type="hidden" name="id_produktu" value="'.$produkt['id_produktu'].'">';
                echo '<button type="submit" class="btn btn-primary">Dodaj do koszyka</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        }else{
            echo '<p>Brak produktów w tej kategorii.</p>';
        }
        ?>
        </div>
      </div>
  <script>
  $(document).ready(function(){
      $('.heart-icon i').on('click', function(){
          var productId=$(this).data('product-id');
          var heartIcon=$(this);
          <?php if (isset($_SESSION['user_id'])){ ?>
              if (heartIcon.hasClass('filled-heart')){
                  $.ajax({
                      url: 'usun_z_ulubionych.php',
                      type: 'POST',
                      data: { id_produktu: productId },
                      success: function(response){
                          heartIcon.removeClass('fas filled-heart').addClass('far empty-heart');
                          showPopup('Usunięto produkt z ulubionych','green');
                      },
                      error: function(){
                          showPopup('Nie udało się usunąć produktu z ulubionych','red');
                      }
                  });
              }else{
                  $.ajax({
                      url: 'dodaj_do_ulubionych.php',
                      type: 'POST',
                      data: { id_produktu: productId },
                      success: function(response){
                          heartIcon.removeClass('far empty-heart').addClass('fas filled-heart');
                          showPopup('Dodano produkt do ulubionych','green');
                      },
                      error: function(){
                          showPopup('Nie udało się dodać produktu do ulubionych','red');
                      }
                  });
              }
          <?php }else{ ?>
              showPopup('Musisz być zalogowany, aby dodać produkt do ulubionych','red');
          <?php } ?>
      });

      function showPopup(message,color){
          var popup=$('<div class="popup-message"></div>').text(message).css({
              'background-color': color,
              'color': 'white',
              'padding': '10px',
              'position': 'fixed',
              'top': '20px',
              'right': '20px',
              'z-index': '10000',
              'border-radius': '5px',
              'display': 'none'
          });
          $('body').append(popup);
          popup.fadeIn().delay(2000).fadeOut(function(){
              $(this).remove();
          });
      }
  });
  </script>
      <script>
  $(document).ready(function (){
      $('form[action="dodaj_do_koszyka.php"]').on('submit',function (e){
          e.preventDefault();
          var form=$(this);
          var formData=form.serialize();

          $.ajax({
              url: 'dodaj_do_koszyka.php',
              type: 'POST',
              data: formData,
              dataType: 'json',
              success: function (response){
                  if (response.status === 'success'){
                      showPopup(response.message, 'green');
                  }else{
                      showPopup(response.message, 'red');
                  }
              },
              error: function (){
                  showPopup('Wystąpił błąd podczas dodawania produktu do koszyka', 'red');
              }
          });
      });

      function showPopup(message, color){
          var popup=$('<div class="popup-message"></div>').text(message).css({
              'background-color': color,
              'color': 'white',
              'padding': '10px',
              'position': 'fixed',
              'top': '20px',
              'right': '20px',
              'z-index': '10000',
              'border-radius': '5px',
              'display': 'none'
          });
          $('body').append(popup);
          popup.fadeIn().delay(2000).fadeOut(function (){
              $(this).remove();
          });
      }
  });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>