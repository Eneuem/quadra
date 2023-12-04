<script src="https://cdn.tailwindcss.com" defer></script>

<div class="bg-slate-950 h-fit p-10">
    <div class="flex items-center justify-between">
        <p class="text-gray-300 text-5xl">Wishlist</p>
        <form id="genreForm" action="" method="get" class="mt-5">
            <select id="genre" name="genre" onchange="submitGenreForm()" class="block py-2.5 px-0 w-full text-lg text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected>
                    Filter by genre</option>
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
        // Vérifier si la clé "results" existe avant d'essayer d'y accéder
        if (isset($trendingMovies['results'])) {
            // Itérer sur la liste de films tendance
            foreach ($trendingMovies['results'] as $movie) {
                // Afficher les détails du film
        ?>
                <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" class="w-64 h-96 rounded-lg cursor-pointer drop-shadow-md hover:scale-105 hover:shadow transition duration-700 object-cover">
        <?php
            }
        } else {
            echo "Aucun résultat trouvé.";
        }
        ?>
    </div>
</div>

<script>
    function submitGenreForm() {
        document.getElementById("genreForm").submit();
    }
</script>