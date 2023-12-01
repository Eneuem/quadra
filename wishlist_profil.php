<?php
// session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Supposons que $userId est défini après une authentification réussie
// $_SESSION['user_id'] = $userId;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'php/api_connect.php';

function getTrendingMovies($genre = null, $timeWindow = 'week')
{
    $url = "https://api.themoviedb.org/3/trending/movie/$timeWindow";
    // Ajouter le paramètre de genre s'il est fourni
    if ($genre) {
        $url .= "&with_genres=" . $genre;
    }
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

// Récupérer les films tendance
$trendingMovies = getTrendingMovies();

// Sélectionner un film au hasard
$randomIndex = array_rand($trendingMovies['results']);
$randomMovie = $trendingMovies['results'][$randomIndex];

// Récupérer les détails du film sélectionné
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

<script src="https://cdn.tailwindcss.com" defer></script>

<div class="bg-slate-950 h-fit p-10">

    <p class="text-gray-300 text-5xl">Wishlist</p>
    <form id="genreForm" action="" method="get">
        <label for="genre">Choisir un genre :</label>
        <select id="genre" name="genre" onchange="submitGenreForm()">
            <option value="">Tous les genres</option>
            <option value="28">Action</option>
            <option value="35">Comédie</option>
            <!-- Ajoutez d'autres options pour les genres -->
        </select>
    </form>

    <div class="mt-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8">
        <?php
        // Récupérer les films tendance
        $trendingMovies = getTrendingMovies();

        // Vérifier si un genre a été sélectionné
        $selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : null;

        // Itérer sur la liste de films tendance
        foreach ($trendingMovies['results'] as $movie) {
            // Vérifier si un genre est sélectionné et si le film correspond au genre
        ?>
            <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" class="w-64 h-96 rounded-lg cursor-pointer drop-shadow-md hover:scale-105 hover:shadow transition duration-700 object-cover">
        <?php

        }
        ?>
    </div>
</div>

<script>
    function submitGenreForm() {
        document.getElementById("genreForm").submit();
    }
</script>