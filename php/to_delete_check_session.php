<?php session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['userid'])) {
    echo 'ID de l\'utilisateur : ' . $_SESSION['userid'] . '<br>';
    echo 'Nom d\'utilisateur : ' . $_SESSION['username'];
    echo 'User power : ' . $_SESSION['user_power'];
} else {
    echo 'Aucune information d\'utilisateur stockée dans la session.';
}
?>