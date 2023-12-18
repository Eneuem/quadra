<?php
include 'db_connect.php'; // Votre script de connexion à la base de données
include 'bo_check.php'; // Votre script de vérification de l'authentification

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];
    $position = $_POST['position'];

    try {
        $stmt = $pdo->prepare("INSERT INTO films_new (movie_id, position) VALUES (?, ?)");
        $stmt->execute([$movieId, $position]);

        echo "Film ajouté avec succès en vedette.";
        header('Location: main.php?page=sortie');
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout du film en vedette : " . $e->getMessage();
    }
}
?>
