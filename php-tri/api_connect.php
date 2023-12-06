<?php
$apiKey = '3a539b9ea88570e988d990ee886eb42d';

function makeApiRequest($url, $api_key) {
    $curl = curl_init();

    $fullUrl = $url . "&api_key=" . $api_key;

    curl_setopt_array($curl, [
        CURLOPT_URL => $fullUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        die("Erreur cURL : " . $err);
    }

    return json_decode($response, true);
}
?>
