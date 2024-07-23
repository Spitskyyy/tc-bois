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




// Vérifier la connexion
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET['id_activity'])) {
    $id_activity = intval($_GET['id_activity']);

    // Commencer une transaction
    $connection->begin_transaction();

    try {
        // Préparer la requête pour supprimer le produit lui-même dans tbl_product
        $stmt3 = $connection->prepare("DELETE FROM tbl_activity WHERE id_activity = ?");
        if (!$stmt3) {
            throw new Exception($connection->error);
        }
        $stmt3->bind_param("i", $id_activity);
        $stmt3->execute();

        // Valider la transaction
        $connection->commit();

        // Redirection après suppression réussie
        header("Location: activite.php"); // Remplacer par la page de redirection désirée
        exit();

    } catch (Exception $exception) {
        // Rétablir la transaction en cas d'erreur
        $connection->rollback();
        echo "Erreur lors de la suppression du produit: " . $exception->getMessage();
    } finally {
        if (isset($stmt3)) {
            $stmt3->close();
        }

        $connection->close();
    }
} else {
    echo "Aucun produit sélectionné pour la suppression.";
}
