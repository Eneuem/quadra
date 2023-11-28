<?php

include 'dbconnect.php';

// Récupérez la note du formulaire
$note = $_POST["note"];
var_dump($note);  // Ajoutez cette ligne pour déboguer

// Préparez la requête d'insertion
$sql = "INSERT INTO notes (notes_value) VALUES (:note)";

// Préparez et exécutez la requête
$stmt = $conn->prepare($sql);
$stmt->bindParam(':note', $note);

try {
    $stmt->execute();
    echo "La note a été enregistrée avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de l'enregistrement de la note : " . $e->getMessage();
    echo "Erreur SQL : " . $sql;  // Ajoutez cette ligne pour afficher la requête SQL
    print_r($stmt->errorInfo());  // Ajoutez cette ligne pour afficher les détails de l'erreur PDO
}



?>

