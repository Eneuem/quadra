<?php

include 'db_connect.php';

$stmt = $pdo->prepare("INSERT INTO movies (title, release_date, vote_average, runtime, genres, synopsis, actors, producers, directors, trailer_key) VALUES (:title, :release_date, :vote_average, :runtime, :genres, :synopsis, :actors, :producers, :directors, :trailer_key)");

$stmt->bindValue(':title', $movieTitle);
$stmt->bindValue(':release_date', $movieReleaseDate);
$stmt->bindValue(':vote_average', $movieVoteAverage);
$stmt->bindValue(':runtime', $movieRuntime);
$stmt->bindValue(':genres', json_encode($movieGenres)); // Convertit le tableau de genres en chaîne JSON
$stmt->bindValue(':synopsis', $movieSynopsis);
$stmt->bindValue(':actors', json_encode($movieActors)); // Convertit le tableau d'acteurs en chaîne JSON
$stmt->bindValue(':producers', implode(', ', $movieProducers)); // Convertit le tableau des producteurs en chaîne séparée par des virgules
$stmt->bindValue(':directors', implode(', ', $movieDirectors)); // Convertit le tableau des réalisateurs en chaîne séparée par des virgules
$stmt->bindValue(':trailer_key', $movieTrailerKey);

try {
    $stmt->execute();
    echo "Film ajouté avec succès à la base de données.";
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout du film : " . $e->getMessage();
}