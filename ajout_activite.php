<?php
session_start();

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['BD_HOST'];
$username = $_ENV['BD_USER'];
$password = $_ENV['BD_PASS'];
$dbname = $_ENV['BD_NAME'];

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Échec de la connection : " . $connection->connect_error);
}

// Vérifier si l'utilisateur a la permission d'ajouter une activité
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
    echo "Vous n'avez pas la permission d'ajouter une activité.";
    exit();
}

// Ajouter une activité
if (isset($_POST['submit'])) {
    $title = $connection->real_escape_string($_POST['title']);
    $description = $connection->real_escape_string($_POST['description']);
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
            $sql = "INSERT INTO tbl_activity (name_activity, detail_activity,  image_path_product) 
                    VALUES ('$title', '$description', '$image_path')";

            if ($connection->query($sql) === TRUE) {
                header("Location: index.php");
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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une activité</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px;
            padding: 20px;
            text-align: center;
        }

        .form-container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .error-message {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Ajouter une activité</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Titre de l'activité" required>
            <textarea name="description" placeholder="Description de l'activité" rows="4" required></textarea>
            <input type="file" name="image" required>
            <input type="submit" name="submit" value="Ajouter l'activité">
        </form>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>