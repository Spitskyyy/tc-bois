<?php
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

    $message = "";

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Vérifier si le compte existe
        $stmt = $dbh->prepare("SELECT * FROM tbl_user WHERE mail_user = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify("*-6" . $password, $user['password_user'])) {
            $_SESSION['email'] = $email;
            $message = "Connexion réussie.";
            header('Location: /index.php');
            exit();
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
} catch (PDOException $e) {
    $message = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
</head>

<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <p>Bienvenue! Veuillez vous connecter à votre compte.</p>
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo ($message == "Connexion réussie.") ? 'success' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="connexion.php">
            <input type="text" name="email" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
        <a href="#">Mot de passe oublié ?</a>
    </div>
</body>

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

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #343a40;
            font-size: 28px;
            font-weight: bold;
        }

        .login-container p {
            color: #6c757d;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
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

        .login-container input[type="submit"]:hover {
            background-color: #556B2F;
        }

        .login-container a {
            display: block;
            margin-top: 20px;
            color: #6B8E23;
            text-decoration: none;
            font-size: 14px;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        .login-container .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .success {
            background-color: #6B8E23;
        }
    </style>
</html>
