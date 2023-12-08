<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';
include 'api_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre wishlist.";
    exit; // Arrête l'exécution du script si l'utilisateur n'est pas connecté
}

// Récupérer la liste des genres depuis l'API
$genres = makeApiRequest("https://api.themoviedb.org/3/genre/movie/list")['genres'];

// Récupérer le genre sélectionné, s'il y en a un
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : null;
?>
<script src="https://cdn.tailwindcss.com"></script>
<div class="bg-slate-950 h-screen p-10">
    <div class="flex items-center justify-between">
        <h1 class="text-gray-300 text-5xl">Wishlist</h1>
        <form id="genreForm" action="submit" method="GET">
            <select id="genre" name="genre" onchange="submitGenreForm()" class="block py-2.5 px-0 w-full text-lg text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option value="" <?php echo !$selectedGenre ? 'selected' : ''; ?>>Filter by genre</option>
                <?php
                // Afficher tous les genres disponibles
                foreach ($genres as $genre) {
                    $selected = ($selectedGenre == $genre['id']) ? "selected" : "";
                ?>
                    <option value="<?= $genre['id'] ?>" <?= $selected ?>><?= $genre['name'] ?></option>
                <?php
                }
                ?>
            </select>
        </form>
    </div>

    <div class="mt-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8">
        <?php
        try {
            $userId = $_SESSION['userid']; // Récupère l'ID de l'utilisateur de la session

            // Modification pour inclure la logique de filtrage par genre
            $stmt = ($selectedGenre)
                ? $pdo->prepare("SELECT movie_id FROM wishlist w INNER JOIN movie_genres mg ON w.movie_id = mg.movie_id WHERE w.userid = :userid AND mg.genre_id = :genre")
                : $pdo->prepare("SELECT movie_id FROM wishlist WHERE userid = :userid");

            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            if ($selectedGenre) {
                $stmt->bindParam(':genre', $selectedGenre, PDO::PARAM_INT);
            }
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $movieId = $row['movie_id'];
                $apiUrl = "https://api.themoviedb.org/3/movie/$movieId";
                $movieDetails = makeApiRequest($apiUrl);

                if ($movieDetails) {
        ?>
                    <div class="w-64 h-96 group relative flex flex-col text-gray-300 hover:scale-105 hover:shadow transition duration-700 cursor-pointer">
                        <img class="rounded-lg object-cover" src="https://image.tmdb.org/t/p/w500<?= $movieDetails['poster_path'] ?>"><br>
                        <div class="opacity-0 rounded-lg bg-opacity-70 p-2  group-hover:opacity-100 bg-black transition duration-300 absolute inset-0 flex flex-col gap-2 justify-end text-white">
                            <h2 class="w-64 text-xl leading-tight pr-2 absolute top-12"><?= $movieDetails['title'] ?></h2>
                            <form action="php/wishlist_delete.php" method="post" class="absolute top-0 right-0 mt-2 mr-2">
                                <input type="hidden" name="movie_id" value="<?= $movieId ?>">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="none">
                                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" stroke="red" stroke-width="20" />
                                    </svg>
                                </button>
                            </form>
                            <?php
                            if (!empty($movieDetails['genres'])) {
                            ?>
                                <li class="text-white list-none mb-4">Genres:
                                    <?php
                                    foreach ($movieDetails['genres'] as $genre) {
                                        echo $genre['name'] . "  ";
                                    }
                                    ?>
                                </li>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
        <?php
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

<script>
    function submitGenreForm() {
        const selectedGenre = document.getElementById("genre").value;
        window.location.href = window.location.pathname + '?genre=' + selectedGenre;
    }
</script>