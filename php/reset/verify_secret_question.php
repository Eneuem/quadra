<?php
session_start();

if (isset($_POST['verify_answer'])) {
    $secret_answer = $_POST['secret_answer'];

    require '../db_connect.php';

    // Vérifiez si la réponse à la question secrète est correcte
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND secret_answer = ?");
    $stmt->execute([$_SESSION['user_id'], $secret_answer]);
    $user = $stmt->fetch();

    if ($user) {
        // Si la réponse est correcte, redirigez vers la page de réinitialisation du mot de passe
        header("Location: ../../index.php?page=reset_password");
        exit();
    } else {
        echo "Réponse incorrecte à la question secrète.";
    }
}
?>
