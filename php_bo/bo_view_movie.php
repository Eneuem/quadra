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

if (isset($_POST['delete_from_database'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM movies WHERE imdb_id = :imdb_id");
        $stmt->bindParam(':imdb_id', $movieId);
        $stmt->execute();

        echo "Film supprimé avec succès de la base de données.";
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du film : " . $e->getMessage();
    }
}
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
        <div class="bg-white rounded shadow-lg p-4 flex flex-col lg:flex-row">
            <img src="<?php echo htmlspecialchars($movieDetails['poster_url']); ?>" alt="Affiche" class="w-96 ml-4 rounded object-contain">

            <div class="flex flex-col pl-4">
                <h1 class="font-bold text-5xl mb-4"><?php echo htmlspecialchars($movieDetails['title']); ?></h1>

                <!-- Informations détaillées -->
                <div>
                    <h5><b>Date:</b> <?php echo date('d/m/Y', strtotime($movieDetails['release_date'])); ?></h5>
                    <h5><b>Note:</b> <?php echo number_format($movieDetails['vote_average'], 1); ?>/10</h5>
                    <h5><b>Durée:</b> <?php echo htmlspecialchars($movieDetails['runtime']); ?> minutes</h5>
                    <h5><b>Genres:</b> <?php echo implode(', ', array_column($movieGenres, 'name')); ?></h5>
                </div>

                <!-- Acteurs -->
                <div>
                    <h5><b>Acteurs:</b></h5>
                    <ul>
                        <?php foreach ($movieActors as $actor): ?>
                            <li><?php echo htmlspecialchars($actor['name']); ?> (as <?php echo htmlspecialchars($actor['character']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Producteurs -->
                
                <div>
                    <h5><b>Producteurs:</b></h5>
                    <ul>
                        <?php foreach ($movieProducers as $producer): ?>
                            <li><?php echo htmlspecialchars($producer); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <!-- Directeurs -->
                <div>
                    <h5><b>Directeurs:</b></h5>
                    <ul>
                        <?php foreach ($movieDirectors as $director): ?>
                            <li><?php echo htmlspecialchars($director); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <p class="mt-4 text-xl leading-relaxed"><b>Synopsis:</b> <?php echo htmlspecialchars($movieDetails['synopsis']); ?></p>
            </div>
        </div>
    </div>

    <div>
    <form action="update_movie.php" method="post">
    <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($imdbId); ?>">

    <label for="title">Titre :</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movieDetails['title']); ?>">

    <label for="release_date">Date de sortie :</label>
    <input type="date" id="release_date" name="release_date" value="<?php echo htmlspecialchars($movieDetails['release_date']); ?>">

    <!-- Ajoutez d'autres champs ici selon les données que vous voulez permettre de modifier -->

    <input type="submit" value="Mettre à jour">
    </form>

    </div>

                        <form method="post">
                        <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($movie['imdb_id']); ?>">
                            <button type="submit" name="delete_from_database" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Effacer</button>
                        </form>
</body>
</html>
