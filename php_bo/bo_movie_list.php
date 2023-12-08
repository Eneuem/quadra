<?php

include 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT * FROM movies");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des films : " . $e->getMessage();
    exit;
}

?>
<!--todelete-->
<script src="https://cdn.tailwindcss.com"></script>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Liste des Films</h1>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($movies as $movie): ?>
                <div class="bg-white rounded shadow-lg p-4 flex flex-col">
                    <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Affiche" class="rounded mb-4">
                    <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($movie['title']); ?></h2>
                    <div class="flex justify-between mt-auto">
                        <a href="view_movie.php?id=<?php echo ($movie['imdb_id']); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Afficher</a>
                        <form method="post">
                            <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($movie['imdb_id']); ?>">
                            <button type="submit" name="delete_movie" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Effacer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>