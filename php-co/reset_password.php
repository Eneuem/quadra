<?php
include 'dbconnect.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset_request'])) {
        $userEmail = $_POST['email'];

        // Vérifier si l'e-mail existe dans la base de données
        $query = $pdo->prepare("SELECT * FROM formulaire WHERE email = ?");
        $query->execute([$userEmail]);

        if ($query->rowCount() > 0) {
            // Générer le jeton et envoyer l'e-mail de réinitialisation
            $resetToken = bin2hex(random_bytes(32));
            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $updateQuery = $pdo->prepare("UPDATE formulaire SET reset_token = ?, token_expiration = ? WHERE email = ?");
            $updateQuery->execute([$resetToken, $tokenExpiration, $userEmail]);

            $resetLink = "http://votre-site.com/reset-password.php?token=$resetToken";
            $subject = "Réinitialisation de mot de passe";
            $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : $resetLink";
            $headers = "From: webmaster@example.com";

            if (mail($userEmail, $subject, $message, $headers)) {
                echo "Un e-mail de réinitialisation a été envoyé à votre adresse.";
            } else {
                echo "Erreur lors de l'envoi de l'e-mail.";
            }
        } else {
            echo "L'adresse e-mail n'est pas associée à un compte.";
        }
    } elseif (isset($_POST['reset_password'])) {
        // Traitement de la réinitialisation du mot de passe
        // ...
    } else {
        echo "Mauvaise utilisation du formulaire.";
    }
}
?>

<!-- Formulaire de demande de réinitialisation de mot de passe -->
<form action="" method="post">
    <label for="email">Votre adresse e-mail :</label>
    <input type="email" name="email" required>
    <input type="submit" name="reset_request" value="Demander la réinitialisation du mot de passe">
</form>
