<?php
session_start();

include 'db_connect.php';

$userId = $_SESSION['userid'];

$sql = "DELETE FROM users WHERE id = :userid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userId);

if ($stmt->execute()) {
    session_destroy();
    header("Location: login.php"); // Rediriger vers la page de connexion
} else {
    echo "Erreur lors de la suppression du compte.";
}
