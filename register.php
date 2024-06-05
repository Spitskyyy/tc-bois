<?php

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
} catch (PDOException $e) {
    $code = $e->getCode();
    if ($code == 23000) {
        $errorMessage = "Cette adresse email existe déjà.";
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
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div>
            <div>

                <div >
                    <div >
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div>
                                <div>
                                    <div>
                                        <h1>Créer un compte!</h1>
                                    </div>
                                    <form class="user" method="post" action="register.php">
                                        <div>
                                            <div>
                                                <input type="text" name="nom" placeholder="Nom">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="prenom" placeholder="Prénom">
                                            </div>
                                        </div>
                                        <div>
                                            <input type="email" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="text"name="phone" placeholder="Numéro de Téléphone">
                                        </div>
                                        <div>
                                            <div>
                                                <input type="password"name="password" placeholder="Mot de Passe">
                                            </div>
                                            <div>
                                                <input type="password"name="RepeatPassword" placeholder="Confirmation MDP">
                                            </div>
                                        </div>

                                        <?php if (!empty($errorMessage)) {?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $errorMessage; ?>
                                            </div>
                                        <?php }?>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Valider le compte
                                        </button>
                                    </form>
                                    <hr>
                                    <div>
                                        <a href="forgot-password.php">Mot de passe oublié?</a>
                                    </div>
                                    <div>
                                        <a href="connexion.php">Déjà un compte? Connectez-vous!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<style></style>

</html>
