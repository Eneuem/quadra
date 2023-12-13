<!-- Conteneur pour les résultats des films -->
<div id="movieResultsContainer">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Inclure le fichier de connexion à la base de données
    include 'dbconnect.php';

    // Récupérer les genres distincts depuis la base de données
    $sqlGenres = "SELECT DISTINCT genres FROM movies";
    $resultGenres = $pdo->query($sqlGenres);

    // Vérifier s'il y a des résultats
    if ($resultGenres) {
        $genres = $resultGenres->fetchAll(PDO::FETCH_COLUMN);

        // Filtrer les genres pour les rendre uniques
        $uniqueGenres = array_unique($genres);

        // Affichage du formulaire
        echo '<form action="" method="get" id="genreForm">';
        echo '<label for="genre">Choisissez une catégorie :</label>';
        echo '<select name="genre" id="genreSelect">';

        // Afficher les options du menu déroulant
        foreach ($uniqueGenres as $genre) {
            $selected = (isset($_GET['genre']) && $_GET['genre'] == $genre) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($genre) . '" ' . $selected . '>' . htmlspecialchars($genre) . '</option>';
        }

        // Option pour afficher tous les genres
        $selectedAll = (empty($_GET['genre'])) ? 'selected' : '';
        echo '<option value="" ' . $selectedAll . '>Tous les genres</option>';

        echo '</select>';
        echo '<input type="submit" value="Rechercher">';
        echo '<button type="button" onclick="resetForm()">Supprimer la recherche</button>';
        echo '</form>';

        // Si un genre est sélectionné, récupérer les films correspondants
        if (isset($_GET['genre'])) {
            $selectedGenre = $_GET['genre'];
            $sqlMovies = "SELECT * FROM movies WHERE genres = :genre";
            $stmtMovies = $pdo->prepare($sqlMovies);
            $stmtMovies->bindParam(':genre', $selectedGenre);
            $stmtMovies->execute();
        
            // Afficher les résultats des films
            while ($row = $stmtMovies->fetch(PDO::FETCH_ASSOC)) {
                echo '<div>';
                echo '<h2>' . $row['title'] . '</h2>';
        
                // Décoder la chaîne JSON dans la colonne 'genres'
                $decodedGenres = json_decode(stripslashes(trim($row['genres'], '"')), true);
        
                // Vérifier si $decodedGenres est un tableau avant d'utiliser foreach
                if (is_array($decodedGenres)) {
                    echo '<p>Genres: <ul>';
                    foreach ($decodedGenres as $genre) {
                        echo '<li>' . htmlspecialchars($genre['name']) . '</li>';
                    }
                    echo '</ul></p>';
                } else {
                    echo '<p>Aucun genre disponible pour ce film.</p>';
                }
        
                echo '<img src="' . $row['poster_url'] . '" alt="' . $row['title'] . '">';
                echo '</div>';
            }
        }
    } else {
        echo "Erreur lors de la récupération des genres depuis la base de données.";
    }
    ?>
</div>

<script>
function resetForm() {
    document.getElementById("genreForm").reset();
    document.getElementById("movieResultsContainer").innerHTML = ""; // Efface les résultats des films
}
</script>
