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

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="./css/rating_star.css">
<link rel="stylesheet" href="./css/movie_random.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<div class="w-full min-h-screen flex flex-col items-center text-neutral-300 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $movieDetails['backdrop_path']; ?>');">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-80"></div>
    <div class="flex flex-col xl:flex-row w-full min-h-screen z-10 pt-10 tracking-wider">
        <!----cover movie---->
        <img src="https://image.tmdb.org/t/p/w500<?php echo $randomMovie['poster_path']; ?>" class="w-96 h-full ml-4 rounded-lg object-contain">
        <div class="flex flex-col pl-4 pr-4 w-full min-h-full">
            <div class="flex flex-col">
                <!----title movie--->
                <h1 class="font-bold text-5xl mb-4 flex items-center">
                    <?php echo htmlspecialchars($randomMovie['title']); ?>
                </h1>
                <div class="flex items-center gap-1">
                    <!----rating star components start---->
                    <form action='notes.php' method='post' class="mt-2">
                        <fieldset>
                            <input type='hidden' name='id' value='sessionID'>
                            <p class='wrapper-rating'>
                                <input name='note' id='note_0' value='-1' type='radio' checked autofocus>
                                <span class='star'>
                                    <input name='note' id='note_1' value='1' type='radio'>
                                    <label for='note_1' title='Très mauvaise'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>
                                            <path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />
                                        </svg>
                                    </label>
                                    <span class='star'>
                                        <input name='note' id='note_2' value='2' type='radio'>
                                        <label for='note_2' title='Médiocre'>
                                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>
                                                <path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />
                                            </svg>
                                        </label>
                                        <span class='star'>
                                            <input name='note' id='note_3' value='3' type='radio'>
                                            <label for='note_3' title='Moyenne'>
                                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>
                                                    <path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />
                                                </svg>
                                            </label>
                                            <span class='star'>
                                                <input name='note' id='note_4' value='4' type='radio'>
                                                <label for='note_4' title='Bonne'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>
                                                        <path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />
                                                    </svg>
                                                </label>
                                                <span class='star'>
                                                    <input name='note' id='note_5' value='5' type='radio'>
                                                    <label for='note_5' title='Excellente'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>
                                                            <path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />
                                                        </svg>
                                                    </label>
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                                </span>
                                </span>
                            </p>
                            <input type='hidden' name='movie_id' value='<?php echo $movie['id']; ?>'>
                            <input type='hidden' name='user_id' value='<?php echo $_SESSION['userid']; ?>'>
                        </fieldset>
                    </form>
                    <!----rating star components end---->

                    <!----wishlist icon start ---->
                    <form id="wishlistForm" action='php/wishlist_process.php' method='post'>
                        <input type='hidden' name='movie_id' value='<?php echo $randomMovie['id']; ?>'>
                        <input type='hidden' name='user_id' value='<?php echo $_SESSION['userid']; ?>'>
                        <input type="checkbox" id="favorite" onclick="toggleHeart()" class="hidden">
                        <label for="favorite" class="material-symbols-outlined cursor-pointer mt-2 ml-2 mr-2" style="font-variation-settings:'FILL' 0;transition: filter 0.3s;" onclick="document.getElementById('wishlistForm').submit();">
                            <svg id="heartWhite" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181" stroke="white" />
                            </svg>
                            <svg id="heartRed" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M12 4.248c-3.148-5.402-12-3.825-12 2.944 0 4.661 5.571 9.427 12 15.808 6.43-6.381 12-11.147 12-15.808 0-6.792-8.875-8.306-12-2.944" fill="red" />
                            </svg>
                        </label>
                    </form>
                    <!----wishlist icon end ---->
                </div>
            </div>

            <!---- film details start ---->
            <div class="grid grid-cols-1 md:grid-cols-2 text-lg">
                <div class="flex flex-col gap-2">
                    <!-- Circle -->
                    <div x-data="scrollProgress(<?php echo number_format(($movieDetails['vote_average'] / 10) * 100, 0); ?>)" x-init="init" class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-black">
                        <svg class="w-20 h-20">
                            <circle class="text-gray-300" stroke-width="5" :stroke="color" fill="transparent" :r="radius" :cx="center" :cy="center" />
                            <circle id="circleProgress" style="color: blue;" stroke-width="5" :stroke-dasharray="circumference" :stroke-dashoffset="circumference - percent / 100 * circumference" stroke-linecap="round" :stroke="color" fill="transparent" :r="radius" :cx="center" :cy="center" />
                        </svg>
                        <span id="percentageProgress" class="absolute text-xl" x-text="`${percent}%`"></span>
                    </div>
                    <h5><b>Date </b>: <?php echo date('d/m/Y', strtotime($movieDetails['release_date'])); ?></h5>
                    <h5><b>Duration </b>: <?php echo $movieDetails['runtime']; ?> minutes</h5>
                    <h5>
                        <b>Genres </b>:
                        <?php
                        $firstGenre = true;
                        foreach ($movieDetails['genres'] as $genre) {
                            if (!$firstGenre) {
                                echo ', ';
                            } else {
                                $firstGenre = false;
                            }
                            echo htmlspecialchars($genre['name']);
                        }
                        ?>
                    </h5>
                </div>
                <div class="flex flex-col">
                    <h5><b>Actors </b>:</h5>
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
            <p class="w-full md:w-2/3 mt-10 mr-2 text-xl leading-relaxed h-64"><b>Synopsis </b>: <br> <?php echo htmlspecialchars($randomMovie['overview']); ?></p>
            <!---- film details end ---->

            <div class="mb-20 pt-4 ">
                <!-----trailer video ---->
                <?php if (!empty($trailerUrl)) : ?>
                    <iframe class="rounded-md hidden md:block" width='720' height='400' src='https://www.youtube.com/embed/<?php echo $video['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
                    <iframe class="rounded-md md:hidden mt-14" width='470' height='270' src='https://www.youtube.com/embed/<?php echo $video['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.star label').on('click', function() {
            // Obtenez la valeur de l'étoile cliquée
            var ratingValue = $(this).prev('input').val();

            // Mettez à jour la valeur du champ de note
            $('input[name="note"]').val(ratingValue);

            // Soumettez le formulaire
            $('form').submit();
        });
    });

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

    const scrollProgress = (initialPercent) => {
        const colorProgress = document.getElementById('circleProgress');
        const colorPercentages = document.getElementById('percentageProgress')
        return {
            init() {
                this.circumference = 30 * 2 * Math.PI;
                this.percent = initialPercent;
                this.radius = 30;
                this.center = 40;
                this.color = 'currentColor';
                if (initialPercent < 30) {
                    colorProgress.style.color = 'red';
                    colorPercentages.style.color = 'red';
                } else if (initialPercent <= 50) {
                    colorPercentages.style.color = 'orange';
                    colorProgress.style.color = 'orange';
                } else if (initialPercent <= 70) {
                    colorPercentages.style.color = 'yellow';
                    colorProgress.style.color = 'yellow';
                } else if (initialPercent <= 90) {
                    colorPercentages.style.color = 'green';
                    colorProgress.style.color = 'green';
                } else {
                    colorPercentages.style.color = 'blue';
                    colorProgress.style.color = 'blue';
                }
            },
        };
    };
    const myScrollProgress = scrollProgress(<?php echo number_format(($movieDetails['vote_average'] / 10) * 100, 0); ?>);
</script>

<!-- FETCH SANS RELOAD -->

<script>
    document.getElementById("ratingForm").addEventListener("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch('php/notes.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
            })
            .catch(error => console.error('Error:', error));
    });
</script>
<!-- AFFICHAGE ETOILES -->

<script>
window.addEventListener('load', (event) => {
    var currentRating = <?php echo json_encode($currentRating); ?>;
    if (currentRating) {
        document.getElementById('note_' + currentRating).checked = true;
    }
});
</script>

<script>
document.getElementById("wishlistForm").addEventListener("submit", function(e) {
    e.preventDefault(); 

    var formData2 = new FormData(this);

    fetch('php/wishlist_process.php', {
        method: 'POST',
        body: formData2
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => console.error('Error:', error));
});

    window.addEventListener('load', (event) => {
        var currentRating = <?php echo json_encode($currentRating); ?>;
        if (currentRating) {
            document.getElementById('note_' + currentRating).checked = true;
        }
    });
</script>
