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

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="./css/PageFilm.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<main class="container-lg w-full flex flex-col items-center text-white bg-cover bg-center bg-no-repeat bg-fixed relative " style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $movieDetails['backdrop_path']; ?>');">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-75"></div>
    <div class="flex flex-col lg:flex-row w-full z-10 md:pl-12 mt-10  tracking-wider">
        <img src="https://image.tmdb.org/t/p/w500<?php echo $randomMovie['poster_path']; ?>" class="w-96 ml-4 rounded object-contain">
        <div class="flex flex-col pl-4">
            <div class="flex flex-col">
                <div class="flex items-center">
                    <h1 class="font-bold text-5xl mb-4">
                        <?php echo htmlspecialchars($randomMovie['title']); ?>
                    </h1>
                    <input type="checkbox" id="favorite" onclick="toggleHeart()" class="hidden">
                    <label for="favorite" class="material-symbols-outlined cursor-pointer ml-2 mr-2" style="font-variation-settings:'FILL' 0;transition: filter 0.3s;">
                        <svg id="heartWhite" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                            <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181" stroke="white" />
                        </svg>
                        <svg id="heartRed" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M12 4.248c-3.148-5.402-12-3.825-12 2.944 0 4.661 5.571 9.427 12 15.808 6.43-6.381 12-11.147 12-15.808 0-6.792-8.875-8.306-12-2.944" fill="red" />
                        </svg>
                    </label>
                </div>
                <span class="material-symbols-outlined mt-4">
                    star
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 mt-10 text-lg">
                <div class="flex flex-col gap-2">
                    <h5><b>Date </b>: <?php echo date('d/m/Y', strtotime($movieDetails['release_date'])); ?></h5>
                    <h5><b>Note </b>: <?php echo number_format($movieDetails['vote_average'], 1); ?>/10</h5>
                    <h5><b>Duration </b>: <?php echo $movieDetails['runtime']; ?> minutes</h5>
                    <h5><b>Genres </b>: <?php foreach ($movieDetails['genres'] as $genre) {
                                            echo htmlspecialchars($genre['name']) . ' ';
                                        } ?></h5>
                </div>
                <div class="flex flex-col">
                    <h5><b>Actors :</b></h5>
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
                                echo '<li><b>Producer</b> : ' . implode(', ', array_map('htmlspecialchars', $producerNames)) . '</li>';
                            }

                            if (!empty($directorNames)) {
                                echo '<li><b>Director</b> : ' . implode(', ', array_map('htmlspecialchars', $directorNames)) . '</li>';
                            }
                            ?>
                        </ul>
                    </h5>
                </div>
            </div>
            <p class="w-full md:w-2/3 mt-8 pr-2 text-xl mb-4 leading-relaxed"><b>Synopsis </b>: <br> <?php echo htmlspecialchars($randomMovie['overview']); ?></p>
        </div>
    </div>
    <?php if (!empty($trailerUrl)) : ?>
        <iframe class="z-10 mb-20 rounded-md mt-4 hidden md:block" width='720' height='480' src='https://www.youtube.com/embed/<?php echo $video['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
        <iframe class="z-10 mb-20 rounded-md mt-4 md:hidden" width='480' height='360' src='https://www.youtube.com/embed/<?php echo $video['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
    <?php endif; ?>
</main>

<script>
    function toggleHeart() {
        var checkbox = document.getElementById("favorite");
        var heartWhite = document.getElementById("heartWhite");
        var heartRed = document.getElementById("heartRed");

        if (checkbox.checked) {
            heartWhite.style.display = "none";
            heartRed.style.display = "inline";
        } else {
            heartWhite.style.display = "inline";
            heartRed.style.display = "none";
        }
    }
</script>

<script src="https://cdn.tailwindcss.com"></script>