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


$query = "SELECT tbl_role.name_r FROM tbl_role 
          JOIN tbl_user_role ON tbl_user_role.id_r_role = tbl_role.id_r
          JOIN tbl_user ON tbl_user_role.id_user_user = tbl_user.id_user
          WHERE tbl_user.mail_user = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Ajouter un produit</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="product-form">
            <label for="description">Description du produit :</label>
            <textarea name="description" id="description" required></textarea><br><br>

            <label for="height">Hauteur (cm) :</label>
            <input type="number" step="0.01" name="height" id="height" required><br><br>

            <label for="width">Largeur (cm) :</label>
            <input type="number" step="0.01" name="width" id="width" required><br><br>

            <label for="depth">Épaisseur (cm) :</label>
            <input type="number" step="0.01" name="depth" id="depth" required><br><br>

            <label for="quantity">Quantité :</label>
            <input type="number" name="quantity" id="quantity" required><br><br>

            <label for="image">Choisir une image :</label>
            <input type="file" name="image" id="image" accept="image/*" required><br><br>

            <input type="submit" name="submit" value="Ajouter le produit">
        </form>


    </div>
</body>
<?php


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

$stmt->close();

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $description = $connection->real_escape_string($_POST['description']);
    $height = $connection->real_escape_string($_POST['height']);
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

            if ($connection->query($sql) === TRUE) {
                $last_id = $connection->insert_id;

                // Insérer les dimensions
                $sql_dimension = "INSERT INTO tbl_dimension (width_dimension, width_dimension_1, thickness_dimension) VALUES ('$height', '$width', '$depth')";
                if ($connection->query($sql_dimension) === TRUE) {
                    $last_dimension_id = $connection->insert_id;

                    // Associer le produit à la dimension
                    $sql_product_dimension = "INSERT INTO tbl_product_dimension (id_product_product, id_dimension_dimension) VALUES ('$last_id', '$last_dimension_id')";
                    if ($connection->query($sql_product_dimension) === TRUE) {
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
</style>

</html>