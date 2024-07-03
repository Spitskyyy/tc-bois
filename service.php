<?php
session_start();

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Variable d'environnement
$servername = $_ENV['BD_HOST'];
$username = $_ENV['BD_USER'];
$password = $_ENV['BD_PASS'];
$dbname = $_ENV['BD_NAME'];

$connection = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
    echo 'Connexion echouer' . mysqli_connect_error();
} else {
    'Connexion reussie';
}

?>


<!DOCTYPE html>
<html>
  <head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Nos services</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />

    <!-- fonts style -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <!--owl slider stylesheet -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    />
    <!-- nice select -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
      integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4="
      crossorigin="anonymous"
    />
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
                    <a class="nav-link" href="/index.php"
                      >Acceuil<span class="sr-only"></span
                    ></a>
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
                  <h1 align="center">TC-BOIS</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- end slider section -->
    </div>

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
            <div class="box">
              <div class="img-box">
              </div>
              <div class="detail-box">
                <h5>Vente Particuliers</h5>
                <p>Vente Particuliers</p>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-md-4">
            <div class="box">
              <div class="img-box">
              </div>
              <div class="detail-box">
                <h5>Ventes Professionels</h5>
                <p>Ventes Professionels</p>
              </div>
            </div>
          </div>
        </div>

        <div class="btn-box">
          <a href=""> En savoir plus </a>
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
                            <option value="Service 1">Service 1</option>
                            <option value="Service 2">Service 2</option>
                            <option value="Service 3">Service 3</option>
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
              <h5>social media</h5>
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
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <!-- bootstrap js -->
    <script src="/js/bootstrap.js"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!--  OwlCarousel 2 - Filter -->
    <script src="https://huynhhuynh.github.io/owlcarousel2-filter/dist/owlcarousel2-filter.min.js"></script>
    <!-- nice select -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
      integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo="
      crossorigin="anonymous"
    ></script>
    <!-- custom js -->
    <script src="/js/custom.js"></script>
  </body>


<style>
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
    color: #4CAF50;
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
    background-color: #4CAF50;
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
