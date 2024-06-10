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
$connection = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($connection->connect_error) {
    die("Échec de la connexion : " . $connection->connect_error);
}

// Vérifier si l'utilisateur a la permission d'ajouter un produit
$email = $_SESSION['email'];

$query = "SELECT tbl_role.name_r FROM tbl_role 
JOIN tbl_user_role ON tbl_user_role.id_r_role = tbl_role.id_r
JOIN tbl_user ON tbl_user_role.id_user_user = tbl_user.id_user
WHERE tbl_user.mail_user = '$email';";

$result = mysqli_query($connection, $query);
if (!$result) {
    die('Erreur : ' . mysqli_error($conn));
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

if (!$has_permission) {
    echo "Vous n'avez pas la permission d'ajouter un produit.";
    exit();
}

if (isset($_POST['submit'])) {
    // Récupérer la description du produit
    $description = $connection->real_escape_string($_POST['description']);

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
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est à 0 à cause d'une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
        // Si tout est ok, essayer de télécharger le fichier
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["image"]["name"])) . " a été téléchargé.";

            // Insérer les informations dans la base de données
            $image_path = $connection->real_escape_string($target_file);
            $sql = "INSERT INTO tbl_product (description_product, image_path_product) VALUES ('$description', '$image_path')";

            if ($connection->query($sql) === TRUE) {
                // Rediriger vers la page d'accueil avec l'ID du produit nouvellement ajouté
                $last_id = $connection->insert_id;
                header("Location: bardage.php?id=$last_id");
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