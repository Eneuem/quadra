<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

// Assurez-vous que l'utilisateur est connecté et que l'ID utilisateur est disponible
if (!isset($_SESSION['userid'])) {
    die("Utilisateur non connecté.");
}
try {
$userId = $_SESSION['userid']; // Récupérez l'ID utilisateur de la session
$note = $_POST["note"]; // Récupérez la note du formulaire
$movieId = $_POST["movie_id"]; // Récupérez l'ID du film du formulaire

$checkSql = "SELECT * FROM notes WHERE userid = :userid AND movie_id = :movieid";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->bindParam(':userid', $userId);
$checkStmt->bindParam(':movieid', $movieId);
$checkStmt->execute();

if ($checkStmt->rowCount() > 0) {
    echo "Vous avez déjà voté pour ce film.";
    exit;
}

$currentRating = null;
if (isset($movieId)) {
    $ratingSql = "SELECT notes_value FROM notes WHERE userid = :userid AND movie_id = :movieid";
    $ratingStmt = $pdo->prepare($ratingSql);
    $ratingStmt->bindParam(':userid', $userId);
    $ratingStmt->bindParam(':movieid', $movieId);
    $ratingStmt->execute();
    $ratingResult = $ratingStmt->fetch(PDO::FETCH_ASSOC);
    $currentRating = $ratingResult ? $ratingResult['notes_value'] : null;
}


// Préparez la requête d'insertion avec l'ID utilisateur
$sql = "INSERT INTO notes (notes_value, userid, movie_id) VALUES (:note, :userid, :movieid)";

// Préparez et exécutez la requête
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':note', $note);
$stmt->bindParam(':userid', $userId);
$stmt->bindParam(':movieid', $movieId);


try {
    $stmt->execute();
    echo "La note a été enregistrée avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de l'enregistrement de la note : " . $e->getMessage();
    echo "Erreur SQL : " . $sql;
    print_r($stmt->errorInfo());
}
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

