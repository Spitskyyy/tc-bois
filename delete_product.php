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

if (isset($_GET['id_product'])) {
    $id_product = intval($_GET['id_product']);

    // Commencer une transaction
    $connection->begin_transaction();

    try {
        // Préparer la requête pour supprimer les relations dans tbl_product_type_of_product
        $stmt1 = $connection->prepare("DELETE FROM tbl_product_type_of_product WHERE id_product_product = ?");
        if (!$stmt1) {
            throw new Exception($connection->error);
        }
        $stmt1->bind_param("i", $id_product);
        $stmt1->execute();

        // Préparer la requête pour supprimer les relations dans tbl_product_dimension
        $stmt2 = $connection->prepare("DELETE FROM tbl_product_dimension WHERE id_product_product = ?");
        if (!$stmt2) {
            throw new Exception($connection->error);
        }
        $stmt2->bind_param("i", $id_product);
        $stmt2->execute();

        // Préparer la requête pour supprimer le produit lui-même dans tbl_product
        $stmt3 = $connection->prepare("DELETE FROM tbl_product WHERE id_product = ?");
        if (!$stmt3) {
            throw new Exception($connection->error);
        }
        $stmt3->bind_param("i", $id_product);
        $stmt3->execute();

        // Valider la transaction
        $connection->commit();

        // Redirection après suppression réussie
        header("Location: service.php"); // Remplacer par la page de redirection désirée
        exit();

    } catch (Exception $exception) {
        // Rétablir la transaction en cas d'erreur
        $connection->rollback();
        echo "Erreur lors de la suppression du produit: " . $exception->getMessage();
    } finally {
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        $connection->close();
    }
} else {
    echo "Aucun produit sélectionné pour la suppression.";
}
?>
