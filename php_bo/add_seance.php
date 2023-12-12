<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];
    $jourDeSeance = $_POST['jour_de_seance'];
    $heureDeSeance = $_POST['heure_de_seance'];
    $langue = $_POST['langue'];
    $isNonRecurrent = isset($_POST['is_non_recurrent']) ? 1 : 0;
    $datePrecise = $_POST['date_precise'] ?: NULL;

    try {
        $stmt = $pdo->prepare("INSERT INTO seances (movie_id, jour_de_seance, heure_de_seance, langue, is_non_recurrent, date_precise) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$movieId, $jourDeSeance, $heureDeSeance, $langue, $isNonRecurrent, $datePrecise]);

        echo "Séance ajoutée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de la séance : " . $e->getMessage();
    }
}
?>
