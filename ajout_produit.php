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
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$connection) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Vérifier si l'utilisateur a la permission d'ajouter des produits
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
    header("Location: index.php");
    exit();
}

$stmt->close();

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $name = $connection->real_escape_string($_POST['name']);
    $essence = $connection->real_escape_string($_POST['essence']);
    $description = $connection->real_escape_string($_POST['description']);
    $height = $connection->real_escape_string($_POST['height']);
    $width = $connection->real_escape_string($_POST['width']);
    $depth = $connection->real_escape_string($_POST['depth']);
    $quantity = $connection->real_escape_string($_POST['quantity']);
    $product_type = $connection->real_escape_string($_POST['product_type']);

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
            $sql = "INSERT INTO tbl_product (name_product, essence_product, description_product, image_path_product, quantity_product) 
                    VALUES ('$name', '$essence', '$description', '$image_path', '$quantity')";

            if ($connection->query($sql) === TRUE) {
                $last_id = $connection->insert_id;

                // Insérer les dimensions
                $sql_dimension = "INSERT INTO tbl_dimension (length_dimension, width_dimension, thickness_dimension) 
                                  VALUES ('$height', '$width', '$depth')";
                if ($connection->query($sql_dimension) === TRUE) {
                    $last_dimension_id = $connection->insert_id;

                    // Associer le produit à la dimension et au type
                    $sql_product_type = "INSERT INTO tbl_product_type_of_product (id_product_product, id_type_of_product_type_of_product) 
                                         VALUES ('$last_id', '$product_type')";
                    $sql_product_dimension = "INSERT INTO tbl_product_dimension (id_product, id_dimension) 
                                              VALUES ('$last_id', '$last_dimension_id')";
                    if ($connection->query($sql_product_dimension) === TRUE && $connection->query($sql_product_type) === TRUE) {
                        // Rediriger vers la page appropriée en fonction du type de produit
                        $redirect_page = '';
                        switch ($product_type) {
                            case '1':
                                $redirect_page = 'bardage.php';
                                break;
                            case '2':
                                $redirect_page = 'bois_de_charpente.php';
                                break;
                            case '3':
                                $redirect_page = 'bois_de_terrasse.php';
                                break;
                            case '4':
                                $redirect_page = 'cloture.php';
                                break;
                        }
                        header("Location: $redirect_page?id=$last_id");
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

<body>
    <div class="container">
        <h1 align="center">Ajouter un produit</h1>
        <form action="ajout_produit.php" method="post" enctype="multipart/form-data" class="product-form">
            <label for="name">Nom du produit :</label>
            <input type="text" name="name" id="name" required><br><br>

            <label for="essence">Essence du produit :</label>
            <input type="text" name="essence" id="essence" required><br><br>

            <label for="product_type">Type de produit :</label>
            <select name="product_type" id="product_type" required>
                <option value="1">Bardage</option>
                <option value="2">Bois de charpente</option>
                <option value="3">Bois de terrasse</option>
                <option value="4">Clôture</option>
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

    h1, h2 {
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
    .product-form textarea,
    .product-form select {
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
