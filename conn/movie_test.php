<?php 

include 'api_connect.php';

$data = json_decode($response, true);
$movies = $data['results'];


$timeWindow = 'week'; 
$url = "https://api.themoviedb.org/3/trending/movie/$timeWindow";

$data = makeApiRequest($url);
$movies = $data['results'];

if (count($movies) > 0) {
    $randomIndex = array_rand($movies);
    $randomMovie = $movies[$randomIndex];

    echo "Titre: " . $randomMovie['title'] . "\n";
    echo "Résumé: " . $randomMovie['overview'] . "\n";
    echo "Poster: https://image.tmdb.org/t/p/original" . $randomMovie['poster_path'];
} else {
    echo "Aucun film tendance trouvé.";
}
?>