<?php
session_start();

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Variable d'environnement
$servername = $_ENV['BD_HOST'];
$username = $_ENV['BD_USER'];
$password = $_ENV['BD_PASS'];
$dbname = $_ENV['BD_NAME'];


$connection = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) 
{
  echo 'Connexion echouer'. mysqli_connect_error();
}
else
'Connexion reussie';

// Connexion à la base de données
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $_SESSION['email'] = $email;

        // Vérifier si le compte existe
        $stmt = $dbh->prepare("SELECT * FROM tbl_user WHERE mail_u = :email AND password_u = PASSWORD(CONCAT('*-6', :password))");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            print(1); // Le compte existe
            echo "Connexion réussie.";
            header('location: /acceuil.php');
        } else {
            // Le compte n'existe pas ou les identifiants sont incorrects
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    
<!-- Outer Row -->
<div class="row justify-content-center">

<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
                    <div>
                        <div>
                            <h1>Bienvenue !</h1>
                        </div>

                        <form class="user" method="POST" action="index.php">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email"
                                    aria-describedby="emailHelp" placeholder="Enter Email Address">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    name="password" placeholder="Enter mot de passe">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
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

</body>
</html>