<?php
session_start(); // Démarrer une session

require 'vendor/autoload.php';

// Charger les variables d'environnement à partir du fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Récupérer les variables d'environnement
$servername = $_ENV['BD_HOST'];
$username = $_ENV['BD_USER'];
$password = $_ENV['BD_PASS'];
$dbname = $_ENV['BD_NAME'];

// // Vérifier si une session est déjà active avant de la démar²rer
// if (session_status() !== PHP_SESSION_ACTIVE) {
//     session_start();
// }

// Connexion à la base de données
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$connection) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Récupération de l'email depuis la session
$email = $_SESSION['email'];

// Vérifier le rôle de l'utilisateur
$email = $_SESSION['email'];

$query = "SELECT tbl_role.name_r FROM tbl_role
JOIN tbl_user_role ON tbl_user_role.id_r_role = tbl_role.id_r
JOIN tbl_user ON tbl_user_role.id_user_user = tbl_user.id_user
WHERE tbl_user.mail_user = '$email';";


$result = mysqli_query($connection, $query);
if (!$result) {
    die('Erreur : ' . mysqli_error($connection));
}


$has_permission = false;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['name_r'] == 'PRO') {
            $has_permission = true;
            break;
        }
    }
}


// Requête pour sélectionner les 4 plus récentes activités
$sql = "SELECT * FROM tbl_activity ORDER BY id_activity DESC LIMIT 4";
$result = $connection->query($sql);
$recent_activities = [];


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_activities[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>


<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />


  <title>TC Bois</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />


  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
    integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />


  <!-- Custom styles  -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>


<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="header_top"></div>
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container">
            <a class="navbar-brand navbar_brand_mobile" href="index.html">
              TC<span>Bois</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class=""> </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Accueil<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="service.php">Services</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="activite.php">Travaux réalisés</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contactez-nous
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div>
          <div>
            <div class="container">
              <div class="detail-box">
                <h1>TC-BOIS</h1>
                <h2>Le bois au juste prix. <br /></h2>
                <h5>
                  Vente bois de terrasse, <br />
                  Bardage, <br />
                  Clôture, <br />
                  Bois de charpente,<br />
                  OSB,<br>
                  Derivé.<br>
                </h5>
                <div class="btn-box">
                  <a href="contact.php" class="btn2"> Contactez-nous </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>


  <!-- about section -->


  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>Bienvenue sur <span>TC Bois</span></h2>
            </div>
            <p>
            <h5>Qui sommes-nous ?</h5><br>
                Jeune entreprise spécialisée dans la vente d’essence de bois pour terrasse, charpente, clôture, bardage
                pour particuliers comme pour professionnels.


            </p>
            <a href="qui_somme_nous.php"> En savoir plus sur nous </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/about-img.jpg" alt="" />
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end about section -->
  <!-- portfolio section -->


  <section class="">
      <div class="container">
        <div class="heading_container heading_center">
<a href="activite.php"><h2>Nos <span><u>travaux réalisés</span></h2></a></u>
          <?php if ($has_permission): ?>
                <div class="">
                <a href="ajout_activite.php">Ajouter des activités</a>
                </div>
          <?php endif;?>
        </div>
        <div class="">
          <div class="filter_box">
          </div>
        </div>
      </div>
      <div class="product-grid">
        <?php
if (count($recent_activities) > 0) {
    echo "<div class='product-grid'>";
    foreach ($recent_activities as $activity) {
        echo "<div class='product-card'>";
        echo "<a href='detail_activite.php?id=" . $activity['id_activity'] . "'>";
        echo "<img src='" . htmlspecialchars($activity['image_path_product']) . "' alt='Activity Image'>";
        echo "<h3>" . htmlspecialchars($activity['name_activity']) . "</h3>";
        echo "</a>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Aucune activité trouvée.";
}
?>
      </div>
    </section>


  <!-- end portfolio section -->


    <!-- service section -->
    <section class="service_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Nos <span>Services</span></h2>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <a href="terrasse.php">
              <div class="box">
                <div class="img-box">
                </div>
                <div class="detail-box">
                  <h5>Bois de terrasse</h5>
                  <p>Bois de terrasse</p>
                </div>
              </div>
            </a>
          </div>


          <div class="col-sm-6 col-md-4">
            <a href="bardage.php">
              <div class="box">
                <div class="img-box">
                </div>
                <div class="detail-box">
                  <h5>Bardage</h5>
                  <p>Bardage</p>
                </div>
              </div>
            </a>
          </div>


          <div class="col-sm-6 col-md-4">
            <a href="cloture.php">
              <div class="box">
                <div class="img-box">
                </div>
                <div class="detail-box">
                  <h5>Cloture</h5>
                  <p>Cloture</p>
                </div>
              </div>
            </a>
          </div>


          <div class="col-sm-6 col-md-4">
            <a href="charpente.php">
              <div class="box">
                <div class="img-box">
                </div>
                <div class="detail-box">
                  <h5>Bois de charpente</h5>
                  <p>Bois de charpente</p>
                </div>
              </div>
            </a>
          </div>


          <div class="col-sm-6 col-md-4">
            <a href="osb.php">
            <div class="box">
              <div class="img-box">
              </div>
              <div class="detail-box">
                <h5>OSB</h5>
                <p>OSB</p>
              </div>
            </div>
            </a>
          </div>


          <div class="col-sm-6 col-md-4">
            <div class="box">
              <a href="quincaillerie.php">
              <div class="img-box">
              </div>
              <div class="detail-box">
                <h5>Quincaillerie</h5>
                <p>Quincaillerie</p>
              </div>
            </div>
          </div>
          </a>
        </div>
      </div>
    </section>


    <!-- end service section -->




  <!-- contact section -->
  <section class="contact-form-section">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Prenons<span> Contact</span></h2>
        </div>
        <div class="form-container">
            <form action="send_email.php" method="post">
                <div class="form-row">
                    <div class="form-group col">
                        <input type="text" name="name" class="form-control" placeholder="Votre nom" required />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <input type="text" name="phone" class="form-control" placeholder="Numéro de telephone" required />
                    </div>
                    <div class="form-group col-lg-6">
                        <select name="service" id="" class="form-control wide" required>
                            <option value="">Quelle prestation ?</option>
                            <option value="Devis">Devis</option>
                            <option value="Renseignement">Renseignement</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <input type="text" name="message" class="message-box form-control" placeholder="Message" required />
                    </div>
                </div>
                <div class="btn_box">
                    <button type="submit">Envoyer</button>
                </div>
                <?php
if (isset($_SESSION['mail_status'])) {
    echo '<div class="center-message"><p>' . $_SESSION['mail_status'] . '</p></div>';
    unset($_SESSION['mail_status']); // Effacer le message après l'affichage
}
?>
            </form>
        </div>
    </div>
</section>




  <!-- info section -->


  <section class="info_section">
    <div class="info_container layout_padding2">
      <div class="container">
        <div class="info_logo">
          <a class="navbar-brand" href="index.html"> Tc<span>Bois</span> </a>
        </div>
        <div class="info_main">
          <div class="row">
            <div class="col-md-3 col-lg-2">
              <div class="info_link-box">
                <h5>Lien utile</h5>
                <ul>
                  <li class="active">
                    <a class="" href="/index.php">Accueil <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="">
                    <a class="" href="service.php">Services </a>
                  </li>
                  <li class="">
                    <a class="" href="contact.php"> Contact </a>
                  </li>
                  <li class="">
                    <a class="" href="activite.php">Travaux realisés </a>
                  </li>
                  <li class="">
                    <a class="" href="connexion.php">Connexion </a>
                  </li>


                </ul>
              </div>
            </div>
            <!--
            <div class="col-md-3">
              <h5>Welding</h5>
              <p>
                Lorem ipsum dolor sit amet, consectetur
                adipiscinaliquaLoreadipiscing
              </p>
            </div>
            -->
            <div class="col-md-3 mx-auto">
              <h5>Réseau sociaux</h5>
              <div class="social_box">
                <a href="https://www.facebook.com/profile.php?id=100089498872438">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <!--
                <a href="#">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="#">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
                <a href="#">
                  <i class="fa fa-youtube-play" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            -->
              </div>
            </div>
            <div class="info_bottom">
              <div class="row">
                <div class="col-lg-9">
                  <div class="info_contact">
                    <div class="row">
                      <div class="col-md-3">
                        <a href="#" class="link-box">
                          <i class="fa fa-map-marker" aria-hidden="true"></i>
                          <span> 12 la gare 35540 Plerguer </span>
                        </a>
                      </div>
                      <div class="col-md-5">
                        <a href="#" class="link-box">
                          <i class="fa fa-phone" aria-hidden="true"></i>
                          <span> 06 42 07 35 77</span>
                        </a>
                      </div>
                      <div class="col-md-4">
                        <a href="#" class="link-box">
                          <i class="fa fa-envelope" aria-hidden="true"></i>
                          <span> agenaist@gmail.com </span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>


  <!-- end info section -->


  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!--  OwlCarousel 2 - Filter -->
  <script src="https://huynhhuynh.github.io/owlcarousel2-filter/dist/owlcarousel2-filter.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
    integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>




<style>
  p3 {
    color: #252525;
  }
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }


  .service_section {
    padding: 60px 0;
  }


  .heading_center {
    text-align: center;
    margin-bottom: 40px;
  }


  .heading_center h2 {
    color: #333;
  }


  .product-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
  }


  .product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    padding: 20px;
    text-align: center;
  }


  .product-card img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
  }


  .product-card h3 {
    color: #333;
    margin-bottom: 10px;
  }


  .product-card p {
    color: #666;
    line-height: 1.6;
  }


  .add-product {
    text-align: center;
    margin-bottom: 40px;
  }


  .add-product a {
    text-decoration: none;
    color: white;
    background-color: #28a745;
    padding: 10px 20px;
    border-radius: 5px;
  }


  .add-product a:hover {
    background-color: #218838;
  }


  .contact-form-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: vh; /* Ajustez la hauteur selon vos besoins */
    background-color: #f5f5f5;
    padding: 20px;
}


.contact-form-section .container {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 1000px;
    width: 100%;
}


.contact-form-section .heading_container {
    text-align: center;
    margin-bottom: 20px;
}


.contact-form-section .heading_container h2 {
    font-size: 2em;
    color: #333;
}


.contact-form-section .heading_container h2 span {
    color: #6B8E23;
}


.contact-form-section .form-container {
    width: 100%;
}


.contact-form-section .form-row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 15px;
}


.contact-form-section .form-group {
    width: 100%;
    margin-bottom: 15px;
}


.contact-form-section .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}


.contact-form-section .message-box {
    height: 100px;
}


.contact-form-section .btn_box {
    text-align: center;
}


.contact-form-section .btn_box button {
    background-color: #6B8E23;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}


.contact-form-section .btn_box button:hover {
    background-color: #45a049;
}


.contact-form-section .center-message {
    margin-top: 20px;
    padding: 15px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}


</style>


</html>

