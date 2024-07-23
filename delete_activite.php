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
