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

// Connexion à la base de données
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Échec de la connexion : " . $connection->connect_error);
}

// Vérifier si l'utilisateur a la permission d'ajouter un produit
$email = $_SESSION['email'];

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
    echo "Vous n'avez pas la permission d'ajouter un produit.";
    exit();
}

// Ajouter un produit
if (isset($_POST['submit'])) {
    $name = $connection->real_escape_string($_POST['name']);
    $essence = $connection->real_escape_string($_POST['essence']);
    $description = $connection->real_escape_string($_POST['description']);
    $length = $connection->real_escape_string($_POST['height']); // Correction du nom du champ
    $width = $connection->real_escape_string($_POST['width']);
    $depth = $connection->real_escape_string($_POST['depth']);
    $quantity = $connection->real_escape_string($_POST['quantity']);
    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    if ($_FILES["image"]["size"] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["image"]["name"])) . " a été téléchargé.";

            $image_path = $connection->real_escape_string($target_file);
            $sql = "INSERT INTO tbl_product (name_product, essence_product, quantity_product, description_product, image_path_product)
                    VALUES ('$name', '$essence', '$quantity', '$description', '$image_path')";

            if ($connection->query($sql) === true) {
                $last_product_id = $connection->insert_id;
                $sql_dimension = "INSERT INTO tbl_dimension (length_dimension, width_dimension, thickness_dimension)
                                  VALUES ('$length', '$width', '$depth')";
                if ($connection->query($sql_dimension) === true) {
                    $last_dimension_id = $connection->insert_id;
                    $sql_product_dimension = "INSERT INTO tbl_product_type_of_product (id_dimension_dimension, id_product_product)
                                              VALUES ('$last_dimension_id', '$last_product_id')";
                    if ($connection->query($sql_product_dimension) === true) {
                        header("Location: bardage.php");
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
