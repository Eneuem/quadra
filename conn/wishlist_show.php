<div>
    <h1>Ma Wishlist</h1>
    <ul>
        <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        include 'db_connect.php';
        include 'api_connect.php'; 

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SELECT movie_id FROM wishlist");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $movieId = $row['movie_id'];
                
                $apiUrl = "https://api.themoviedb.org/3/movie/$movieId";
                $movieDetails = makeApiRequest($apiUrl);

                if ($movieDetails) {
                    echo "<li>ID du Film: " . $movieDetails['id'] . "</li>";
                    echo "<li>Titre: " . $movieDetails['title'] . "</li>";
                    echo "<img src='https://image.tmdb.org/t/p/w500" . $movieDetails['poster_path'] . "'><br>";

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
