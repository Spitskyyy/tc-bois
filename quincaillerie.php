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

  <title>Quincaillerie</title>

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

  <!-- Custom styles  -->
  <link href="/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="/css/responsive.css" rel="stylesheet" />
</head>

<body>
<div class="">
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
                  <a class="nav-link" href="index.php">Acceuil<span class="sr-only"></span></a>
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


    <section class="about_us_section">
    <div class="container">
      <h1>Notre quincaillerie</h1>
      <br>
      <p>
        Chez <strong>TcBois</strong>, nous ne vendons pas seulement du bois, mais aussi une vaste gamme de quincaillerie pour charpentiers. Nous proposons :
      </p>
      <ul>
        <li align="center">Boulonnerie diverse</li>

      </ul>
      <p>
        Notre engagement ne s'arrête pas à la vente de bois. Nous vous accompagnons de A à Z, vous fournissant tout le nécessaire pour votre terrasse, y compris la visserie, les bandes d'étanchéité, et bien plus encore.
      </p>
      <p>
        Faites confiance à <strong>TcBois</strong> pour transformer vos espaces extérieurs en véritables havre de paix, alliant beauté naturelle et fonctionnalité.
      </p>
      <p>
        N'hésitez pas à nous contacter pour discuter de votre projet. Ensemble, réalisons vos rêves d'aménagement extérieur !
      </p>
    </div>
</section>




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
                    <a class="" href="/index.php">Acceuil <span class="sr-only">(current)</span></a>
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

  <!-- footer section -->
  <footer class="footer_section">

  </footer>
  <!-- footer section -->

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
    text-align: center;
    margin-top: 20px;
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

.product-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
    justify-content: center;
}

.product {
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    flex: 1 1 calc(33.333% - 40px);
    box-sizing: border-box;
    text-align: center;
    max-width: 300px; /* Pour limiter la largeur maximale de chaque produit */
}

.product img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto 10px; /* Centrer l'image horizontalement */
}

.product h2 {
    margin: 0 0 10px;
    color: #333;
}

.product p {
    margin: 0 0 10px;
    color: #666;
}

.product-actions {
    margin-top: 10px;
}

.action-link {
    display: inline-block;
    padding: 5px 10px;
    margin: 5px;
    color: white;
    background-color:#6B8E23;
    border: none;
    border-radius: 3px;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s;
}

.action-link:hover {
    background-color: #ccc;
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
  background-color: #ccc;
}

.container h1 {
    margin-bottom: 20px;
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

.about_us_section {
    padding: 60px 20px;
    background-color: #f9f9f9;
}

.about_us_section .container {
    max-width: 800px;
    margin: auto;
    text-align: center;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.about_us_section h1 {
    color: #333;
    margin-bottom: 20px;
    font-size: 2.5em;
}

.about_us_section p {
    color: #666;
    line-height: 1.8;
    font-size: 1.1em;
    margin-bottom: 30px;
}

.about_us_section ul {
    list-style-type: none;
    padding: 0;
    text-align: left;
}

.about_us_section ul li {
    background: url('path/to/icon.png') no-repeat left center;
    padding-left: 35px;
    margin-bottom: 15px;
    font-size: 1.1em;
    color: #555;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.about_us_section ul li:hover {
    background-color: #f1f1f1;
    color: #333;
}

  </style>




  </html>