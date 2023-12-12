<?php
// Calcul de la moyenne des notes
$sqlAverage = "SELECT AVG(notes_value) as average FROM notes";
$stmtAverage = $conn->prepare($sqlAverage);
$stmtAverage->execute();
$result = $stmtAverage->fetch(PDO::FETCH_ASSOC);
$average = $result['average'];

echo "La moyenne des notes est : " . round($average, 2);

function afficherMoyenneEnEtoiles($moyenne)
{
    // Nombre total d'étoiles
    $nombreEtoiles = 5;

    // Calculer le pourcentage de la moyenne par rapport au maximum (5 étoiles)
    $pourcentage = ($moyenne / $nombreEtoiles) * 100;

    // Créer une représentation visuelle avec des étoiles pleines et vides
    $etoilesPleines = round($pourcentage / 20);
    $etoilesVides = $nombreEtoiles - $etoilesPleines;

    // Afficher les étoiles
    echo str_repeat('★', $etoilesPleines) . str_repeat('☆', $etoilesVides);
}
