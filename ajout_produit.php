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

// Vérifier si une session est déjà active avant de la démarrer
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

// Requête SQL pour obtenir le rôle de l'utilisateur
$query = "SELECT tbl_role.name_r FROM tbl_role
          JOIN tbl_user_role ON tbl_user_role.id_r_role = tbl_role.id_r
          JOIN tbl_user ON tbl_user_role.id_user_user = tbl_user.id_user
          WHERE tbl_user.mail_user = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$has_permission = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['name_r'] == 'PRO') {
            $has_permission = true;
            break;
        }
    }
}

if (!$has_permission) {
    header("Location: index.php");
    exit();
}

$stmt->close();

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $description = $connection->real_escape_string($_POST['description']);
    $length = $connection->real_escape_string($_POST['length']);
    $width = $connection->real_escape_string($_POST['width']);
    $depth = $connection->real_escape_string($_POST['depth']);
    $quantity = $connection->real_escape_string($_POST['quantity']);

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
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est à 0 à cause d'une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["image"]["name"])) . " a été téléchargé.";

            // Insérer les informations dans la base de données
            $image_path = $connection->real_escape_string($target_file);
            $sql = "INSERT INTO tbl_product (description_product, image_path_product, quantity_product) VALUES ('$description', '$image_path', '$quantity')";

            if ($connection->query($sql) === true) {
                $last_id = $connection->insert_id;

                // Insérer les dimensions
                $sql_dimension = "INSERT INTO tbl_dimension (width_dimension, width_dimension_1, thickness_dimension) VALUES ('$height', '$width', '$depth')";
                if ($connection->query($sql_dimension) === true) {
                    $last_dimension_id = $connection->insert_id;

                    // Associer le produit   à la dimension
                    $sql_product_dimension = "INSERT INTO tbl_product_dimension (id_product_product, id_dimension_dimension) VALUES ('$last_id', '$last_dimension_id')";
                    if ($connection->query($sql_product_dimension) === true) {
                        header("Location: bardage.php?id=$last_id");
                        exit();
                    } else {
                        echo "Erreur : " . $sql_product_dimension . "<br>" . $connection->error;
                    }
                } else {
                    echo "Erreur : " . $sql_dimension . "<br>" . $connection->error;
                }
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
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="styles.css">
</head>

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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
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
                                    <a class="nav-link" href="service.php">Services</a>
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

        <body>
            <div class="container">
                <h1 align="center">Ajouter un produit</h1>
                <form action="upload.php" method="post" enctype="multipart/form-data" class="product-form">
                    <label for="name">Nom du produit :</label>
                    <input type="text" name="name" id="name" required><br><br>

                    <label for="essence">Essence du produit :</label>
                    <input type="text" name="essence" id="essence" required><br><br>

                    <label for="type_of_product">Type de produit :</label>
                    <select name="type_of_product" id="type_of_product" required>
                        <option value="bardage">Bardage</option>
                        <option value="terrasse">Bois de terrasse</option>
                        <option value="charpente">Bois de charpente</option>
                        <option value="cloture">Clôture</option>
                    </select><br><br>

                    <label for="height">Longueur (m) :</label>
                    <input type="number" step="0.01" name="height" id="height" required><br><br>

                    <label for="width">Largeur (cm) :</label>
                    <input type="number" step="0.01" name="width" id="width" required><br><br>

                    <label for="depth">Épaisseur (cm) :</label>
                    <input type="number" step="0.01" name="depth" id="depth" required><br><br>

                    <label for="quantity">Quantité :</label>
                    <input type="number" name="quantity" id="quantity" required><br><br>

                    <label for="description">Description du produit :</label>
                    <textarea name="description" id="description" required></textarea><br><br>

                    <label for="image">Choisir une image :</label>
                    <input type="file" name="image" id="image" accept="image/*" required><br><br>

                    <input type="submit" name="submit" value="Ajouter le produit">
                </form>
            </div>

        </body>



</html>

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
</style>