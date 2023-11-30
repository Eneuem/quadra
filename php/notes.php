<?php
session_start();
include 'dbconnect.php';

// Assurez-vous que l'utilisateur est connecté et que l'ID utilisateur est disponible
if (!isset($_SESSION['userid'])) {
    die("Utilisateur non connecté.");
}

$userId = $_SESSION['userid']; // Récupérez l'ID utilisateur de la session
$note = $_POST["note"]; // Récupérez la note du formulaire
var_dump($note);  // Déboguez

// Préparez la requête d'insertion avec l'ID utilisateur
$sql = "INSERT INTO notes (notes_value, userid) VALUES (:note, :userid)";

// Préparez et exécutez la requête
$stmt = $conn->prepare($sql);
$stmt->bindParam(':note', $note);
$stmt->bindParam(':userid', $userId); // Associez l'ID utilisateur

try {
    $stmt->execute();
    echo "La note a été enregistrée avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de l'enregistrement de la note : " . $e->getMessage();
    echo "Erreur SQL : " . $sql;
    print_r($stmt->errorInfo());
}
?>

