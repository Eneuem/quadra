<?php
include 'db_connect.php';

$seanceId = $_GET['id'] ?? null;
$seance = null;

if ($seanceId) {
    $stmt = $pdo->prepare("SELECT * FROM seances WHERE id = ?");
    $stmt->execute([$seanceId]);
    $seance = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $jourDeSeance = $_POST['jour_de_seance'];
    $heureDeSeance = $_POST['heure_de_seance'];
    $langue = $_POST['langue'];
    $isNonRecurrent = isset($_POST['is_non_recurrent']) ? 1 : 0;
    $datePrecise = $_POST['date_precise'] ?: null;

    // Mettre à jour la séance dans la base de données
    $updateStmt = $pdo->prepare("UPDATE seances SET jour_de_seance = ?, heure_de_seance = ?, langue = ?, is_non_recurrent = ?, date_precise = ? WHERE id = ?");
    $updateStmt->execute([$jourDeSeance, $heureDeSeance, $langue, $isNonRecurrent, $datePrecise, $seanceId]);

    header("Location: main.php?page=listseance");
    exit;
}

// Formulaire de modification avec les données de la séance
?>

<form action="edit_seance.php?id=<?php echo $seanceId; ?>" method="post">
    <label for="movie_id">Film :</label>
    <!-- <select id="movie_id" name="movie_id" required>

    </select> -->

    <label for="jour_de_seance">Jour de la Séance :</label>
    <input type="text" id="jour_de_seance" name="jour_de_seance" value="<?php echo $seance['jour_de_seance'] ?? ''; ?>" required>

    <label for="heure_de_seance">Heure de la Séance :</label>
    <input type="time" id="heure_de_seance" name="heure_de_seance" value="<?php echo $seance['heure_de_seance'] ?? ''; ?>" required>

    <label for="langue">Langue :</label>
    <input type="text" id="langue" name="langue" value="<?php echo $seance['langue'] ?? ''; ?>" required>

    <label>
        <input type="checkbox" name="is_non_recurrent" <?php echo $seance['is_non_recurrent'] ? 'checked' : ''; ?>>
        Séance non récurrente
    </label>

    <label for="date_precise">Date Précise (si non récurrente) :</label>
    <input type="date" id="date_precise" name="date_precise" value="<?php echo $seance['date_precise'] ?? ''; ?>">

    <input type="submit" value="Modifier la Séance">
</form>


