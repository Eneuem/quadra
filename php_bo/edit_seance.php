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
    $prixNormal = $_POST['prix_normal'];
    $prixReduit = $_POST['prix_reduit'];
    $nomSalle = $_POST['nom_salle'];
    $nombrePlacesDisponibles = $_POST['nombre_places_disponibles'];

    // Mettre à jour la séance dans la base de données
    $updateStmt = $pdo->prepare("UPDATE seances SET jour_de_seance = ?, heure_de_seance = ?, langue = ?, is_non_recurrent = ?, date_precise = ?, prix_normal = ?, prix_reduit = ?, nom_salle = ?, nombre_places_disponibles = ? WHERE id = ?");
    $updateStmt->execute([$jourDeSeance, $heureDeSeance, $langue, $isNonRecurrent, $datePrecise, $prixNormal, $prixReduit, $nomSalle, $nombrePlacesDisponibles, $seanceId]);

    header("Location: main.php?page=listseance");
    exit;
}

// Formulaire de modification avec les données de la séance
?>

<form action="edit_seance.php?id=<?php echo $seanceId; ?>" method="post" class="p-4">

    <div class="mb-4">
        <label for="jour_de_seance" class="block text-gray-300 text-sm font-semibold mb-2">Jour de la Séance :</label>
        <input type="text" id="jour_de_seance" name="jour_de_seance" value="<?php echo $seance['jour_de_seance'] ?? ''; ?>" required class="text-black w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <div class="mb-4">
        <label for="heure_de_seance" class="block text-gray-300 text-sm font-semibold mb-2">Heure de la Séance :</label>
        <input type="time" id="heure_de_seance" name="heure_de_seance" value="<?php echo $seance['heure_de_seance'] ?? ''; ?>" required class="text-black w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <div class="mb-4">
        <label for="langue" class="block text-gray-300 text-sm font-semibold mb-2">Langue :</label>
        <input type="text" id="langue" name="langue" value="<?php echo $seance['langue'] ?? ''; ?>" required class="w-full px-3 py-2 border rounded-lg text-black focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <div class="mb-4">
        <label class="block text-gray-300 text-sm font-semibold">
            <input type="checkbox" name="is_non_recurrent" <?php echo $seance['is_non_recurrent'] ? 'checked' : ''; ?> class="mr-2 text-black">
            Séance non récurrente
        </label>
    </div>

    <div class="mb-4">
        <label for="date_precise" class="block text-gray-300 text-sm font-semibold mb-2">Date Précise (si non récurrente) :</label>
        <input type="date" id="date_precise" name="date_precise" value="<?php echo $seance['date_precise'] ?? ''; ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none text-black focus:ring focus:border-blue-300">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="prix_normal" class="block text-gray-300 text-sm font-semibold mb-2">Prix Normal :</label>
            <input type="number" id="prix_normal" name="prix_normal" value="<?php echo $seance['prix_normal'] ?? ''; ?>" required class="w-full px-3 py-2 border rounded-lg text-black focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="prix_reduit" class="block text-gray-300 text-sm font-semibold mb-2">Prix Réduit :</label>
            <input type="number" id="prix_reduit" name="prix_reduit" value="<?php echo $seance['prix_reduit'] ?? ''; ?>" required class="w-full px-3 py-2 border rounded-lg text-black focus:outline-none focus:ring focus:border-blue-300">
        </div>
    </div>

    <div class="mb-4">
        <label for="nom_salle" class="block text-gray-300 text-sm font-semibold mb-2">Nom de la Salle :</label>
        <input type="text" id="nom_salle" name="nom_salle" value="<?php echo $seance['nom_salle'] ?? ''; ?>" required class="w-full px-3 py-2 border rounded-lg text-black focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <div class="mb-4">
        <label for="nombre_places_disponibles" class="block text-gray-300 text-sm font-semibold mb-2">Nombre de Places Disponibles :</label>
        <input type="number" id="nombre_places_disponibles" name="nombre_places_disponibles" value="<?php echo $seance['nombre_places_disponibles'] ?? ''; ?>" required class="w-full px-3 text-black py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <div class="flex items-center justify-between">
        <input type="submit" value="Modifier la Séance" class="bg-blue-500 hover:bg-blue-700 cursor-pointer text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring focus:border-blue-300">
    </div>
</form>