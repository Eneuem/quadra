<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieId = $_POST['movie_id'];
    $userId = $_POST['user_id']; // Assurez-vous que cette variable est passée correctement

    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Incluez user_id dans votre requête SQL
        $stmt = $pdo->prepare("INSERT INTO wishlist (movie_id, user_id) VALUES (:movie_id, :user_id)");
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Film ajouté à la wishlist avec succès.";
    } catch(PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
} else {
    echo "Requête invalide.";
}
?>

