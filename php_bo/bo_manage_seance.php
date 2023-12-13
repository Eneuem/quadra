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
    <select id="filter_movie" name="filter_movie">
        <option value="">Tous les films</option>
        <?php foreach ($movies as $movie): ?>
            <option value="<?php echo htmlspecialchars($movie['id']); ?>" <?php echo $filterMovie == $movie['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($movie['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="filter_date">Date :</label>
    <input type="date" id="filter_date" name="filter_date" value="<?php echo htmlspecialchars($filterDate); ?>">

    <input type="submit" value="Filtrer">
</form>

<!-- Affichage des séances -->

<h2>Gestion des Séances</h2>
<table>
<thead>
        <tr>
            <th>Film</th>
            <th>Jour de la Séance</th>
            <th>Heure</th>
            <th>Langue</th>
            <th>Prix Normal</th>
            <th>Prix Réduit</th>
            <th>Nom de la Salle</th>
            <th>Places Disponibles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($seances as $seance): ?>
            <tr>
                <td><?php echo htmlspecialchars($seance['movie_title']); ?></td>
                <td><?php echo htmlspecialchars($seance['jour_de_seance']); ?></td>
                <td><?php echo htmlspecialchars($seance['heure_de_seance']); ?></td>
                <td><?php echo htmlspecialchars($seance['langue']); ?></td>
                <td><?php echo htmlspecialchars($seance['prix_normal']); ?></td>
                <td><?php echo htmlspecialchars($seance['prix_reduit']); ?></td>
                <td><?php echo htmlspecialchars($seance['nom_salle']); ?></td>
                <td><?php echo htmlspecialchars($seance['nombre_places_disponibles']); ?></td>
                <td>
                    <a href="main.php?page=editseance&id=<?php echo $seance['id']; ?>">Modifier</a>
                    <a href="delete_seance.php?id=<?php echo $seance['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>