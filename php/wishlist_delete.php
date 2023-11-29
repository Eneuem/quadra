
        <?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieId = $_POST['movie_id'];

    try {
        $pdo = new PDO($dsn, $user, $password); // Assurez-vous que $dsn, $user, et $password sont définis dans db_connect.php
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE movie_id = :movie_id");
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Film supprimé de la wishlist avec succès.";

    } catch(PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
} else {
    echo "Requête invalide.";
}
?>