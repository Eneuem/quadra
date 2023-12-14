<?php
include 'api_connect.php';
include 'bo_check.php';
// Vérifie si la requête GET a été effectuée
if (isset($_GET['search'])) {
    // Récupère la chaîne de recherche de l'utilisateur
    $searchQuery = urlencode($_GET['search']);

    // URL pour rechercher des films avec la chaîne de recherche
    $searchUrl = "https://api.themoviedb.org/3/search/movie?include_adult=false&language=en-US&page=1&query=$searchQuery";

    // Fait la demande à l'API
    $searchResult = makeApiRequest($searchUrl);

    if (isset($searchResult['results'])) {
        foreach ($searchResult['results'] as $result) {
            $movieId = $result['id'];
            // Modifiez cette ligne pour pointer vers main.php
            echo "<li><a href='main.php?page=movieDetails&id=$movieId'>{$result['title']}</a></li>";
        }
    } else {
        echo "<li>No results found.</li>";
    }
}
?>