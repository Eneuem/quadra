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

include 'db_connect.php'; // Connexion à la base de données MySQL

$imdbId = $_GET['id'] ?? ''; // Récupération de l'ID IMDb depuis l'URL

try {
    // Récupération des détails du film
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE imdb_id = :imdb_id");
    $stmt->bindParam(':imdb_id', $imdbId);
    $stmt->execute();

    $movieDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$movieDetails) {
        echo "Film non trouvé.";
        exit;
    }

    // Utilisation de l'ID interne du film pour récupérer les séances
    $movieInternalId = $movieDetails['id'];
    $stmt = $pdo->prepare("SELECT * FROM seances WHERE movie_id = :movie_id");
    $stmt->bindParam(':movie_id', $movieInternalId);
    $stmt->execute();

    $movieSessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des informations : " . $e->getMessage();
    exit;
}



// Conversion des données JSON en tableaux PHP
$movieGenres = json_decode(stripslashes(trim($movieDetails['genres'], '"')), true);
$movieActors = json_decode(stripslashes(trim($movieDetails['actors'], '"')), true);
$movieProducers = json_decode(stripslashes(trim($movieDetails['producers'], '"')), true);
$movieDirectors = json_decode(stripslashes(trim($movieDetails['directors'], '"')), true);

// Supposons que $movieDetails contient les détails de votre film depuis la base de données

// 1. Récupération de trailer_key sans json_decode (si ce n'est pas une chaîne JSON)
$trailer_key = $movieDetails['trailer_key'];
$movieVideo = "https://www.youtube.com/embed/" . $trailer_key;

// 2. Utilisation correcte de $movieDetails au lieu de $movieVideos
$trailerUrl = 'https://www.youtube.com/embed/' . htmlspecialchars($movieDetails['trailer_key'] ?? '');

?>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="css/rating_star.css">
<link rel="stylesheet" href="css/movie_random.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<div class="w-full min-h-screen flex flex-col items-center text-neutral-300 mt-4 rounded-md overflow-hidden bg-cover bg-no-repeat relative" style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $movieDetails['screenshot_urls'];  ?>');">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-80"></div>
    <div class="flex flex-col xl:flex-row w-full min-h-screen z-10 pt-10 tracking-wider">
        <!----cover movie---->
        <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movieDetails['poster_url']); ?>" class="md:w-96 w-80 h-full ml-4 rounded-lg object-contain">
        <div class="flex flex-col pl-4 pr-4 w-full min-h-full">
            <div class="flex flex-col">
                <!----title movie--->
                <h1 class="font-bold text-5xl mb-4 flex items-center">
                    <?php echo htmlspecialchars($movieDetails['title']); ?>
                </h1>
                <!-- Trigger pour ouvrir la modal -->
                <button id="openModalBtn" class="lg:w-[15%] w-[40%] mb-4 mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Voir le trailer</button>

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
                        <input type='hidden' name='movie_id' value='<?php echo $movieDetails['id']; ?>'>
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
            <!--- seance de cinéma start ---->
            <div class="flex items-center gap-4 mt-4 mb-4">
                <?php foreach ($movieSessions as $session) : ?>
                    <button class="bg-slate-950 w-36 p-2 text-yellow-400 flex items-center justify-around rounded-lg hover:bg-slate-600">
                        <div>
                            <p><?php echo htmlspecialchars(date('H\hi', strtotime($session['heure_de_seance']))); ?></p>
                            <p><?php echo htmlspecialchars($session['jour_de_seance']); ?></p>
                            <p><?php echo htmlspecialchars($session['langue']); ?></p>
                            <p>Salle <?php echo htmlspecialchars($session['nom_salle']); ?></p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" style="fill: #ffffff;">
                            <path d="M200-120q-17 0-28.5-11.5T160-160v-40q-50 0-85-35t-35-85v-200q0-50 35-85t85-35v-80q0-50 35-85t85-35h400q50 0 85 35t35 85v80q50 0 85 35t35 85v200q0 50-35 85t-85 35v40q0 17-11.5 28.5T760-120q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120Zm-40-160h640q17 0 28.5-11.5T840-320v-200q0-17-11.5-28.5T800-560q-17 0-28.5 11.5T760-520v160H200v-160q0-17-11.5-28.5T160-560q-17 0-28.5 11.5T120-520v200q0 17 11.5 28.5T160-280Zm120-160h400v-80q0-27 11-49t29-39v-112q0-17-11.5-28.5T680-760H280q-17 0-28.5 11.5T240-720v112q18 17 29 39t11 49v80Zm200 0Zm0 160Zm0-80Z" />
                        </svg>
                    </button>
                <?php endforeach; ?>
                <?php if (!$movieSessions) : ?>
                    <p class="text-xl">Aucune séance n'est disponible pour ce film.</p>
                <?php endif; ?>

            </div>
            <!--- seance de cinéma end ---->

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
                    <h5><b>Duration </b>: <?php echo htmlspecialchars($movieDetails['runtime']); ?> minutes</h5>
                    <h5>
                        <b>Genres </b>:
                        <?php echo implode(', ', array_column($movieGenres, 'name')); ?>
                    </h5>
                </div>
                <div class="flex flex-col">
                    <h5><b>Actors </b>:</h5>
                    <ul>
                        <?php foreach ($movieActors as $actor) : ?>
                            <li><?php echo htmlspecialchars($actor['name']); ?> (as <?php echo htmlspecialchars($actor['character']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>

                    <h5 class="mr-2 mt-4">
                        <ul class="list-none">
                            <?php
                            $producerNames = array_map('htmlspecialchars', $movieProducers);
                            $directorNames = array_map('htmlspecialchars', $movieDirectors);

                            if (!empty($producerNames)) {
                                echo '<li><b>Producer</b> : ' . implode(', ', $producerNames) . '</li>';
                            }

                            if (!empty($directorNames)) {
                                echo '<li><b>Director</b> : ' . implode(', ', $directorNames) . '</li>';
                            }
                            ?>
                        </ul>
                    </h5>

                </div>
            </div>
            <p class="w-full md:w-2/3 mt-10 mr-2 text-md md:text-xl mb-10 leading-relaxed h-64"><b>Synopsis </b>: <br> <?php echo htmlspecialchars($movieDetails['synopsis']); ?></p>
            <!---- film details end ---->

            <div class="mb-20 pt-4 ">
                <!-----trailer video ---->

                <!-- Modal -->
                <div id="trailerModal" class="modal hidden fixed inset-0 bg-opacity-40 overflow-y-auto h-full w-full">
                    <div class="modal-content relative p-4  w-full max-w-2xl m-auto mt-20 rounded">
                        <span id="closeModalBtn" class="close absolute top-4 right-4 text-3xl text-gray-600 cursor-pointer">&times;</span>
                        <?php if (!empty($movieVideo)) : ?>
                            <iframe class="w-full h-80" src='<?= $movieVideo ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var modal = document.getElementById("trailerModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementById("closeModalBtn");

        btn.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        span.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>


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