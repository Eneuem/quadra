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

            // Formulaire pour ajouter à la Wishlist
            echo "<form action='wishlist_process.php' method='post'>";
            echo "<label for='movie_id'>ID du Film:</label>";
            echo "<input type='hidden' id='movie_id' name='movie_id' value='" . $movie['id'] . "'>";
            echo "<input type='submit' value='Ajouter à la Wishlist'>";
            echo "</form>";

            // Formulaire pour ajouter une note
            echo "<form action='add_note.php' method='post'>";
            echo "<label for='note'>Note:</label>";
            echo "<input type='number' id='note' name='note' min='1' max='10' required>";
            echo "<input type='hidden' id='user_id' name='user_id' value='1'>"; // Remplacez la valeur '1' par l'ID de l'utilisateur connecté
            echo "<input type='hidden' id='movie_id' name='movie_id' value='" . $movie['id'] . "'>";
            echo "<input type='submit' value='Ajouter une note'>";
            echo "</form>";
        }
    } else {
        echo "Erreur lors de la récupération des données.";
    }
} else {
    echo "Aucun genre sélectionné.";
}
?>
