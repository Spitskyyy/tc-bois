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
          WHERE tbl_user.mail_user = '$email'";
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
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Bardage</title>

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



    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un produit</title>
    </head>
    <body>
        <form action="bardage.php" method="post" enctype="multipart/form-data">
            <label for="description">Description du produit :</label>
            <textarea name="description" id="description" required></textarea><br><br>
            
            <label for="image">Choisir une image :</label>
            <input type="file" name="image" id="image" accept="image/*" required><br><br>
            
            <input type="submit" name="submit" value="Ajouter le produit">
        </form>
    </body>
    </html>
  
    <!--Produit end-->



    <!-- service section -->

    <section class="service_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Nos <span>Bardage</span></h2>
        </div>
        <div class="row">

          <div class="col-sm-6 col-md-4">
            <a href="bardage.html">
              <div class="box">
                <div class="img-box">
                  <img src="/images/s2.png" alt="Bois de terrasse" />
                </div>
                <div class="detail-box">
                  <h5>Bardage</h5>
                  <p>Bardage</p>
                </div>
              </div>
            </a>
          </div>

        <div class="btn-box">
          <a href=""> En savoir plus </a>
        </div>
      </div>
    </section>

    <?php

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Récupérer la description du produit
    $description = $conn->real_escape_string($_POST['description']);

    // Gestion de l'upload de l'image
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Vérifier la taille du fichier (ex. max 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats de fichiers
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est à 0 à cause d'une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    // Si tout est ok, essayer de télécharger le fichier
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Le fichier ". htmlspecialchars(basename($_FILES["image"]["name"])). " a été téléchargé.";

            // Insérer les informations dans la base de données
            $image_path = $connection->real_escape_string($target_file);
            $sql = "INSERT INTO tbl_product (description_product, image_path) VALUES ('$description', '$image_path')";

            if ($conn->query($sql) === TRUE) {
                // Rediriger vers la page de détail du produit
                $last_id = $connection->insert_id;
                // header("Location: product_detail.php?id=$last_id");
                exit();
            } else {
                echo "Erreur : " . $sql . "<br>" . $connection->error;
            }
        } else {
            echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
        }
    }
}

$connection->close();
?>

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
                      <a class="" href="/index.html"
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
                    <div class="col-md-3">
                      <a href="#" class="link-box">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span> Location </span>
                      </a>
                    </div>
                    <div class="col-md-5">
                      <a href="#" class="link-box">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span> Call +01 1234567890 </span>
                      </a>
                    </div>
                    <div class="col-md-4">
                      <a href="#" class="link-box">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span> demo@gmail.com </span>
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
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
    <!-- End Google Map -->
  </body>
</html>
