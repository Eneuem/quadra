<div>
    <h1>Ma Wishlist</h1>
    <ul>
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

        try {
            $userId = $_SESSION['userid']; // Récupère l'ID de l'utilisateur de la session
            $stmt = $pdo->prepare("SELECT movie_id FROM wishlist WHERE user_id = :userid");
            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $movieId = $row['movie_id'];
                
                $apiUrl = "https://api.themoviedb.org/3/movie/$movieId";
                $movieDetails = makeApiRequest($apiUrl);

                if ($movieDetails) {
                    echo "<li>Titre: " . $movieDetails['title'] . "</li>";
                    echo "<img src='https://image.tmdb.org/t/p/w500" . $movieDetails['poster_path'] . "'><br>";

                    echo "<form action='wishlist_delete.php' method='post'>";
                    echo "<input type='hidden' name='movie_id' value='$movieId'>";
                    echo "<input type='submit' value='Supprimer'>";
                    echo "</form>";

                    if (!empty($movieDetails['genres'])) {
                        echo "<li>Genres: ";
                        foreach ($movieDetails['genres'] as $genre) {
                            echo $genre['name'] . " ";
                        }
                        echo "</li>";
                    }
                } else {
                    echo "<li>Erreur lors de la récupération des détails du film</li>";
                }
            }
        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
    </ul>
</div>
