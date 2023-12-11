<?php
// Inclure votre fichier de connexion à la base de données
include 'dbconnect.php';

// Récupérer l'entrée de l'utilisateur
$input = $_GET['input'];

// Préparer la requête SQL avec un paramètre de liaison pour éviter les injections SQL
$query = "SELECT title FROM movies WHERE title LIKE :input";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':input', '%' . $input . '%', PDO::PARAM_STR);
$stmt->execute();

$suggestions = array();

// Récupérer les résultats et les ajouter au tableau de suggestions
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $suggestions[] = $row;
}

// Retourner les suggestions au format JSON
echo json_encode($suggestions);

// Ne pas oublier de fermer la connexion à la base de données (pas nécessaire avec PDO, mais c'est une bonne pratique)
$pdo = null;
?>
