<?php
// Inclure votre fichier de connexion à la base de données
include 'db_connect.php';

// Récupérer l'entrée de l'utilisateur
$input = $_GET['input'];

// Préparer la requête SQL avec un paramètre de liaison pour éviter les injections SQL
$query = "SELECT title, imdb_id FROM movies WHERE title LIKE :input";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':input', '%' . $input . '%', PDO::PARAM_STR);
$stmt->execute();

$suggestions = array();

// Récupérer les résultats et les ajouter au tableau de suggestions
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $suggestions[] = $row;
}

// Ne pas oublier de fermer la connexion à la base de données (pas nécessaire avec PDO, mais c'est une bonne pratique)
$pdo = null;

// Ajouter les liens avec l'ID IMDb aux suggestions
$suggestionsWithLink = array_map(function ($row) {
    return [
        'title' => $row['title'],
        'link'  => 'index.php?page=movie_search&id=' . urlencode($row['imdb_id']), // Ajoutez le lien avec l'ID IMDb
    ];
}, $suggestions);

// Retourner les suggestions au format JSON avec les liens
echo json_encode($suggestionsWithLink);
?>