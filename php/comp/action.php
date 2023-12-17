<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'php/db_connect.php';

try {
    $featuredMoviesStmt = $pdo->query("SELECT m.id, m.imdb_id, m.title, m.poster_url, fv.position FROM movies m JOIN films_vedette fv ON m.id = fv.movie_id ORDER BY fv.position ASC");
    $featuredMovies = $featuredMoviesStmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des films en vedette : " . $e->getMessage();
    exit;
}

?>

<div class="bg-black rounded-t-lg">
    <h1 class="text-4xl text-center text-gray-300 mb-0 text-bold bg-black py-2 rounded-t-xl">In the Cinemas Now :</h1>
<div class="gap-4 grid p-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 bg-black rounded-b-xl">
    <?php foreach ($featuredMovies as $movie) : ?>
        <a href="index.php?page=movie_search&id=<?php echo htmlspecialchars($movie['imdb_id']); ?>" class="relative group block">
            <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full" />
            <div class="absolute bottom-0 left-0 right-0 p-2 px-4 text-white duration-500 bg-black opacity-0 group-hover:opacity-100 bg-opacity-40">
                <div class="flex justify-between w-full">
                    <div class="font-bold text-center">
                        <p class="text-xl text-center"><?php echo htmlspecialchars($movie['title']); ?></p>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
</div>



<!-- <script src="js/script.js" defer></script> -->