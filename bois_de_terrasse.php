<?php
session_start();

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

// Récupération de l'email depuis la session
$email = $_SESSION['email'];

// Connexion à la base de données
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$connection) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Requête SQL pour obtenir les infos sur l'utilisateur
$query = "SELECT prenom_user FROM tbl_user WHERE mail_user='$email'";
$result = mysqli_query($connection, $query);

// Vérifier si la requête a abouti
if (!$result) {
    die("Erreur dans la requête : " . mysqli_error($connection));
}

// Stockage des données
$row = mysqli_fetch_assoc($result);
if ($row) {
    $user_firstname = $row['prenom_user'];
} else {
    $user_firstname = "Aucun prénom trouvé.";
}

// Requête SQL pour obtenir les infos sur le rôle
$query = "SELECT tbl_role.name_r FROM tbl_role
          JOIN tbl_user_role ON tbl_user_role.id_r_role = tbl_role.id_r
          JOIN tbl_user ON tbl_user_role.id_user_user = tbl_user.id_user
          WHERE tbl_user.mail_user = '$email'"; // Faire une commande préparer
$result = mysqli_query($connection, $query);

// Vérifier si la requête a abouti
if (!$result) {
    die("Erreur dans la requête : " . mysqli_error($connection));
}

// Stockage des données
$row = mysqli_fetch_assoc($result);
if ($row) {
    $user_role = $row['name_r'];
} else {
    $user_role = "Aucun rôle.";
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

  <title>Bardage</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
    integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="/css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="header_top"></div>
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="/index.php">Acceuil<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="service.html">Services</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="about.html">About</a>
                </li>-->
                <!-- <li class="nav-item">
                  <a class="nav-link" href="portfolio.html">Portfolio</a>
                </li>-->
                <!-- <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contactez-nous
                </a>
                </li>-->
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span> Connexion </span>
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
                <h1 align="center">TC-BOIS</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>

  <!--Produit start-->

  <?php

// Récupération de l'email depuis la session
$email = $_SESSION['email'];
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Échec de la connexion : " . $connection->connect_error);
}

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

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>

    <section class="service_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Nos <span>Bardage</span></h2>
        </div>
        <div class="row">
          <div class="product-grid">
            <?php if ($has_permission): ?>
              <div class="product-grid">
                <a href="ajout_produit.php" class="add-product-button">Ajouter des produits</a>
              </div>
            <?php endif;?>
            <?php
// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Afficher les produits ajoutés
$sql = "SELECT tbl_product.*, tbl_dimension.length_dimension, tbl_dimension.width_dimension, tbl_dimension.thickness_dimension
        FROM tbl_product
        JOIN tbl_product_type_of_product ON tbl_product.id_product = tbl_product_type_of_product.id_product_product
        JOIN tbl_dimension ON tbl_product_type_of_product.id_dimension_dimension = tbl_dimension.id_dimension
        ORDER BY tbl_product.id_product DESC";

$result = $conn->query($sql);

// Display the results
if ($result->num_rows > 0) {
    echo "<div class='product-grid'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<img src='" . htmlspecialchars($row['image_path_product'] ?? '') . "' alt='Product Image'>";
        echo "<h3>" . htmlspecialchars($row['name_product'] ?? 'Nom non disponible') . "</h3>";
        echo "<p>Essence: " . htmlspecialchars($row['essence_product'] ?? 'Essence non disponible') . "</p>";
        echo "<p>Longueur: " . htmlspecialchars($row['length_dimension'] ?? '0') . " cm</p>";
        echo "<p>Largeur: " . htmlspecialchars($row['width_dimension'] ?? '0') . " cm</p>";
        echo "<p>Épaisseur: " . htmlspecialchars($row['thickness_dimension'] ?? '0') . " cm</p>";
        echo "<p>Quantité: " . htmlspecialchars($row['quantity_product'] ?? '0') . "</p>";
        echo "<p>Description: " . htmlspecialchars($row['description_product'] ?? 'Description non disponible') . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Aucun produit trouvé.";
}

$conn->close();
?>
          </div>
        </div>
    </section>



    <!-- end service section -->

    <!-- contact section
  <section class="contact_section">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Prenons<span> Contact</span></h2>
      </div>
      <div class="row">
        <div class="col-md-6 px-0">
          <div class="form_container">
            <form action="">
              <div class="form-row">
                <div class="form-group col">
                  <input type="text" class="form-control" placeholder="Votre nom" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-lg-6">
                  <input type="text" class="form-control" placeholder="Numéro de telephone" />
                </div>
                <div class="form-group col-lg-6">
                  <select name="" id="" class="form-control wide">
                    <option value="">Quelle prestation ?</option>
                    <option value="">Service 1</option>
                    <option value="">Service 2</option>
                    <option value="">Service 3</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <input type="email" class="form-control" placeholder="Email" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <input type="text" class="message-box form-control" placeholder="Message" />
                </div>
              </div>
              <div class="btn_box">
                <button>Envoyer</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6 px-0">
          <div class="map_container">
            <div class="map">
              <div id="googleMap"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
end contact section -->

    <!-- info section -->

    <section class="info_section">
      <div class="info_container layout_padding2">
        <div class="container">
          <div class="info_logo">
            <a class="navbar-brand" href="index.html"> Tro<span>Weld</span> </a>
          </div>
          <div class="info_main">
            <div class="row">
              <div class="col-md-3 col-lg-2">
                <div class="info_link-box">
                  <h5>Lien utile</h5>
                  <ul>
                    <li class="active">
                      <a class="" href="/index.html">Acceuil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="">
                      <a class="" href="service.html">Services </a>
                    </li>
                    <li class="">
                      <a class="" href="contact.html"> Contact </a>
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
                <h5>social media</h5>
                <div class="social_box">
                  <a href="#">
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
                  <div class="col-md-3">
                    <div class="info_form">
                      <form action="">
                        <input type="email" placeholder="Enter Your Email" />
                        <button>
                          <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </section>

    <!-- end info section -->

    <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="/js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"></script>
    <!-- bootstrap js -->
    <script src="/js/bootstrap.js"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!--  OwlCarousel 2 - Filter -->
    <script src="https://huynhhuynh.github.io/owlcarousel2-filter/dist/owlcarousel2-filter.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
      integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
    <!-- custom js -->
    <script src="/js/custom.js"></script>
    <!-- Google Map -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
    <!-- End Google Map -->
  </body>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 80%;
      margin: auto;
      overflow: hidden;
    }

    h1,
    h2 {
      color: #333;
    }

    .product-form {
      background: #fff;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-form label {
      display: block;
      margin: 10px 0 5px;
    }

    .product-form input,
    .product-form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .product-form input[type="submit"] {
      background: #5cb85c;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 5px;
    }

    .product-form input[type="submit"]:hover {
      background: #4cae4c;
    }

    .product-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }

    .product-card {
      background: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      flex: 1 1 calc(33.333% - 40px);
      box-sizing: border-box;
    }

    .product-card img {
      max-width: 100%;
      height: auto;
      display: block;
      margin-bottom: 10px;
    }

    .product-card h3 {
      margin: 0 0 10px;
      color: #333;
    }

    .product-card p {
      margin: 0 0 10px;
      color: #666;
    }


    .product-grid {
      display: flex;
      flex-wrap: wrap;
    }

    .product-card {
      border: 1px solid #ddd;
      padding: 10px;
      margin: 10px;
      width: calc(33.333% - 20px);
      box-sizing: border-box;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-top: 20px;
    }

    .add-product-button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      background-color: #6B8E23;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .add-product-button:hover {
      background-color: #6B8E23;
    }

    .container {
      text-align: center;
      margin-top: 20px;
    }

    .container h1 {
      margin-bottom: 20px;
    }
  </style>


  </html>