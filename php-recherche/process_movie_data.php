<?php
session_start();

// Supposons que $userId est défini après une authentification réussie
// $_SESSION['user_id'] = $userId;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'api_connect.php';

function getTrendingMovies($timeWindow = 'week')
{
    $url = "https://api.themoviedb.org/3/trending/movie/$timeWindow";
    return makeApiRequest($url);
}

function getMovieDetails($movieId)
{
    $detailsUrl = "https://api.themoviedb.org/3/movie/$movieId";
    return makeApiRequest($detailsUrl);
}

function getMovieCredits($movieId)
{
    $creditsUrl = "https://api.themoviedb.org/3/movie/$movieId/credits";
    return makeApiRequest($creditsUrl);
}


function getMovieVideos($movieId)
{
    $videosUrl = "https://api.themoviedb.org/3/movie/$movieId/videos";
    return makeApiRequest($videosUrl);
}

function checkIfMovieExists($imdbId, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM movies WHERE imdb_id = :imdb_id");
        $stmt->bindParam(':imdb_id', $imdbId);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        // Gérer l'erreur ici
        error_log("Erreur lors de la vérification de l'existence du film : " . $e->getMessage());
        return false;
    }
}


// foreach ($movieVideos['results'] as $video) {
//     if ($video['type'] == 'Trailer' && $video['site'] == 'YouTube') {
//         $trailerUrl = 'https://www.youtube.com/watch?v=' . $video['key'];
//         break;
//     }
// }

// 1. Récupérer l'ID du film depuis la requête GET
if (isset($_GET['id'])) {
    $movieId = $_GET['id'];
} else {
    // Gérez le cas où l'ID du film n'est pas fourni
    echo "Movie ID not provided.";
    exit;
}

// 2. Utiliser les fonctions pour obtenir les détails du film
$movieDetails = getMovieDetails($movieId);
$movieCredits = getMovieCredits($movieId);
$movieVideos = getMovieVideos($movieId);


// Recuperation de donée du film ID 
$movieTitle = htmlspecialchars($movieDetails['title']);
$movieReleaseDate = date('Y-m-d', strtotime($movieDetails['release_date']));
$movieVoteAverage = $movieDetails['vote_average'];
$movieRuntime = $movieDetails['runtime'];
$movieGenres = array_map(function($genre) {
    return $genre['name'];
}, $movieDetails['genres']);
$movieSynopsis = htmlspecialchars($movieDetails['overview']);
$movieActors = array_map(function($cast) {
    return [
        'name' => htmlspecialchars($cast['name']),
        'character' => htmlspecialchars($cast['character'])
    ];
}, array_slice($movieCredits['cast'], 0, 5)); 
$movieProducers = array_map('htmlspecialchars', array_column(array_filter($movieCredits['crew'], function($crew) {
    return $crew['job'] == 'Producer';
}), 'name'));
$movieDirectors = array_map('htmlspecialchars', array_column(array_filter($movieCredits['crew'], function($crew) {
    return $crew['job'] == 'Director';
}), 'name'));
$movieTrailerKey = !empty($movieVideos['results']) ? $movieVideos['results'][0]['key'] : null;
$moviePosterUrl = "https://image.tmdb.org/t/p/w500" . $movieDetails['poster_path'];
$movieScreenshotUrls = [];

// Supposons que l'API renvoie des captures d'écran sous forme de tableau dans $movieDetails['screenshots']
if (isset($movieDetails['screenshots'])) {
    foreach ($movieDetails['screenshots'] as $screenshot) {
        $movieScreenshotUrls[] = "https://image.tmdb.org/t/p/w500" . $screenshot['file_path'];
    }
}

include("dbconnect.php");

if (isset($_POST['add_to_database'])) {


    $movieTitle = htmlspecialchars($movieDetails['title']);
    $movieReleaseDate = date('Y-m-d', strtotime($movieDetails['release_date']));
    $movieVoteAverage = $movieDetails['vote_average'];
    $movieRuntime = $movieDetails['runtime'];
    $movieGenres = json_encode($movieDetails['genres']);
    $movieSynopsis = htmlspecialchars($movieDetails['overview']);
    $movieActors = json_encode(array_slice($movieCredits['cast'], 0, 5)); 
    $movieProducers = json_encode(array_column(array_filter($movieCredits['crew'], function($crew) {
        return $crew['job'] == 'Producer';
    }), 'name'));
    $movieDirectors = json_encode(array_column(array_filter($movieCredits['crew'], function($crew) {
        return $crew['job'] == 'Director';
    }), 'name'));
    $movieTrailerKey = !empty($movieVideos['results']) ? $movieVideos['results'][0]['key'] : null;
    $moviePosterUrl = "https://image.tmdb.org/t/p/w500" . $movieDetails['poster_path'];
    $movieId = $movieDetails['id'];
    $movieScreenshotUrl = "https://image.tmdb.org/t/p/w500" . $movieDetails['backdrop_path'];


$stmt = $pdo->prepare("INSERT INTO movies (title, imdb_id, release_date, vote_average, runtime, genres, synopsis, actors, producers, directors, trailer_key, poster_url, screenshot_urls) VALUES (:title, :imdb_id, :release_date, :vote_average, :runtime, :genres, :synopsis, :actors, :producers, :directors, :trailer_key, :poster_url, :screenshot_urls)");

// Liaison des variables, y compris les URL de l'affiche et des captures d'écran
    $stmt->bindValue(':title', $movieTitle);
    $stmt->bindParam(':imdb_id', $movieId);
    $stmt->bindValue(':release_date', $movieReleaseDate);
    $stmt->bindValue(':vote_average', $movieVoteAverage);
    $stmt->bindValue(':runtime', $movieRuntime);
    $stmt->bindValue(':genres', json_encode($movieGenres));
    $stmt->bindValue(':synopsis', $movieSynopsis);
    $stmt->bindValue(':actors', json_encode($movieActors));
    $stmt->bindValue(':producers', json_encode($movieProducers));
    $stmt->bindValue(':directors', json_encode($movieDirectors));
    $stmt->bindValue(':trailer_key', $movieTrailerKey);
    $stmt->bindValue(':poster_url', $moviePosterUrl);
    $stmt->bindValue(':screenshot_urls', $movieScreenshotUrl);

    
    // Exécution de la requête
    try {
        $stmt->execute();
        echo "Film ajouté avec succès à la base de données.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout du film : " . $e->getMessage();
    }
}

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

$movieId = $movieDetails['id'];
$isInDatabase = checkIfMovieExists($movieId, $pdo);
    
?>