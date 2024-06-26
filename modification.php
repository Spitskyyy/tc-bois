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
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les informations existantes du produit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dbh->prepare("SELECT * FROM tbl_product WHERE id_product = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Produit non trouvé.");
    }
} else {
    die("ID de produit manquant.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le produit</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #343a40;
            font-size: 28px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px 15px;
            background-color: #6B8E23;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #556B2F;
        }

        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier le produit</h2>
        <form action="modifier_bardage.php" method="post">
            <input type="hidden" name="id" value="<?php echo $product['id_product']; ?>">
            <input type="text" name="name" placeholder="Nom du produit" value="<?php echo htmlspecialchars($product['name_product']); ?>" required>
            <input type="number" name="quantity" placeholder="Quantité" value="<?php echo htmlspecialchars($product['quantity_product']); ?>" required>
            <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($product['description_product']); ?></textarea>
            <input type="text" name="essence" placeholder="Essence" value="<?php echo htmlspecialchars($product['essence_product']); ?>" required>
            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>
