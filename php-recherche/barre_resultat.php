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



var_dump($movieTitle, $movieReleaseDate, $movieVoteAverage, $movieRuntime, $movieGenres, $movieSynopsis, $movieActors, $movieProducers, $movieDirectors, $movieTrailerKey);

if (isset($_POST['add_to_database'])) {
    include ("dbconnect.php");

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
    

// Préparation de la requête SQL
$stmt = $pdo->prepare("INSERT INTO movies (title, release_date, vote_average, runtime, genres, synopsis, actors, producers, directors, trailer_key) VALUES (:title, :release_date, :vote_average, :runtime, :genres, :synopsis, :actors, :producers, :directors, :trailer_key)");

// Liaison des variables
$stmt->bindValue(':title', $movieTitle);
$stmt->bindValue(':release_date', $movieReleaseDate);
$stmt->bindValue(':vote_average', $movieVoteAverage);
$stmt->bindValue(':runtime', $movieRuntime);
$stmt->bindValue(':genres', $movieGenres); // Ne pas utiliser json_encode ici car les données sont déjà au format JSON
$stmt->bindValue(':synopsis', $movieSynopsis);
$stmt->bindValue(':actors', $movieActors); // Ne pas utiliser json_encode ici
$stmt->bindValue(':producers', $movieProducers); // Ne pas utiliser json_encode ici
$stmt->bindValue(':directors', $movieDirectors); // Ne pas utiliser json_encode ici
$stmt->bindValue(':trailer_key', $movieTrailerKey);

// Exécution de la requête
try {
    $stmt->execute();
    echo "Film ajouté avec succès à la base de données.";
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout du film : " . $e->getMessage();
}

}
?>

?>

<!-- Inclure les feuilles de style -->
<link rel="stylesheet" href="https://cdn.tailwindcss.com">

<!-- Ajouter la classe 'PageFilm.css' -->
<link rel="stylesheet" href="./css/PageFilm.css">

<!-- Inclure les polices Google -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<!-- Section principale -->
<main class="container-lg w-full flex flex-col items-center text-neutral-300 bg-cover bg-center bg-no-repeat bg-fixed relative " style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $movieDetails['backdrop_path']; ?>');">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-75"></div>

    <!-- Contenu du film -->
    <div class="flex flex-col lg:flex-row w-full z-10 md:pl-12 mt-10 tracking-wider">
        <img src="https://image.tmdb.org/t/p/w500<?php echo $movieDetails['poster_path']; ?>" class="w-96 ml-4 rounded object-contain">

        <div class="flex flex-col pl-4">
            <!-- Informations sur le film -->
            <div class="flex flex-col">
                <div class="flex items-center">
                    <h1 class="font-bold text-5xl mb-4">
                        <?php echo htmlspecialchars($movieDetails['title']); ?>
                    </h1>
                </div>

                <!-- Ajout database -->
                <form method="post">
                <button type="submit" name="add_to_database">Add to Database</button>
                </form>

                <button>Delete from Database</button>
            </div>

            <!-- Informations détaillées -->
            <div class="grid grid-cols-1 md:grid-cols-2 mt-8 text-lg">
                <div class="flex flex-col gap-2">
                    <!-- Afficher les détails -->
                    <h5><b>Date </b>: <?php echo date('d/m/Y', strtotime($movieDetails['release_date'])); ?></h5>
                    <h5><b>Note </b>: <?php echo number_format($movieDetails['vote_average'], 1); ?>/10</h5>
                    <h5><b>Duration </b>: <?php echo $movieDetails['runtime']; ?> minutes</h5>
                    <h5><b>Genres </b>: <?php
                                        $firstGenre = true;
                                        foreach ($movieDetails['genres'] as $genre) {
                                            if (!$firstGenre) {
                                                echo ', ';
                                            } else {
                                                $firstGenre = false;
                                            }
                                            echo htmlspecialchars($genre['name']);
                                        }
                                        ?></h5>

                </div>
                <div class="flex flex-col">
                    <!-- Acteurs -->
                    <h5><b>Actors </b>:</h5>
                    <ul>
                        <?php foreach ($movieCredits['cast'] as $key => $cast) : ?>
                            <?php if ($key < 5) : ?>
                                <li><?php echo htmlspecialchars($cast['name']); ?> (as <?php echo htmlspecialchars($cast['character']); ?>)</li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Producteurs et réalisateurs -->
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

            <!-- Synopsis -->
            <p class="w-full md:w-2/3 mt-8 pr-2 text-xl mb-4 leading-relaxed"><b>Synopsis </b>: <?php echo htmlspecialchars($movieDetails['overview']); ?></p>
        </div>
    </div>

    <!-- Afficher la vidéo s'il y en a une -->
    <?php if (!empty($movieVideos['results'])) : ?>
        <iframe class="z-10 mb-20 rounded-md mt-4 hidden md:block" width='720' height='480' src='https://www.youtube.com/embed/<?php echo $movieVideos['results'][0]['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
        <iframe class="z-10 mb-20 rounded-md mt-4 md:hidden" width='480' height='360' src='https://www.youtube.com/embed/<?php echo $movieVideos['results'][0]['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
    <?php endif; ?>
</main>

<!-- Script pour basculer l'icône du cœur -->
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

<!-- Inclure à nouveau le CDN de TailwindCSS -->
<script src="https://cdn.tailwindcss.com"></script>