<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'api_connect.php';

$timeWindow = 'week'; 
$url = "https://api.themoviedb.org/3/trending/movie/$timeWindow";

$response = makeApiRequest($url);

if ($response) {
    $movies = $response['results'];

    if (count($movies) > 0) {
        $randomIndex = array_rand($movies);
        $randomMovie = $movies[$randomIndex];
        $movieId = $randomMovie['id'];

        // Détails supplémentaires du film
        $movieDetailsUrl = "https://api.themoviedb.org/3/movie/$movieId";
        $movieDetails = makeApiRequest($movieDetailsUrl);

        // Crédits du film
        $movieCreditsUrl = "https://api.themoviedb.org/3/movie/$movieId/credits";
        $movieCredits = makeApiRequest($movieCreditsUrl);

        echo "Titre: " . $randomMovie['title'] . "\n";
        echo "Année: " . substr($movieDetails['release_date'], 0, 4) . "\n";
        echo "Note: " . $movieDetails['vote_average'] . "/10\n";
        echo "Résumé: " . $randomMovie['overview'] . "\n";
        echo "Poster: <img src='https://image.tmdb.org/t/p/original" . $randomMovie['poster_path'] . "' alt='Poster'>\n";

        // Affichage des acteurs principaux et du réalisateur
        foreach ($movieCredits['cast'] as $key => $cast) {
            if ($key < 5) { // Limite aux 5 premiers acteurs
                echo "Acteur: " . $cast['name'] . " (en tant que " . $cast['character'] . ")\n";
            }
        }

        foreach ($movieCredits['crew'] as $crew) {
            if ($crew['job'] == 'Director' || $crew['job'] == 'Producer') {
                echo $crew['job'] . ": " . $crew['name'] . "\n";
            }
        }

        // Image/Screenshot (si disponible)
        $movieImagesUrl = "https://api.themoviedb.org/3/movie/$movieId/images";
        $movieImages = makeApiRequest($movieImagesUrl);
        if (count($movieImages['backdrops']) > 0) {
            echo "Screenshot: <img src='https://image.tmdb.org/t/p/original" . $movieImages['backdrops'][0]['file_path'] . "' alt='Screenshot'>\n";
        }

        // Formulaire pour ajouter à la Wishlist
        echo "<form action='process_wishlist.php' method='post'>";
        echo "<label for='movie_id'>ID du Film:</label>";
        echo "<input type='hidden' id='movie_id' name='movie_id' value='$movieId'>";
        echo "<input type='submit' value='Ajouter à la Wishlist'>";
        echo "</form>";
    } else {
        echo "Aucun film tendance trouvé.";
    }
} else {
    echo "Erreur lors de la récupération des données.";
}
?>
