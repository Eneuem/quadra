<?php
session_start();

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieId = $_POST['movie_id'];

    session_start();
    if (isset($_SESSION['userid'])) {
        $userId = $_SESSION['userid'];

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO wishlist (movie_id, userid) VALUES (:movie_id, :userid)");
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            $stmt->execute();

            echo "Film ajouté à la wishlist avec succès.";
        } catch(PDOException $e) {
            die("Erreur: " . $e->getMessage());
        }
    } else {
        echo "Utilisateur non identifié.";
    }
} else {
    echo "Requête invalide.";
}
?>
