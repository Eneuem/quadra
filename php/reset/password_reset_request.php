<?php
if (isset($_POST['request_reset'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Connectez-vous à la base de données
    require '../db_connect.php';

    // Recherchez l'utilisateur par son nom d'utilisateur et son email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Si l'utilisateur est trouvé, stockez la question secrète dans la session et redirigez vers la page de vérification de la question secrète
        session_start();
        $_SESSION['user_id'] = $user['id']; // Stockez l'ID de l'utilisateur pour une utilisation future
        $_SESSION['secret_question'] = $user['secret_question'];
        header("Location: ../../index.php?page=verify");
        exit();
    } else {
        echo "Aucun utilisateur trouvé avec ces informations.";
    }
}
?>
