<?php
session_start();

if (isset($_POST['reset_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    require '../db_connect.php';

    // Mettez à jour le mot de passe dans la base de données
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $result = $stmt->execute([$new_password, $_SESSION['user_id']]);

    if ($result) {
        echo "Votre mot de passe a été réinitialisé avec succès.";
        // Vous pouvez détruire la session ou rediriger l'utilisateur vers la page de connexion
        session_destroy();
        header("Location: ../../index.php?page=login");
    } else {
        echo "Erreur lors de la réinitialisation du mot de passe.";
    }
}
?>
