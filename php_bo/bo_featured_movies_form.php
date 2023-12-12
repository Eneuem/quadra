<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT id, title FROM movies ORDER BY title");
    $movies = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des films : " . $e->getMessage();
    exit;
}

try {
    $featuredMoviesStmt = $pdo->query("SELECT m.id, m.title, fv.position FROM movies m JOIN films_vedette fv ON m.id = fv.movie_id ORDER BY fv.position ASC");
    $featuredMovies = $featuredMoviesStmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des films en vedette : " . $e->getMessage();
    exit;
}

$featuredMovieIds = array_column($featuredMovies, 'id');

?>

<form action="add_featured_movie.php" method="post">
    <label for="movie_id">Choisir un Film :</label>
    <select id="movie_id" name="movie_id" required>
        <?php foreach ($movies as $movie): ?>
            <?php if (!in_array($movie['id'], $featuredMovieIds)): ?>
                <option value="<?php echo htmlspecialchars($movie['id']); ?>">
                    <?php echo htmlspecialchars($movie['title']); ?>
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <label for="position">Position :</label>
    <input type="number" id="position" name="position" required>

    <input type="submit" value="Ajouter en Vedette">
</form>


<h2>Films actuellement en vedette</h2>
<ul>
    <?php foreach ($featuredMovies as $movie): ?>
        <li>
            <?php echo htmlspecialchars($movie['title']); ?>
            - Position: <?php echo htmlspecialchars($movie['position']); ?>
        </li>
    <?php endforeach; ?>
</ul>
