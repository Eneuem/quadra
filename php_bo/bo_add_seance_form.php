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

<form action="add_seance.php" method="post">
    <label for="movie_id">Choisir un Film :</label>
    <select id="movie_id" name="movie_id" required>
        <?php foreach ($movies as $movie): ?>
            <option value="<?php echo htmlspecialchars($movie['id']); ?>">
                <?php echo htmlspecialchars($movie['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="jour_de_seance">Jour de la Séance :</label>
    <select id="jour_de_seance" name="jour_de_seance" required>
        <option value="Monday">Lundi</option>
        <option value="Tuesday">Mardi</option>
        <option value="Wednesday">Mercredi</option>
        <option value="Thursday">Jeudi</option>
        <option value="Friday">Vendredi</option>
        <option value="Saturday">Samedi</option>
        <option value="Sunday">Dimanche</option>
    </select>

    <label for="heure_de_seance">Heure de la Séance :</label>
    <input type="time" id="heure_de_seance" name="heure_de_seance" required>

    <label for="langue">Langue :</label>
    <input type="text" id="langue" name="langue" required>

    <label>
        <input type="checkbox" name="is_non_recurrent">
        Séance non récurrente
    </label>

    <label for="date_precise">Date Précise (si non récurrente) :</label>
    <input type="date" id="date_precise" name="date_precise">

    <label for="prix_normal">Prix Normal :</label>
    <input type="number" id="prix_normal" name="prix_normal" step="0.01" required>

    <label for="prix_reduit">Prix Réduit :</label>
    <input type="number" id="prix_reduit" name="prix_reduit" step="0.01" required>

    <label for="nom_salle">Nom de la Salle :</label>
    <input type="text" id="nom_salle" name="nom_salle" required>

    <label for="nombre_places_disponibles">Nombre de Places Disponibles :</label>
    <input type="number" id="nombre_places_disponibles" name="nombre_places_disponibles" required>

    <input type="submit" value="Ajouter la Séance">
</form>
