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

if (mysqli_connect_error()) 
{
  echo 'Connexion echouer'. mysqli_connect_error();
}
else
'Connexion reussie';
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

    <title>TC Bois</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

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
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
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

              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class=""> </span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  <li class="nav-item active">
                    <a class="nav-link" href="index.html"
                      >Acceuil<span class="sr-only"></span
                    ></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/service.html">Services</a>
                  </li>
                  <!-- <li class="nav-item">
                  <a class="nav-link" href="about.html">About</a>
                </li>-->
                  <!-- <li class="nav-item">
                  <a class="nav-link" href="portfolio.html">Portfolio</a>
                </li>-->
                  <!-- <li class="nav-item">
                  <a class="nav-link" href="pages/contact.html">Contactez-nous
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
                  <h1>TC-BOIS</h1>
                  <h2>Le bois au juste prix. <br /></h2>
                  <h5>
                    Vente bois de terrasse, <br />
                    Bardage, <br />
                    Clôture, <br />
                    Bois de charpente.<br />
                  </h5>
                  <div class="btn-box">
                    <a href="" class="btn1"> En savoir plus </a>
                    <a href="" class="btn2"> Contactez-nous </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel_btn-box">
            <a
              class="carousel-control-prev"
              href="#customCarousel1"
              role="button"
              data-slide="prev"
            >
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
              <span class="sr-only">Previous</span>
            </a>
            <a
              class="carousel-control-next"
              href="#customCarousel1"
              role="button"
              data-slide="next"
            >
              <i class="fa fa-arrow-right" aria-hidden="true"></i>
              <span class="sr-only">Next</span>
            </a>
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
                Simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever
                since the 1500s, when an unknown printer took a galley of type
                and scrambled it to make a type specimen book. It has s
              </p>
              <a href=""> En savoir plus </a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="img-box">
              <img src="images/about-img.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- end about section -->

    <!-- portfolio section -->

    <section class="portfolio_section">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Nos travaux réaliser</h2>
        </div>
        <div class="carousel-wrap">
          <div class="filter_box">
            <nav class="owl-filter-bar">
              <a href="#" class="item active" data-owl-filter="*">All</a>
              <a href="#" class="item" data-owl-filter=".decorative"
                >DECORATIVE</a
              >
              <a href="#" class="item" data-owl-filter=".facade">FACADES </a>
              <a href="#" class="item" data-owl-filter=".perforated"
                >PERFORATED</a
              >
              <a href="#" class="item" data-owl-filter=".railing">RAILINGS </a>
            </nav>
          </div>
        </div>
      </div>
      <div class="owl-carousel portfolio_carousel">
        <div class="item decorative">
          <div class="box">
            <div class="img-box">
              <img src="images/p1.jpg" alt="" />
              <div class="btn_overlay">
                <a href="" class=""> Voir plus </a>
              </div>
            </div>
          </div>
        </div>
        <div class="item facade">
          <div class="box">
            <div class="img-box">
              <img src="images/p2.jpg" alt="" />
              <div class="btn_overlay">
                <a href="" class=""> Voir plus </a>
              </div>
            </div>
          </div>
        </div>
        <div class="item perforated decorative">
          <div class="box">
            <div class="img-box">
              <img src="images/p3.jpg" alt="" />
              <div class="btn_overlay">
                <a href="" class=""> Voir plus </a>
              </div>
            </div>
          </div>
        </div>
        <div class="item railing">
          <div class="box">
            <div class="img-box">
              <img src="images/p1.jpg" alt="" />
              <div class="btn_overlay">
                <a href="" class=""> Voir plus </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- end portfolio section -->

    <!-- service section -->

    <section class="service_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Nos <span>prestations de service</span></h2>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <a href="pages/bois_de_terrasse.html">
              <div class="box">
                <div class="img-box">
                  <img src="images/s1.png" alt="Bois de terrasse" />
                </div>
                <div class="detail-box">
                  <h5>Bois de terrasse</h5>
                  <p>Bois de terrasse</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-6 col-md-4">
            <a href="pages/Bardage.html">
              <div class="box">
                <div class="img-box">
                  <img src="images/s2.png" alt="Bois de terrasse" />
                </div>
                <div class="detail-box">
                  <h5>Bardage</h5>
                  <p>Bardage</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-6 col-md-4">
            <a href="pages/Cloture.html">
              <div class="box">
                <div class="img-box">
                  <img src="images/s3.png" alt="Bois de terrasse" />
                </div>
                <div class="detail-box">
                  <h5>Cloture</h5>
                  <p>Cloture</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-6 col-md-4">
            <a href="pages/Bois_de_charpente.html">
              <div class="box">
                <div class="img-box">
                  <img src="images/s4.png" alt="Bois de terrasse" />
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
                <img src="images/s5.png" alt="" />
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
                <img src="images/s6.png" alt="" />
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
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Votre nom"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Numéro de telephone"
                    />
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
                    <input
                      type="email"
                      class="form-control"
                      placeholder="Email"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col">
                    <input
                      type="text"
                      class="message-box form-control"
                      placeholder="Message"
                    />
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
    <!-- end contact section -->

    <!-- client section -->
    <!--<section class="client_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Testimonial
        </h2>
      </div>
      <div class="row">
        <div class="col-md-9 mx-auto">
          <div id="customCarousel2" class="carousel slide" data-ride="carousel">
            <div class="row">
              <div class="col-md-11">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="box">
                      <div class="client_id">
                        <div class="img-box">
                          <img src="images/client.jpg" alt="" />
                        </div>
                        <h5>
                          Alex Jonson
                        </h5>
                      </div>
                      <div class="detail-box">
                        <p>
                          ipsum dolor sit amet, consectetur adipiscing elit,
                          sed do eiusmod tempor incididunt ut labore et dolore
                          magna aliqua. Ut enim ad minim veniam, quis nostrud
                          exercitation ullamco laboris nisi ut aliquip ex ea
                          commodo consequat. Duis aute irure dolor in
                          reprehenderit in voluptate velit
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="box">
                      <div class="client_id">
                        <div class="img-box">
                          <img src="images/client.jpg" alt="" />
                        </div>
                        <h5>
                          Alex Jonson
                        </h5>
                      </div>
                      <div class="detail-box">
                        <p>
                          ipsum dolor sit amet, consectetur adipiscing elit,
                          sed do eiusmod tempor incididunt ut labore et dolore
                          magna aliqua. Ut enim ad minim veniam, quis nostrud
                          exercitation ullamco laboris nisi ut aliquip ex ea
                          commodo consequat. Duis aute irure dolor in
                          reprehenderit in voluptate velit
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="box">
                      <div class="client_id">
                        <div class="img-box">
                          <img src="images/client.jpg" alt="" />
                        </div>
                        <h5>
                          Alex Jonson
                        </h5>
                      </div>
                      <div class="detail-box">
                        <p>
                          ipsum dolor sit amet, consectetur adipiscing elit,
                          sed do eiusmod tempor incididunt ut labore et dolore
                          magna aliqua. Ut enim ad minim veniam, quis nostrud
                          exercitation ullamco laboris nisi ut aliquip ex ea
                          commodo consequat. Duis aute irure dolor in
                          reprehenderit in voluptate velit
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-1">
                <ol class="carousel-indicators">
                  <li data-target="#customCarousel2" data-slide-to="0" class="active"></li>
                  <li data-target="#customCarousel2" data-slide-to="1"></li>
                  <li data-target="#customCarousel2" data-slide-to="2"></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  -->
    <!-- end client section -->

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
                      <a class="" href="index.html"
                        >Home <span class="sr-only">(current)</span></a
                      >
                    </li>
                    <li class="">
                      <a class="" href="about.html">About </a>
                    </li>
                    <li class="">
                      <a class="" href="service.html">Services </a>
                    </li>
                    <li class="">
                      <a class="" href="portfolio.html"> Portfolio </a>
                    </li>
                    <li class="">
                      <a class="" href="contact.html"> Contact </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3">
                <h5>Welding</h5>
                <p>
                  Lorem ipsum dolor sit amet, consectetur
                  adipiscinaliquaLoreadipiscing
                </p>
              </div>
              <div class="col-md-3 mx-auto">
                <h5>social media</h5>
                <div class="social_box">
                  <a href="#">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                  </a>
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
              <div class="col-md-3">
                <h5>Our welding center</h5>
                <p>
                  Lorem ipsum dolor sit amet, consectetur
                  adipiscinaliquaLoreadipiscing
                </p>
              </div>
            </div>
          </div>
          <div class="info_bottom">
            <div class="row">
              <div class="col-lg-9">
                <div class="info_contact">
                  <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-5">
                      <a href="#" class="link-box">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span> 06 42 04 35 77 </span>
                      </a>
                    </div>
                    <div class="col-md-4">
                      <a href="#" class="link-box">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span> thierryagenais@free.fr </span>
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
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
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
    <script src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
    <!-- End Google Map -->
  </body>
</html>
