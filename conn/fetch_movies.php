<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'api_connect.php';

$genreId = $_GET['genre'] ?? ''; // Récupération de l'ID 

if (!empty($genreId)) {
    $url = "https://api.themoviedb.org/3/discover/movie?with_genres=$genreId";
    $response = makeApiRequest($url);

    if ($response) {
        $movies = $response['results'];

        foreach ($movies as $movie) {
            echo "Titre: " . $movie['title'] . "<br>";
            echo "Date de sortie: " . $movie['release_date'] . "<br>";
            echo "Synopsis: " . $movie['overview'] . "<br>";
            echo "<img src='https://image.tmdb.org/t/p/w500" . $movie['poster_path'] . "'><br>";
            echo "<hr>";
        }
    } else {
        echo "Erreur lors de la récupération des données.";
    }
} else {
    echo "Aucun genre sélectionné.";
}
?>
