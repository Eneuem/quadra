<?php
include 'api_connect.php';

// Vérifie si la requête GET a été effectuée
if (isset($_GET['search'])) {
    // Récupère la chaîne de recherche de l'utilisateur
    $searchQuery = urlencode($_GET['search']);

    // URL pour rechercher des films avec la chaîne de recherche
    $searchUrl = "https://api.themoviedb.org/3/search/movie?include_adult=false&language=en-US&page=1&query=$searchQuery";

    // Fait la demande à l'API
    $searchResult = makeApiRequest($searchUrl);

    // Affiche les résultats avec les détails
    if (isset($searchResult['results'])) {
        foreach ($searchResult['results'] as $result) {
            // Assurez-vous que l'image est disponible avant de l'afficher
            if (!empty($result['poster_path'])) {
                $imageUrl = "https://image.tmdb.org/t/p/w500" . $result['poster_path'];
                echo "<img src='$imageUrl' alt='{$result['title']}'> <br>";
                echo "<strong>Title:</strong> {$result['title']} <br>";
                echo "<strong>Release Date:</strong> {$result['release_date']} <br>";
                echo "<strong>Synopsis:</strong> {$result['overview']} <br><br>";
                echo "<button>Add to database</button> <br><br>";
            }
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
}

// ... Votre code existant ...

// Stocker les résultats de la recherche dans la session
$_SESSION['search_results'] = $searchResult['results'];

?>

