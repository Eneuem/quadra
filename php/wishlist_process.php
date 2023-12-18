<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

// Assurez-vous que l'utilisateur est connecté et que l'ID utilisateur est disponible
if (!isset($_SESSION['userid'])) {
    $_SESSION['error_message'] = "Utilisateur non connecté.";
    header("Location: ../index.php");
    exit;
}

$userId = $_SESSION['userid']; // Récupérez l'ID utilisateur de la session

// Vérifiez si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieId = $_POST['movie_id']; // Récupérez l'ID du film du formulaire

    // Vérifiez si le film est déjà dans la wishlist
    $checkSql = "SELECT * FROM wishlist WHERE userid = :userid AND movie_id = :movieid";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindParam(':userid', $userId);
    $checkStmt->bindParam(':movieid', $movieId);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        $_SESSION['error_message'] = "Ce film est déjà dans votre wishlist.";
        header("Location: ../index.php?page=wishlist");
        exit;
    }

    try {
        // Préparez la requête d'insertion avec l'ID utilisateur
        $sql = "INSERT INTO wishlist (movie_id, userid) VALUES (:movie_id, :userid)";

        // Préparez et exécutez la requête
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);

        $stmt->execute();

        $_SESSION['success_message'] = "Film ajouté à la wishlist avec succès.";
        header("Location: ../index.php?page=wishlist");
        exit;
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de l'ajout du film à la wishlist : " . $e->getMessage();
        header("Location: ../index.php?page=wishlist");
    }
} else {
    $_SESSION['error_message'] = "Requête invalide.";
    header("Location: ../index.php");
}
?>

