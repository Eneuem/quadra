<?php
include 'db_connect.php';
include 'bo_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM films_new WHERE movie_id = ?");
        $stmt->execute([$movieId]);

        echo "Film supprimé avec succès de la liste des vedettes.";
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du film : " . $e->getMessage();
    }
}

// Redirigez ici vers la page précédente ou la page de gestion des films
header("Location: main.php?page=featured");
exit;
?>
