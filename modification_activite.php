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

// Récupération de l'email depuis la session
$email = $_SESSION['email'];

// Connexion à la base de données
$connection = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($connection->connect_error) {
    die("La connexion a échoué : " . $connection->connect_error);
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

// Vérifier si l'ID de l'activité est présent dans l'URL
if (!isset($_GET['id_activity']) || empty($_GET['id_activity'])) {
    die("ID de l'activité manquant.");
}

$id_activity = $_GET['id_activity'];

// Récupérer les données actuelles de l'activité
$query = "SELECT * FROM tbl_activity WHERE id_activity = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_activity);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Activité non trouvée.");
}

$activity = $result->fetch_assoc();

// Mettre à jour les données de l'activité si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_activity = $_POST['name_activity'];
    $detail_activity = $_POST['detail_activity'];
    $image_path_product = $_POST['image_path_product'];

    // Mettre à jour les informations de l'activité
    $update_activity_query = "UPDATE tbl_activity SET name_activity = ?, detail_activity = ?, image_path_product = ? WHERE id_activity = ?";
    $stmt = $connection->prepare($update_activity_query);
    $stmt->bind_param("sssi", $name_activity, $detail_activity, $image_path_product, $id_activity);

    if ($stmt->execute()) {
        // Redirection après mise à jour réussie
        header('Location: activite.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'activité : " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mise à jour de l'activité</title>
</head>
<body>
    <!-- Formulaire de mise à jour de l'activité -->
    <form method="POST">
        <label for="name_activity">Nom de l'activité:</label>
        <input type="text" id="name_activity" name="name_activity" value="<?php echo htmlspecialchars($activity['name_activity']); ?>"><br>

        <label for="detail_activity">Détail:</label>
        <textarea id="detail_activity" name="detail_activity"><?php echo htmlspecialchars($activity['detail_activity']); ?></textarea><br>

        <label for="image_path_product">Chemin de l'image:</label>
        <input type="text" id="image_path_product" name="image_path_product" value="<?php echo htmlspecialchars($activity['image_path_product']); ?>"><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-top: 20px;
    }

    form {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        box-sizing: border-box;
        margin-top: 20px;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    form input[type="text"],
    form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    form textarea {
        resize: vertical;
        height: 100px;
    }

    form input[type="submit"] {
        background: #5cb85c;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    form input[type="submit"]:hover {
        background: #4cae4c;
    }
</style>

</html>
