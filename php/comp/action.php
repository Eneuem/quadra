<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'php/db_connect.php';

$featuredMoviesStmt = $pdo->query("SELECT m.id, m.title, fv.position, m.poster_url FROM movies m JOIN films_vedette fv ON m.id = fv.movie_id ORDER BY fv.position ASC");
$featuredMovies = $featuredMoviesStmt->fetchAll();

?>
    <h1>A l'affiche :</h1>
    <div class="gap-4 grid p-4 sm:grid-cols-3 md:grid-cols- lg:grid-cols-4 xl:grid-cols-6 bg-black">
    <?php foreach ($featuredMovies as $movie): ?>
        <div class="relative group">
            <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full" />
            <div class="absolute bottom-0 left-0 right-0 p-2 px-4 text-white duration-500 bg-black opacity-0 group-hover:opacity-100 bg-opacity-40">
                <div class="flex justify-between w-full">
                    <div class="font-normal">
                        <p class="text-sm"><?php echo htmlspecialchars($movie['title']); ?></p>
                        <!-- Vous pouvez ajouter plus d'informations ici -->
                    </div>
                    <div class="flex items-center">
                        <img src="img/bookmark.svg" alt="bookmark" />
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- <script src="js/script.js" defer></script> -->
