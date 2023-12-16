<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre wishlist.";
    exit; // Arrête l'exécution du script si l'utilisateur n'est pas connecté
}

?>

<div class="bg-slate-950 h-screen mt-4 rounded-md p-10">
    <div class="flex items-center justify-between">
        <h1 class="text-gray-300 text-5xl">Wishlist</h1>
    </div>

    <div class="mt-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8">
        <?php
        try {
            $userId = $_SESSION['userid'];
            $stmt = $pdo->prepare("SELECT m.id, m.imdb_id, m.title, m.poster_url FROM wishlist w INNER JOIN movies m ON w.movie_id = m.id WHERE w.userid = :userid");
            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $filmUrl = "index.php?page=movie_search&id=" . htmlspecialchars($row['imdb_id']);  // Création de l'URL

                echo "<a href='$filmUrl' class='w-64 h-96 group relative flex flex-col text-white hover:scale-105 hover:shadow transition duration-700 cursor-pointer'>";
                echo "<img class='rounded-lg object-cover' src='https://image.tmdb.org/t/p/w500" . htmlspecialchars($row['poster_url']) . "'><br>";
                echo "<div class='opacity-0 rounded-lg bg-opacity-70 p-2  group-hover:opacity-100 bg-black transition duration-300 absolute inset-0 flex flex-col gap-2 justify-end text-white'>";
                echo "<h2 class='w-64 text-xl leading-tight pr-2 absolute top-12'>" . htmlspecialchars($row['title']) . "</h2>";
                echo "<form action='php/wishlist_delete.php' method='post' class='absolute top-0 right-0 mt-2 mr-2'>";
                echo "<input type='hidden' name='movie_id' value='" . $row['id'] . "'>";
                echo "<button type='submit'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' class='hover:scale-125 transition-all' height='24' viewBox='0 -960 960 960' width='24' fill='none'>";
                echo "<path d='M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z' stroke='red' stroke-width='20' />";
                echo "</svg>";
                echo "</button>";
                echo "</form>";
                echo "</div>";
                echo "</a>"; // Fin de la balise <a>
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<script>
    document.getElementById('genre').addEventListener('change', function() {
        this.form.submit();
    });
</script>