<link rel="stylesheet" href="style.css">
<?php
session_start();


if (isset($_SESSION['userid'])) {
    echo 'ID de l\'utilisateur : ' . $_SESSION['userid'] . '<br>';
    echo 'Nom d\'utilisateur : ' . $_SESSION['username'];
} else {
    echo 'Aucune information d\'utilisateur stockée dans la session.';
}


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
            // Affichage des informations du film
            echo "Titre: " . $movie['title'] . "<br>";
            echo "Date de sortie: " . $movie['release_date'] . "<br>";
            echo "Synopsis: " . $movie['overview'] . "<br>";
            echo "<img src='https://image.tmdb.org/t/p/w500" . $movie['poster_path'] . "' alt='Poster du film'><br>";
            echo "<hr>";

            // Vérification si l'utilisateur est connecté
            if (isset($_SESSION['userid'])) {
                // Formulaire pour ajouter à la Wishlist
                echo "<form action='wishlist_process.php' method='post'>";
                echo "<input type='hidden' name='movie_id' value='" . $movie['id'] . "'>";
                echo "<input type='hidden' name='user_id' value='" . $_SESSION['userid'] . "'>";
                echo "<input type='submit' value='Ajouter à la Wishlist'>";
                echo "</form>";

                // Formulaire pour ajouter une note
                echo "<form action='notes.php' method='post'>";
                echo "<fieldset>";
                echo "<legend>Donnez une note</legend>";
                echo "<input type='hidden' name='id' value='sessionID'>";
                echo "<p class='wrapper-rating'>";
                echo "<input name='note' id='note_0' value='-1' type='radio' checked autofocus>";
                echo "<span class='star'>";
                echo "<input name='note' id='note_1' value='1' type='radio'>";
                echo "<label for='note_1' title='Très mauvaise'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>";
                echo "<path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />";
                echo "</svg>";
                echo "</label>";
                echo "<span class='star'>";
                echo "<input name='note' id='note_2' value='2' type='radio'>";
                echo "<label for='note_2' title='Médiocre'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>";
                echo "<path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />";
                echo "</svg>";
                echo "</label>";
                echo "<span class='star'>";
                echo "<input name='note' id='note_3' value='3' type='radio'>";
                echo "<label for='note_3' title='Moyenne'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>";
                echo "<path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />";
                echo "</svg>";
                echo "</label>";
                echo "<span class='star'>";
                echo "<input name='note' id='note_4' value='4' type='radio'>";
                echo "<label for='note_4' title='Bonne'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>";
                echo "<path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />";
                echo "</svg>";
                echo "</label>";
                echo "<span class='star'>";
                echo "<input name='note' id='note_5' value='5' type='radio'>";
                echo "<label for='note_5' title='Excellente'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='-2 -2 24 24'>";
                echo "<path d='m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z' />";
                echo "</svg>";
                echo "</label>";
                echo "</span>";
                echo "</span>";
                echo "</span>";
                echo "</span>";
                echo "</p>";
                echo "<input type='hidden' name='movie_id' value='" . $movie['id'] . "'>";
                echo "<input type='hidden' name='user_id' value='" . $_SESSION['userid'] . "'>";
                echo "<input type='submit' value='Ajouter une note'>";
                echo "</form>";
            } else {
                echo "Veuillez vous connecter pour ajouter des films à la wishlist ou pour noter.";
            }
        }
    } else {
        echo "Erreur lors de la récupération des données.";
    }
} else {
    echo "Aucun genre sélectionné.";
}
?>

