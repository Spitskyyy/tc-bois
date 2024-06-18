<?php
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

if (isset($_GET['id'])) {
    $id_activity = intval($_GET['id']);

    $sql = "SELECT * FROM tbl_activity WHERE id_activity = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_activity);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $activity = $result->fetch_assoc();
    } else {
        echo "Activité non trouvée.";
        exit();
    }
} else {
    echo "ID d'activité non spécifié.";
    exit();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'activité</title>
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

        .activity-detail {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px;
            padding: 20px;
            text-align: center;
        }

        .activity-detail h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .activity-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .activity-detail p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="activity-detail">
        <h1><?php echo htmlspecialchars($activity['name_activity']); ?></h1>
        <img src="<?php echo htmlspecialchars($activity['image_path_product']); ?>" alt="Image de l'activité">
        <p><?php echo nl2br(htmlspecialchars($activity['detail_activity'])); ?></p>
    </div>
</body>

</html>