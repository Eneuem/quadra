
<!-- Affichage du formulaire -->
<form action="" method="get" id="genreForm">
    <label for="genre">Choisissez une catégorie :</label>
    <select name="genre" id="genreSelect">

        <?php
        // Afficher l'option pour afficher tous les genres
        $selectedAll = (empty($_GET['genre'])) ? 'selected' : '';
        echo '<option value="" ' . $selectedAll . '>Tous les genres</option>';

        // Afficher les options du menu déroulant
        foreach ($uniqueGenres as $genre) {
            $selected = (isset($_GET['genre']) && $_GET['genre'] == $genre) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($genre) . '" ' . $selected . '>' . htmlspecialchars($genre) . '</option>';
        }
        ?>

    </select>
    <input type="submit" value="Rechercher">
    <button type="button" onclick="resetForm()">Supprimer la recherche</button>
</form>
<!-- Conteneur pour les résultats des films -->
<div id="movieResultsContainer">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Inclure le fichier de connexion à la base de données
    include 'dbconnect.php';

    // Vérifier si un genre est sélectionné
    if (isset($_GET['genre'])) {
        $selectedGenre = $_GET['genre'];

        // Récupérer tous les genres distincts pour les films correspondant au genre sélectionné
        $sqlGenresForSelectedGenre = "SELECT DISTINCT genres FROM movies WHERE genres LIKE :genre";
        $stmtGenresForSelectedGenre = $pdo->prepare($sqlGenresForSelectedGenre);
        $stmtGenresForSelectedGenre->bindValue(':genre', '%' . $selectedGenre . '%');
        $stmtGenresForSelectedGenre->execute();

        // Stocker tous les genres dans un tableau unique
        $allGenres = [];
        while ($rowGenres = $stmtGenresForSelectedGenre->fetch(PDO::FETCH_ASSOC)) {
            $decodedGenres = json_decode(stripslashes(trim($rowGenres['genres'], '"')), true);
            if (is_array($decodedGenres)) {
                foreach ($decodedGenres as $genre) {
                    $allGenres[] = $genre['name'];
                }
            }
        }

        // Filtrer les genres pour les rendre uniques
        $uniqueGenres = array_unique($allGenres);

        // Afficher les genres filtrés
        echo '<p>Genres: <ul>';
        foreach ($uniqueGenres as $genre) {
            echo '<li>' . htmlspecialchars($genre) . '</li>';
        }
        echo '</ul></p>';

        // Vous pouvez également afficher d'autres détails ou suggestions ici

        // Afficher les résultats des films
        $selectedGenre = $_GET['genre'];
        $sqlMovies = "SELECT * FROM movies WHERE genres LIKE :genre";
        $stmtMovies = $pdo->prepare($sqlMovies);
        $stmtMovies->bindValue(':genre', '%' . $selectedGenre . '%');
        $stmtMovies->execute();

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
    } else {
        echo "Aucun genre sélectionné pour afficher des suggestions.";
    }
    ?>
</div>

<script>
function resetForm() {
    document.getElementById("genreForm").reset();
    document.getElementById("movieResultsContainer").innerHTML = ""; // Efface les résultats des films
}
</script>
