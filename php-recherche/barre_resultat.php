<?php include "process_movie_data.php"; ?>

<script src="https://cdn.tailwindcss.com"></script>

<!-- Ajouter la classe 'PageFilm.css' -->
<link rel="stylesheet" href="./css/PageFilm.css">

<!-- Inclure les polices Google -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<!-- Section principale -->
<main class="container-lg w-full flex flex-col items-center text-neutral-300 bg-cover bg-center bg-no-repeat bg-fixed relative" style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $movieDetails['backdrop_path']; ?>');">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-75"></div>

    <!-- Contenu du film -->
    <div class="flex flex-col lg:flex-row w-full z-10 md:pl-12 mt-10 tracking-wider">
        <img src="https://image.tmdb.org/t/p/w500<?php echo $movieDetails['poster_path']; ?>" class="w-96 ml-4 rounded object-contain">

        <div class="flex flex-col pl-4">
            <!-- Informations sur le film -->
            <div class="flex flex-col">
                <div class="flex items-center">
                    <h1 class="font-bold text-5xl mb-4">
                        <?php echo htmlspecialchars($movieDetails['title']); ?>
                    </h1>
                    <form method="post">
                        <?php if ($isInDatabase): ?>
                            <button type="submit" name="delete_from_database" class="ml-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete from Database</button>
                        <?php else: ?>
                            <button type="submit" name="add_to_database" class="ml-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add to Database</button>
                        <?php endif; ?>
                    </form>               
            </div>
            </div>

            <!-- Informations détaillées -->
            <div class="grid grid-cols-1 md:grid-cols-2 mt-4 text-lg">
                <!-- Afficher les détails -->
                <div class="flex flex-col gap-2">
                    <h5><b>Date:</b> <?php echo date('d/m/Y', strtotime($movieDetails['release_date'])); ?></h5>
                    <h5><b>Note:</b> <?php echo number_format($movieDetails['vote_average'], 1); ?>/10</h5>
                    <h5><b>Durée:</b> <?php echo $movieDetails['runtime']; ?> minutes</h5>
                    <h5><b>Genres:</b> <?php
                        $genreNames = [];
                        foreach ($movieDetails['genres'] as $genre) {
                            $genreNames[] = htmlspecialchars($genre['name']);
                        }
                        echo implode(', ', $genreNames);
                        ?></h5>
                </div>

                <!-- Acteurs -->
                <div class="flex flex-col">
                    <h5><b>Acteurs:</b></h5>
                    <ul>
                        <?php foreach ($movieCredits['cast'] as $key => $cast) : ?>
                            <?php if ($key < 5) : ?>
                                <li><?php echo htmlspecialchars($cast['name']); ?> (as <?php echo htmlspecialchars($cast['character']); ?>)</li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Producteurs et réalisateurs -->
            <div class="mt-4 text-lg">
                <ul class="list-none">
                    <?php
                    $producerNames = [];
                    $directorNames = [];

                    foreach ($movieCredits['crew'] as $crew) {
                        if ($crew['job'] == 'Producer') {
                            $producerNames[] = htmlspecialchars($crew['name']);
                        } elseif ($crew['job'] == 'Director') {
                            $directorNames[] = htmlspecialchars($crew['name']);
                        }
                    }

                    if (!empty($producerNames)) {
                        echo '<li><b>Producteurs:</b> ' . implode(', ', $producerNames) . '</li>';
                    }

                    if (!empty($directorNames)) {
                        echo '<li><b>Réalisateurs:</b> ' . implode(', ', $directorNames) . '</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Synopsis -->
            <p class="mt-4 text-xl leading-relaxed"><b>Synopsis:</b> <?php echo htmlspecialchars($movieDetails['overview']); ?></p>
        </div>
    </div>

    <!-- Afficher la vidéo s'il y en a une -->
    <?php if (!empty($movieVideos['results'])) : ?>
        <div class="mt-4">
            <iframe class="z-10 rounded-md" width='720' height='480' src='https://www.youtube.com/embed/<?php echo $movieVideos['results'][0]['key']; ?>' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
        </div>
    <?php endif; ?>
</main>