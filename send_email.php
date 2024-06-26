<?php
session_start(); // Démarrer une session
require 'vendor/autoload.php'; // Assurez-vous que le chemin est correct

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name']);
  $phone = htmlspecialchars($_POST['phone']);
  $service = htmlspecialchars($_POST['service']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  $mail = new PHPMailer(true);

  try {
    // Configuration du serveur SMTP de Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USERNAME']; // Utilisation de la variable d'environnement
    $mail->Password = $_ENV['MAIL_PASSWORD']; // Utilisation de la variable d'environnement
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Expéditeur et destinataire
    $mail->setFrom($_ENV['MAIL_USERNAME'], $name);
    $mail->addAddress($_ENV['SEND_MAIL']); // Remplacez par l'adresse où vous voulez recevoir les emails

    // Contenu de l'email
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau contact demande';
    $mail->Body = "Nom: $name<br>Téléphone: $phone<br>Service: $service<br>Email: $email<br>Message: $message";

    // Envoyer l'email
    $mail->send();
    $_SESSION['mail_status'] = 'Email envoyé avec succès.';
  } catch (Exception $e) {
    $_SESSION['mail_status'] = "Erreur lors de l'envoi de l'email: {$mail->ErrorInfo}";
  }

  header('Location: /index.php');
  exit();
}
?>
