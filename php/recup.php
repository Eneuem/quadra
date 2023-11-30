<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de mot de passe</title>
</head>
<body>

<h2>Récupération de mot de passe</h2>

<form action="" method="post">
    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Envoyer les instructions de réinitialisation</button>
</form>

</body>
</html>


<?php
include 'db_connect.php';

if (isset($_POST['email'])) {
    // Générer un jeton unique
    $resetToken = bin2hex(random_bytes(32));

    // Mise à jour de la base de données avec le jeton et l'expiration
    $sql = "UPDATE formulaire SET reset_token = :reset_token, token_expiration = NOW() + INTERVAL 1 HOUR WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute([':reset_token' => $resetToken, ':email' => $_POST['email']]);

    // Message pour l'e-mail
    $message = "Bonjour, cliquez sur le lien pour réinitialiser votre mot de passe : http://localhost/php/recup.php?token=$resetToken";

    // En-têtes pour l'e-mail
    $headers = 'Content-Type: text/plain; charset="utf-8"';

    // Envoi de l'e-mail
    if (mail($_POST['email'], 'Réinitialisation de mot de passe', $message, $headers)) {
        echo "Mail envoyé avec succès";
    } else {
        echo "Erreur lors de l'envoi de l'e-mail";
    }
}
?>