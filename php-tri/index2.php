<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier de connexion à la base de données
include 'dbconnect.php';

// Récupérer tous les genres depuis la base de données
$sql = "SELECT genres FROM movies";
$result = $pdo->query($sql);

// Initialiser un tableau pour stocker les genres uniques
$uniqueGenres = [];

// Parcourir chaque ligne de la table movies
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Décoder la chaîne JSON de la colonne genres
    $genres = json_decode($row['genres'], true);

    // Vérifier si la décodification a réussi et si c'est un tableau
    if (is_array($genres)) {
        // Parcourir chaque genre du film
        foreach ($genres as $genre) {
            // Ajouter le nom du genre au tableau $uniqueGenres
            $uniqueGenres[$genre['name']] = $genre['name'];
        }
    }
}

// Extraire les noms de genres uniques
$uniqueGenres = array_values($uniqueGenres);

// Afficher le tableau pour vérifier
echo '<pre>';
print_r($uniqueGenres);
echo '</pre>';
?>
