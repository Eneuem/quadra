<?php 
session_start();

// Supposons que $userId est défini après une authentification réussie
$_SESSION['user_id'] = $userId; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'api_connect.php';


function getTrendingMovies($timeWindow = 'week') {
    $url = "https://api.themoviedb.org/3/trending/movie/$timeWindow";
    return makeApiRequest($url);
}

function getMovieDetails($movieId) {
    $detailsUrl = "https://api.themoviedb.org/3/movie/$movieId";
    return makeApiRequest($detailsUrl);
}

function getMovieCredits($movieId) {
    $creditsUrl = "https://api.themoviedb.org/3/movie/$movieId/credits";
    return makeApiRequest($creditsUrl);
}


// Récupérer les films tendance
$trendingMovies = getTrendingMovies();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Films Tendance</title>
</head>
<body>
    <?php if ($trendingMovies && count($trendingMovies['results']) > 0): ?>
        <?php 
        $randomIndex = array_rand($trendingMovies['results']);
        $randomMovie = $trendingMovies['results'][$randomIndex];
        $movieDetails = getMovieDetails($randomMovie['id']);
        $movieCredits = getMovieCredits($randomMovie['id']);
        ?>

        <h1><?php echo htmlspecialchars($randomMovie['title']); ?></h1>
        <p>Année: <?php echo substr($movieDetails['release_date'], 0, 4); ?></p>
        <p>Note: <?php echo $movieDetails['vote_average']; ?>/10</p>
        <p>Résumé: <?php echo htmlspecialchars($randomMovie['overview']); ?></p>
        <img src="https://image.tmdb.org/t/p/w500<?php echo $randomMovie['poster_path']; ?>" alt="Poster">

        <h2>Acteurs Principaux</h2>
        <ul>
            <?php foreach ($movieCredits['cast'] as $key => $cast): ?>
                <?php if ($key < 5): ?>
                    <li><?php echo htmlspecialchars($cast['name']); ?> (en tant que <?php echo htmlspecialchars($cast['character']); ?>)</li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <h2>Réalisateur et Producteur</h2>
        <ul>
            <?php foreach ($movieCredits['crew'] as $crew): ?>
                <?php if ($crew['job'] == 'Director' || $crew['job'] == 'Producer'): ?>
                    <li><?php echo htmlspecialchars($crew['job']); ?>: <?php echo htmlspecialchars($crew['name']); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <form action="wishlist_process.php" method="post">
            <input type="hidden" name="movie_id" value="<?php echo $randomMovie['id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" value="Ajouter à la Wishlist">
        </form>
    <?php else: ?>
        <p>Aucun film tendance trouvé.</p>
    <?php endif; ?>
</body>
</html>
