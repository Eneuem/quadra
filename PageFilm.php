<?php
session_start();

// Supposons que $userId est défini après une authentification réussie
// $_SESSION['user_id'] = $userId;

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
<style>
    body {
        --sb-track-color: #232425;
        --sb-thumb-color: #7d7d7d;
        --sb-size: 8px;

        scrollbar-color: var(--sb-thumb-color) var(--sb-track-color);
    }

    body::-webkit-scrollbar {
        width: var(--sb-size)
    }

    body::-webkit-scrollbar-track {
        background: var(--sb-track-color);
        border-radius: 5px;
    }

    body::-webkit-scrollbar-thumb {
        background: var(--sb-thumb-color);
        border-radius: 5px;
    }
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<main class="container-lg w-full h-100 flex flex-col items-center text-white bg-cover bg-center bg-no-repeat bg-fixed relative" style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $movieDetails['backdrop_path']; ?>');">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-75"></div>
    <div class="flex flex-col lg:flex-row w-full z-10 md:pl-12 mt-10">
        <img src="https://image.tmdb.org/t/p/w500<?php echo $randomMovie['poster_path']; ?>" class="w-96 ml-4 rounded object-contain">
        <div class="flex flex-col pl-4">
            <div class="flex flex-col">
                <div class="flex items-center">
                    <h1 class="font-bold text-5xl mb-4">
                        <?php echo htmlspecialchars($randomMovie['title']); ?>
                    </h1>
                    <span id="favorite" onclick="favFill()" class="material-symbols-outlined cursor-pointer ml-2" style="font-variation-settings:'FILL' 0;transition: filter 0.3s;">
                        favorite
                    </span>
                </div>
                <span class="material-symbols-outlined mt-4">
                    star
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 mt-10 text-lg">
                <div class="flex flex-col gap-2">
                    <h5>Year: <?php echo substr($movieDetails['release_date'], 0, 4); ?></h5>
                    <h5>Note: <?php echo number_format($movieDetails['vote_average'], 1); ?>/10</h5>
                    <h5>Duration: <?php echo $movieDetails['runtime']; ?> minutes</h5>
                    <h5>Genres: <?php foreach ($movieDetails['genres'] as $genre) {
                                    echo htmlspecialchars($genre['name']) . ' ';
                                } ?></h5>
                </div>

                <div class="flex flex-col">
                    <h5>Actors :</h5>
                    <ul>
                        <?php foreach ($movieCredits['cast'] as $key => $cast) : ?>
                            <?php if ($key < 5) : ?>
                                <li><?php echo htmlspecialchars($cast['name']); ?> (as <?php echo htmlspecialchars($cast['character']); ?>)</li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <h5 class="mr-2 mt-4">
                        <ul class="list-none">
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
                        </ul>
                    </h5>
                </div>
            </div>
            <p class="w-full md:w-2/3 mt-8 pr-2 text-2xl mb-4">Synopsis : <br> <?php echo htmlspecialchars($randomMovie['overview']); ?></p>
        </div>
    </div>
    <?php if (!empty($trailerUrl)) : ?>
        <iframe class="z-10 mb-20 rounded-md mt-4" width='560' height='315' src='https://www.youtube.com/embed/<?php echo $video['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
    <?php endif; ?>
</main>
<script>
    function favFill() {
        let favorite = document.getElementById("favorite");
        favorite.style.fontVariationSettings = "'FILL' 100";
    }
</script>

<script src="https://cdn.tailwindcss.com"></script>