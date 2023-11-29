<?php
session_start();

// Supposons que $userId est défini après une authentification réussie
$_SESSION['user_id'] = $userId;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './php/api_connect.php';


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



// Récupérer les films tendance
$trendingMovies = getTrendingMovies();
?>


<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<main class="container-lg w-full flex flex-col items-center">
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
    <img src="./img/illustration.jpg" class="w-full h-96 object-cover hidden md:block">
    <div class="flex flex-col md:flex-row w-full md:pl-12">
        <img src="https://image.tmdb.org/t/p/w500<?php echo $randomMovie['poster_path']; ?>" class="w-full md:rounded-md md:w-72 md:relative md:bottom-48">
        <div class="flex flex-col pl-4">
            <div class="flex flex-col">
                <div class="flex items-center">
                    <h1 class="font-bold text-5xl">
                        <?php echo htmlspecialchars($randomMovie['title']); ?>
                    </h1>
                    <span class="material-symbols-outlined cursor-pointer ml-2 mt-2">
                        favorite
                    </span>
                </div>
                <span class="material-symbols-outlined">
                    star
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <h5>Year : <?php echo substr($movieDetails['release_date'], 0, 4); ?></h5>
                <h5>Note : <?php echo $movieDetails['vote_average']; ?>/10</h5>
                <h5>Duration : </h5>
                <h5>Genres : </h5>
                <h5>Producer and director
                    <?php
                    $producerNames = [];
                    $directorNames = [];

                    foreach ($movieCredits['crew'] as $crew) {
                        if ($crew['job'] == 'Producer') {
                            $producerNames[] = $crew['name'];
                        } elseif ($crew['job'] == 'Director') {
                            $directorNames[] = $crew['name'];
                        }
                    }

                    if (!empty($producerNames)) {
                        echo '<li>Producer: ' . implode(', ', array_map('htmlspecialchars', $producerNames)) . '</li>';
                    }

                    if (!empty($directorNames)) {
                        echo '<li>Director: ' . implode(', ', array_map('htmlspecialchars', $directorNames)) . '</li>';
                    }
                    ?>


                </h5>
                <div class="flex flex-col">
                    <h5>Acteurs :</h5>
                    <ul>
                        <?php foreach ($movieCredits['cast'] as $key => $cast) : ?>
                            <?php if ($key < 5) : ?>
                                <li><?php echo htmlspecialchars($cast['name']); ?> (en tant que <?php echo htmlspecialchars($cast['character']); ?>)</li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <p class="w-full md:w-2/3 mt-8 pr-2 mb-2">Synopsis : <br> <?php echo htmlspecialchars($randomMovie['overview']); ?></p>
        </div>
    </div>
    <video class="w-full md:w-2/3 mb-8" controls>
        <source src="./img/joker-trailer.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</main>

<script src="https://cdn.tailwindcss.com"></script>