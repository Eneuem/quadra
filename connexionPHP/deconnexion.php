<?php

session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Si vous utilisez des cookies de session, détruisez-les également
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil ou toute autre page après la déconnexion
header("Location: index.php");
exit();
?>
