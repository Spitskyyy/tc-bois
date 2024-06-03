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

    if (isset($_POST['mail_user']) && isset($_POST['password_user'])) {

        $mail_user = $_POST['mail_user'];
        $password_user = $_POST['password_user'];

        $_SESSION['mail_user'] = $mail_user;

        // Préparer la requête pour vérifier si l'utilisateur existe
        $stmt = $dbh->prepare("SELECT password_user FROM tbl_user WHERE mail_user = :mail_user");
        $stmt->bindParam(':mail_user', $mail_user);
        $stmt->execute();

        // Vérifier s'il y a un résultat
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Vérifier le mot de passe
            if (password_verify($password_user, $row['password_user'])) {
                // Mot de passe correct
                print(1); // Le compte existe
                echo "Connexion réussie.";
                exit();
            } else {
                // Mot de passe incorrect
                echo "Nom d'utilisateur ou mot de passe incorrect.";
                print(2);
            }
        } else {
            // Compte non trouvé
            echo "Nom d'utilisateur ou mot de passe incorrect.";
            print(2);
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    print(3);
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

    <title>TC Bois Connexion</title>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue !</h1>
                                    </div>
                                    <form class="user" method="POST" >
                                        <div class="form-group">
                                            <input type="mail_user" class="form-control form-control-user" name="mail_user"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password_user" class="form-control form-control-user"
                                                name="password_user" placeholder="Enter mot de passe">
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" action="index.php">
                                            Connexion
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Mot de passe oublié?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Créer un compte !</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
