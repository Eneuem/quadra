<!-- Affichage du formulaire -->
<form action="" method="get" id="movieForm">
    <label for="genre">Choisissez une catégorie :</label>
    <select name="genre" id="genre">
        <option value="28" <?php if (isset($_GET['genre']) && $_GET['genre'] == '28') echo 'selected'; ?>>Action</option>
        <option value="35" <?php if (isset($_GET['genre']) && $_GET['genre'] == '35') echo 'selected'; ?>>Comédie</option>
        <option value="27" <?php if (isset($_GET['genre']) && $_GET['genre'] == '27') echo 'selected'; ?>>Horreur</option>
        <option value="10749" <?php if (isset($_GET['genre']) && $_GET['genre'] == '10749') echo 'selected'; ?>>Romance</option>
        <option value="878" <?php if (isset($_GET['genre']) && $_GET['genre'] == '878') echo 'selected'; ?>>Science-Fiction</option>
        <option value="53" <?php if (isset($_GET['genre']) && $_GET['genre'] == '53') echo 'selected'; ?>>Thriller</option>
        <option value="16" <?php if (isset($_GET['genre']) && $_GET['genre'] == '16') echo 'selected'; ?>>Animation</option>
        <option value="12" <?php if (isset($_GET['genre']) && $_GET['genre'] == '12') echo 'selected'; ?>>Aventure</option>
        <option value="80" <?php if (isset($_GET['genre']) && $_GET['genre'] == '80') echo 'selected'; ?>>Crime</option>
        <option value="" <?php if (empty($_GET['genre'])) echo 'selected'; ?>>Tous les genres</option>
    </select>
    <input type="submit" value="Rechercher">
    <button type="button" onclick="resetForm()">Supprimer la recherche</button>
</form>




<!-- Conteneur pour les résultats des films -->
<div id="movieResultsContainer">
    <?php
    include 'api_connect.php';

    // Vérifie si le formulaire a été soumis
    if (isset($_GET['genre'])) {
        $genre = $_GET['genre'];
        $url = "https://api.themoviedb.org/3/discover/movie?with_genres=$genre&language=en";

        $response = makeApiRequest($url, $apiKey);

        // Vérifie que la clé 'results' existe dans la réponse
        if (isset($response['results'])) {
            foreach ($response['results'] as $movie) {
                // Assurez-vous que l'image et le titre sont disponibles avant de les afficher
                if (!empty($movie['poster_path']) && !empty($movie['title'])) {
                    $imageUrl = "https://image.tmdb.org/t/p/w500" . $movie['poster_path'];
                    echo "<img src='$imageUrl' alt='{$movie['title']}'> <br>";
                    echo "<strong>Title:</strong> {$movie['title']} <br>";

                    // Ajout du synopsis (overview)
                    if (!empty($movie['overview'])) {
                        echo "<strong>Synopsis:</strong> {$movie['overview']} <br>";
                    } else {
                        echo "<em>Aucun synopsis disponible</em> <br>";
                    }

                    echo "<br>";
                }
            }
        } else {
            echo "Aucun résultat trouvé.";
        }
    }
    ?>
</div>

<script>
function resetForm() {
    document.getElementById("movieForm").reset();
    document.getElementById("movieResultsContainer").innerHTML = ""; // Efface les résultats des films
}
</script>

