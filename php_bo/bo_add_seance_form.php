<?php
include 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT id, title FROM movies ORDER BY title");
    $movies = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des films : " . $e->getMessage();
    exit;
}
?>

<form action="add_seance.php" method="post" class="p-4 max-w-md mx-auto bg-white rounded-lg shadow-md">
    <div class="mb-4">
        <label for="movie_id" class="block mb-2">Choisir un Film :</label>
        <select id="movie_id" name="movie_id" required class="w-full px-3 py-2 border rounded-lg">
            <?php foreach ($movies as $movie): ?>
                <option value="<?php echo htmlspecialchars($movie['id']); ?>">
                    <?php echo htmlspecialchars($movie['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-4">
        <label for="jour_de_seance" class="block mb-2">Jour de la Séance :</label>
        <select id="jour_de_seance" name="jour_de_seance" required class="w-full px-3 py-2 border rounded-lg">
            <option value="Monday">Lundi</option>
            <option value="Tuesday">Mardi</option>
            <option value="Wednesday">Mercredi</option>
            <option value="Thursday">Jeudi</option>
            <option value="Friday">Vendredi</option>
            <option value="Saturday">Samedi</option>
            <option value="Sunday">Dimanche</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="heure_de_seance" class="block mb-2">Heure de la Séance :</label>
        <input type="time" id="heure_de_seance" name="heure_de_seance" required class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="mb-4">
        <label for="langue" class="block mb-2">Langue :</label>
        <input type="text" id="langue" name="langue" required class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="mb-4">
        <label class="block mb-2">
            <input type="checkbox" name="is_non_recurrent" class="mr-2">
            Séance non récurrente
        </label>
    </div>

    <div class="mb-4">
        <label for="date_precise" class="block mb-2">Date Précise (si non récurrente) :</label>
        <input type="date" id="date_precise" name="date_precise" class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="mb-4">
        <label for="prix_normal" class="block mb-2">Prix Normal :</label>
        <input type="number" id="prix_normal" name="prix_normal" step="0.01" required class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="mb-4">
        <label for="prix_reduit" class="block mb-2">Prix Réduit :</label>
        <input type="number" id="prix_reduit" name="prix_reduit" step="0.01" required class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="mb-4">
        <label for="nom_salle" class="block mb-2">Nom de la Salle :</label>
        <input type="text" id="nom_salle" name="nom_salle" required class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="mb-4">
        <label for="nombre_places_disponibles" class="block mb-2">Nombre de Places Disponibles :</label>
        <input type="number" id="nombre_places_disponibles" name="nombre_places_disponibles" required class="w-full px-3 py-2 border rounded-lg">
    </div>

    <div class="text-center">
        <input type="submit" value="Ajouter la Séance" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-pointer">
    </div>
</form>
