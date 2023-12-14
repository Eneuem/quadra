<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

$imdbId = $_GET['id'] ?? ''; // Récupération de l'ID IMDb depuis l'URL

try {
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE imdb_id = :imdb_id");
    $stmt->bindParam(':imdb_id', $imdbId);
    $stmt->execute();

    $movieDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$movieDetails) {
        echo "Film non trouvé.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des détails du film : " . $e->getMessage();
    exit;
}

// Conversion des données JSON en tableaux PHP
$movieGenres = json_decode(stripslashes(trim($movieDetails['genres'], '"')), true);
$movieActors = json_decode(stripslashes(trim($movieDetails['actors'], '"')), true);
$movieProducers = json_decode(stripslashes(trim($movieDetails['producers'], '"')), true);
$movieDirectors = json_decode(stripslashes(trim($movieDetails['directors'], '"')), true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movieDetails['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <form action="" method="post" class="bg-white rounded shadow-lg p-4 flex flex-col lg:flex-row">

        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movieDetails['id']); ?>">
        <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($imdbId); ?>">

        <div class="bg-white rounded shadow-lg p-4 flex flex-col lg:flex-row">
            <img src="<?php echo htmlspecialchars($movieDetails['poster_url']); ?>" alt="Affiche" class="w-96 ml-4 rounded object-contain">
        </div>
      

        <div class="flex flex-col pl-4">
            <label for="title" class="font-bold text-5xl mb-4">Titre du Film :</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movieDetails['title']); ?>" class="w-full px-3 py-2 border rounded-lg" required>

            <!-- Informations détaillées -->
            <div>
                <label for="release_date"><b>Date :</b></label>
                <input type="date" id="release_date" name="release_date" value="<?php echo date('Y-m-d', strtotime($movieDetails['release_date'])); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div>
                <label for="vote_average"><b>Note :</b></label>
                <input type="number" id="vote_average" name="vote_average" step="0.1" value="<?php echo htmlspecialchars($movieDetails['vote_average']); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div>
                <label for="runtime"><b>Durée (minutes) :</b></label>
                <input type="number" id="runtime" name="runtime" value="<?php echo htmlspecialchars($movieDetails['runtime']); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div>
                <label for="genres"><b>Genres (séparés par des virgules) :</b></label>
                <input type="text" id="genres" name="genres" value="<?php echo implode(', ', array_column($movieGenres, 'name')); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <!-- Acteurs -->
            <div>
                <label for="actors"><b>Acteurs (séparés par des virgules) :</b></label>
                <input type="text" id="actors" name="actors" value="<?php echo implode(', ', array_column($movieActors, 'name')); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <!-- Producteurs -->
            <div>
                <label for="producers"><b>Producteurs (séparés par des virgules) :</b></label>
                <input type="text" id="producers" name="producers" value="<?php echo implode(', ', $movieProducers); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <!-- Directeurs -->
            <div>
                <label for="directors"><b>Directeurs (séparés par des virgules) :</b></label>
                <input type="text" id="directors" name="directors" value="<?php echo implode(', ', $movieDirectors); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div>
                <label for="synopsis"><b>Synopsis :</b></label>
                <textarea id="synopsis" name="synopsis" class="w-full px-3 py-2 border rounded-lg" required><?php echo htmlspecialchars($movieDetails['synopsis']); ?></textarea>
            </div>
            <div class="w-96 ml-4 rounded">
            <label for="poster_url" class="block mb-2">URL de l'Affiche :</label>
            <input type="url" id="poster_url" name="poster_url" value="<?php echo htmlspecialchars($movieDetails['poster_url']); ?>" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="text-center mt-4">
                <input type="submit" value="Mettre à jour les détails du film" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-pointer">
            </div>
        
    </form>
    <div>                   
        <form method="post">
            <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($movie['imdb_id']); ?>">
                <button type="submit" name="delete_from_database" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Effacer</button>
        </form>
    </div>
</div>
</div>
</body>
</html>
