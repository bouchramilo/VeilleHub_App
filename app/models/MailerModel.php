<?php
namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php'; // Charger PHPMailer

class MailerModel {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Configuration SMTP
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com'; // Serveur SMTP
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'miloudybouchra01@gmail.com'; // Remplacez par votre email
            $this->mail->Password   = 'vcws eczi okzj nrxu'; // Mot de passe d’application
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;

            // Expéditeur par défaut
            $this->mail->setFrom('miloudybouchra01@gmail.com', 'VeilleHub');
        } catch (Exception $e) {
            error_log("Erreur PHPMailer: " . $e->getMessage());
        }
    }

    public function envoyerEmail($email, $prenom, $nom, $sujet, $body) {
        try {
            // Destinataire
            $this->mail->addAddress($email, "$prenom $nom");

            // Contenu de l'email
            $this->mail->isHTML(true);
            $this->mail->Subject = $sujet;
            $this->mail->Body    = $body;

            // Envoyer l'email
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Erreur lors de l'envoi de l'email : {$this->mail->ErrorInfo}";
        }
    }
}
?>
