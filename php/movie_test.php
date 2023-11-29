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


function getMovieVideos($movieId) {
    $videosUrl = "https://api.themoviedb.org/3/movie/$movieId/videos";
    return makeApiRequest($videosUrl);
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
        $movieVideos = getMovieVideos($randomMovie['id']);
        $trailerUrl = '';

        foreach ($movieVideos['results'] as $video) {
            if ($video['type'] == 'Trailer' && $video['site'] == 'YouTube') {
                $trailerUrl = 'https://www.youtube.com/watch?v=' . $video['key'];
                break;
            }
        }
        ?>

        <h1><?php echo htmlspecialchars($randomMovie['title']); ?></h1>
        <p>Année: <?php echo substr($movieDetails['release_date'], 0, 4); ?></p>
        <p>Durée: <?php echo $movieDetails['runtime']; ?> minutes</p>
        <p>Genres: 
            <?php foreach ($movieDetails['genres'] as $genre) {
                echo htmlspecialchars($genre['name']) . ' ';
            } ?>
        </p>
        <p>Note: <?php echo $movieDetails['vote_average']; ?>/10</p>
        <p>Résumé: <?php echo htmlspecialchars($randomMovie['overview']); ?></p>
        <img src="https://image.tmdb.org/t/p/w500<?php echo $randomMovie['poster_path']; ?>" alt="Poster">
        <?php if (!empty($movieDetails['backdrop_path'])): ?>
            <img src="https://image.tmdb.org/t/p/w500<?php echo $movieDetails['backdrop_path']; ?>" alt="Second Screenshot">
        <?php endif; ?>

        <?php if (!empty($trailerUrl)): ?>
            <h2>Trailer</h2>
            <iframe width='560' height='315' src='https://www.youtube.com/embed/<?php echo $video['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
        <?php endif; ?>


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
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid']; ?>">
            <input type="submit" value="Ajouter à la Wishlist">
        </form>

    <?php else: ?>
        <p>Aucun film tendance trouvé.</p>
    <?php endif; ?>
</body>
</html>