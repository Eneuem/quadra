<?php
include 'db_connect.php';
include 'bo_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];
    $jourDeSeance = $_POST['jour_de_seance'];
    $heureDeSeance = $_POST['heure_de_seance'];
    $langue = $_POST['langue'];
    $isNonRecurrent = isset($_POST['is_non_recurrent']) ? 1 : 0;
    $datePrecise = $_POST['date_precise'] ?: NULL;
    $prixNormal = $_POST['prix_normal'];
    $prixReduit = $_POST['prix_reduit'];
    $nomSalle = $_POST['nom_salle'];
    $nombrePlacesDisponibles = $_POST['nombre_places_disponibles'];

    try {
        $stmt = $pdo->prepare("INSERT INTO seances (movie_id, jour_de_seance, heure_de_seance, langue, is_non_recurrent, date_precise, prix_normal, prix_reduit, nom_salle, nombre_places_disponibles) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$movieId, $jourDeSeance, $heureDeSeance, $langue, $isNonRecurrent, $datePrecise, $prixNormal, $prixReduit, $nomSalle, $nombrePlacesDisponibles]);

        echo "Séance ajoutée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de la séance : " . $e->getMessage();
    }
}
?>

