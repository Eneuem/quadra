<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

$filterMovie = $_GET['filter_movie'] ?? '';
$filterDate = $_GET['filter_date'] ?? '';

$query = "SELECT s.*, m.title as movie_title, s.prix_normal, s.prix_reduit, s.nom_salle, s.nombre_places_disponibles FROM seances s JOIN movies m ON s.movie_id = m.id";
$conditions = [];
$params = [];

if ($filterMovie) {
    $conditions[] = "s.movie_id = ?";
    $params[] = $filterMovie;
}

if ($filterDate) {
    $conditions[] = "s.jour_de_seance = ?";
    $params[] = $filterDate;
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $seances = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des séances : " . $e->getMessage();
    exit;
}


// Récupération des films pour le filtre
try {
    $moviesStmt = $pdo->query("SELECT id, title FROM movies ORDER BY title");
    $movies = $moviesStmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des films : " . $e->getMessage();
    exit;
}
?>

<!-- Formulaire de filtre -->
<form action="bo_manage_seances.php" method="get">
    <label for="filter_movie">Film :</label>
    <select id="filter_movie" name="filter_movie" class="text-black rounded-md p-2 mr-2">
        <option value="">Tous les films</option>
        <?php foreach ($movies as $movie) : ?>
            <option value="<?php echo htmlspecialchars($movie['id']); ?>" <?php echo $filterMovie == $movie['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($movie['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="filter_date">Date :</label>
    <input type="date" id="filter_date" name="filter_date" class="text-black rounded-md p-2" value="<?php echo htmlspecialchars($filterDate); ?>">

    <input type="submit" value="Filtrer" class="cursor-pointer hover:text-gray-50">
</form>

<!-- Affichage des séances -->

<h2 class="text-2xl font-bold mb-4">Gestion des Séances</h2>
<table class="min-w-full border border-gray-300 shadow-sm rounded-lg overflow-hidden">
    <thead class="bg-slate-950">
        <tr>
            <th class="px-4 py-2">Film</th>
            <th class="px-4 py-2">Jour de la Séance</th>
            <th class="px-4 py-2">Heure</th>
            <th class="px-4 py-2">Langue</th>
            <th class="px-4 py-2">Prix Normal</th>
            <th class="px-4 py-2">Prix Réduit</th>
            <th class="px-4 py-2">Nom de la Salle</th>
            <th class="px-4 py-2">Places Disponibles</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($seances as $seance) : ?>
            <tr class="hover:bg-slate-800 text-center">
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['movie_title']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['jour_de_seance']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['heure_de_seance']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['langue']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['prix_normal']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['prix_reduit']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['nom_salle']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($seance['nombre_places_disponibles']); ?></td>
                <td class="px-4 py-2">
                    <a href="main.php?page=editseance&id=<?php echo $seance['id']; ?>" class="text-blue-500 bg-blue-950 p-2 rounded-md hover:underline">Modifier</a>
                    <a href="delete_seance.php?id=<?php echo $seance['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?');" class="text-red-500 bg-red-950 p-2 rounded-md hover:underline ml-2">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>