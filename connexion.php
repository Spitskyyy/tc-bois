<?php
//---------------------------------------------------------------------------------------------------------//
// Connexion à la base de données MySQL
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

    if (isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $_SESSION['email'] = $email;

        // Vérifier si le compte existe
        $stmt = $dbh->prepare("SELECT * FROM tbl_user WHERE mail_user = :email AND password_user = PASSWORD(CONCAT('*-6', :password))");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            print (4); // Le compte existe
            echo "Connexion réussie.";
            header('location: /index.php');
        } else {
            // Le compte n'existe pas ou les identifiants sont incorrects
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>

</body>

</html>


<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card">
            <h1>Bienvenue !</h1>
            <form method="POST" action="connexion.php">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Email Address" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter mot de passe" required>
                </div>
                <br>
                <button type="submit">
                    Connexion
                </button>
            </form>
            <hr>
            <div class="links">
                <a class="small" href="forgot-password.php">Mot de passe oublié?</a>
                <a class="small" href="register.php">Créer un compte !</a>
            </div>
        </div>
    </div>
</body>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #eaf4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .card {
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .card h1 {
        margin-bottom: 20px;
        color: #6B8E23;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #6B8E23;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #225e5e;
    }

    .links {
        margin-top: 20px;
    }

    .links a {
        color: #6B8E23;
        text-decoration: none;
        display: block;
        margin: 5px 0;
        transition: color 0.3s;
    }

    .links a:hover {
        color: #225e5e;
    }

    .error-message {
        color: red;
        margin-bottom: 20px;
        font-size: 16px;
    }
</style>

</html>