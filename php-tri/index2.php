<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier de connexion à la base de données
include 'dbconnect.php';

// Récupérer tous les genres depuis la base de données
$sql = "SELECT genres FROM movies";
$result = $pdo->query($sql);

// Initialiser un tableau pour stocker les genres uniques
$uniqueGenres = [];

// Parcourir chaque ligne de la table movies
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $genresJson = stripslashes(trim($row['genres'], '"'));
    $genres = json_decode($genresJson, true);
    if (is_array($genres)) {
        foreach ($genres as $genre) {
            $uniqueGenres[$genre['name']] = $genre['name'];
        }
    }
}

$uniqueGenres = array_values($uniqueGenres);

// Vérifier si un genre a été sélectionné et récupérer les films correspondants
$selectedMovies = [];
if (isset($_GET['genre']) && $_GET['genre'] != '') {
    $selectedGenre = $_GET['genre'];

    $sqlMovies = "SELECT * FROM movies WHERE genres LIKE :genre";
    $stmtMovies = $pdo->prepare($sqlMovies);
    $stmtMovies->bindValue(':genre', '%' . $selectedGenre . '%');
    $stmtMovies->execute();
    $selectedMovies = $stmtMovies->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sélection de Genre</title>
</head>
<body>
    <form action="" method="get">
        <label for="genreSelect">Choisissez un genre :</label>
        <select name="genre" id="genreSelect">
            <option value="">Tous les genres</option>
            <?php foreach ($uniqueGenres as $genre): ?>
                <option value="<?php echo htmlspecialchars($genre); ?>" <?php echo (isset($_GET['genre']) && $_GET['genre'] == $genre) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($genre); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Rechercher">
    </form>

    <?php if (!empty($selectedMovies)): ?>
        <h2>Films trouvés dans le genre "<?php echo htmlspecialchars($selectedGenre); ?>" :</h2>
        <ul>
            <?php foreach ($selectedMovies as $movie): ?>
                <li>
                    <strong><?php echo htmlspecialchars($movie['title']); ?></strong>
                    <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" style="max-height: 100px;">
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($_GET['genre']) && $_GET['genre'] != ''): ?>
        <p>Aucun film trouvé dans le genre "<?php echo htmlspecialchars($selectedGenre); ?>".</p>
    <?php endif; ?>
</body>
</html>
