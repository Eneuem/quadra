<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';
include 'api_connect.php';

session_start(); // Assurez-vous que la session est démarrée

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre wishlist.";
    exit; // Arrête l'exécution du script si l'utilisateur n'est pas connecté
}
// Récupérer la liste des genres depuis l'API
$genres = makeApiRequest("https://api.themoviedb.org/3/genre/movie/list")['genres'];

// Récupérer le genre sélectionné, s'il y en a un
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : null;
?>
<div class="bg-slate-950 h-fit p-10">
    <div class="flex items-center justify-between">
        <h1 class="text-gray-300 text-5xl">Wishlist</h1>
        <form id="genreForm" action="" method="get" class="mt-5">
            <select id="genre" name="genre" onchange="submitGenreForm()" class="block py-2.5 px-0 w-full text-lg text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option value="" <?php echo !$selectedGenre ? 'selected' : ''; ?>>Filter by genre</option>
                <?php
                // Afficher tous les genres disponibles
                foreach ($genres as $genre) {
                    $selected = ($selectedGenre == $genre['id']) ? "selected" : "";
                    echo "<option value=\"{$genre['id']}\" {$selected}>{$genre['name']}</option>";
                }
                ?>
            </select>
        </form>
    </div>

    <div class="mt-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8">
        <?php
        try {
            $userId = $_SESSION['userid']; // Récupère l'ID de l'utilisateur de la session
            $stmt = $pdo->prepare("SELECT movie_id FROM wishlist WHERE userid = :userid");
            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $movieId = $row['movie_id'];

                $apiUrl = "https://api.themoviedb.org/3/movie/$movieId";
                $movieDetails = makeApiRequest($apiUrl);

                if ($movieDetails) {

                    echo "<div class='flex flex-col text-white'>";
                    // echo "<li>" . $movieDetails['title'] . "</li>";
                    echo "<img class='w-64 h-96 rounded-lg cursor-pointer drop-shadow-md hover:scale-105 hover:shadow transition duration-700 object-cover' src='https://image.tmdb.org/t/p/w500" . $movieDetails['poster_path'] . "'><br>";
                    echo "<form action='php/wishlist_delete.php' method='post'>";
                    echo "<input type='hidden' name='movie_id' value='$movieId'>";
                    echo "<input type='submit' value='Supprimer'>";
                    echo "</form>";

                    if (!empty($movieDetails['genres'])) {
                        echo "<li class='text-white'>Genres: ";
                        foreach ($movieDetails['genres'] as $genre) {
                            echo $genre['name'] . " ";
                        }
                        echo "</li>";
                    }
                    echo "</div>";
                } else {
                    echo "<li>Erreur lors de la récupération des détails du film</li>";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
    </div>


</div>