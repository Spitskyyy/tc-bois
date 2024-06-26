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

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier le rôle de l'utilisateur
$email = $_SESSION['email'];

$query = "SELECT tbl_role.name_r FROM tbl_role
          JOIN tbl_user_role ON tbl_user_role.id_r_role = tbl_role.id_r
          JOIN tbl_user ON tbl_user_role.id_user_user = tbl_user.id_user
          WHERE tbl_user.mail_user = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Connexion à la base de données
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier s'il existe déjà des utilisateurs dans la table
    $user_check_stmt = $dbh->prepare("SELECT COUNT(*) FROM tbl_user");
    $user_check_stmt->execute();
    $user_count = $user_check_stmt->fetchColumn();

    if ($user_count > 0) {
        $errorMessage = "Un utilisateur existe déjà. La création d'un nouvel utilisateur est désactivée.";
    } else {
        if (isset($_POST['password']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['RepeatPassword'])) {
            $password = $_POST['password'];
            $password2 = $_POST['RepeatPassword'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            if ($password != $password2) {
                $errorMessage = "Les mots de passe ne correspondent pas.";
            } else {
                // Préparation de la requête d'insertion
                $stmt = $dbh->prepare("INSERT INTO tbl_user (password_user, nom_user, prenom_user, mail_user, phone_user) VALUES (PASSWORD(CONCAT('*-6',:password)), :nom, :prenom, :email, :phone)");

                // Liaison des paramètres
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);

                // Exécution de la requête
                $stmt->execute();

                header('location: /connexion.php');
            }
        }
    }
} catch (PDOException $e) {
    $code = $e->getCode();
    if ($code == 23000) {
        $errorMessage = "Cette adresse email existe déjà.";
    } else {
        $errorMessage = "Erreur de connexion à la base de données: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Création du compte</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers le fichier CSS -->
</head>

<body>
    <div class="register-container">
        <h2>Créer un compte!</h2>
        <form class="user" method="post" action="register.php">
            <div>
                <input type="text" name="nom" placeholder="Nom" required>
            </div>
            <div>
                <input type="text" name="prenom" placeholder="Prénom" required>
            </div>
            <div>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div>
                <input type="text" name="phone" placeholder="Numéro de Téléphone" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="Mot de Passe" required>
            </div>
            <div>
                <input type="password" name="RepeatPassword" placeholder="Confirmation MDP" required>
            </div>
            <?php if (!empty($errorMessage)) {?>
                <div class="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php }?>
            <input type="submit" value="Valider le compte">
        </form>
        <a href="connexion.php">Déjà un compte? Connectez-vous!</a>
    </div>
</body>

</html>



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

.register-container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 100%;
    text-align: center;
}

.register-container h2 {
    margin-bottom: 20px;
    color: #343a40;
    font-size: 28px;
    font-weight: bold;
}

.register-container input[type="text"],
.register-container input[type="email"],
.register-container input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}

.register-container input[type="submit"] {
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

.register-container input[type="submit"]:hover {
    background-color: #6B8E23;
}

.register-container a {
    display: block;
    margin-top: 20px;
    color: #6B8E23;
    text-decoration: none;
    font-size: 14px;
}

.register-container a:hover {
    text-decoration: underline;
}

.alert {
    padding: 15px;
    background-color: #f44336;
    color: white;
    margin-bottom: 20px;
    border-radius: 4px;
}

.success {
    background-color: #4CAF50;
}

</style>