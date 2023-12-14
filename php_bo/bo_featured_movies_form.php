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
<!-- Ajouter un film en vedette -->
<form action="add_featured_movie.php" method="post" class="p-4 w-full mx-auto bg-white rounded-lg shadow-md mt-4">
    <div class="mb-4">
        <label for="movie_id" class="block mb-2">Choisir un Film :</label>
        <select id="movie_id" name="movie_id" required class="w-full px-3 py-2 border rounded-lg">
            <?php foreach ($movies as $movie): ?>
                <?php if (!in_array($movie['id'], $featuredMovieIds)): ?>
                    <option value="<?php echo htmlspecialchars($movie['id']); ?>">
                        <?php echo htmlspecialchars($movie['title']); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-4">
        <label for="position" class="block mb-2">Position :</label>
        <select id="position" name="position" required class="w-full px-3 py-2 border rounded-lg">
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <?php if (!in_array($i, array_column($featuredMovies, 'position'))): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endif; ?>
            <?php endfor; ?>
        </select>
    </div>

    <div class="text-center">
        <input type="submit" value="Ajouter en Vedette" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-pointer">
    </div>
</form>
<!-- Liste des films en vedette --> 
<div class="flex justify-center w-full">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Titre du Film</th>
                <th class="px-4 py-2">Position</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($featuredMovies as $movie): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($movie['title']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($movie['position']); ?></td>
                    <td class="border px-4 py-2">
                        <form action="delete_featured_movie.php" method="post">
                            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id']); ?>">
                            <input type="submit" value="Supprimer" class="px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 cursor-pointer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film de la liste des vedettes ?');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



