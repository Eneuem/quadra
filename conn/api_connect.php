<?php
$apiKey = '3a539b9ea88570e988d990ee886eb42d';

function makeApiRequest($url) {
    global $apiKey;
    $fullUrl = $url . "?api_key=$apiKey";
    $response = file_get_contents($fullUrl);
    if ($response === FALSE) {
        die("Erreur lors de la récupération des données.");
    }
    return json_decode($response, true);
}
?>
