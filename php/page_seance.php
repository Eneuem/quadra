<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php'; // Inclure la connexion PDO existante

// Récupérer les données des séances avec le titre du film en utilisant une jointure
$sql = "SELECT seances.*, films.titre AS movie_title FROM seances
        INNER JOIN films ON seances.movie_id = films.id";
$result = $pdo->query($sql);
$seances = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos Séances</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="p-4 w-full h-screen text-gray-300 bg-slate-950">
    <div x-data="{ tab: 'today' }">
        <!-- Onglets -->
        <div class="flex mb-4">
            <button @click="tab = 'today'" :class="{ 'bg-blue-500': tab === 'today', 'text-white': tab === 'today' }" class="py-2 px-4 rounded-l">today</button>
            <button @click="tab = 'tomorrow'" :class="{ 'bg-blue-500': tab === 'tomorrow', 'text-white': tab === 'tomorrow' }" class="py-2 px-4 rounded-r">tomorrow</button>
        </div>

        <!-- Contenu des onglets -->
        <div x-show="tab === 'today'">
            <table class="w-full bg-slate-950 border text-left border-gray-300">
                <thead>
                    <tr>
                        <th class="w-1/4 px-4 py-2">Movie Title</th>
                        <th class="px-4 py-2">Movie Show</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($seances as $seance) : ?>
                        <tr>
                            <td class="border px-4 py-2"><?= htmlspecialchars($seance['movie_title']); ?></td>
                            <td class="border px-4 py-2 flex">
                                <button>
                                    <!--- seance de cinéma start ---->
                                    <div class="flex items-center gap-4">
                                        <button class="bg-slate-900 hover:bg-slate-800 w-36 p-2 text-gray-300 mr-2 flex items-center justify-around rounded-lg">
                                            <div>
                                                <p><?= htmlspecialchars($seance['heure_de_seance']); ?></p>
                                                <p><?= htmlspecialchars($seance['jour_de_seance']); ?></p>
                                                <p><?= htmlspecialchars($seance['langue']); ?></p>
                                                <p><?= htmlspecialchars($seance['nom_salle']); ?></p>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" style="fill: #ffffff;">
                                                <path d="M200-120q-17 0-28.5-11.5T160-160v-40q-50 0-85-35t-35-85v-200q0-50 35-85t85-35v-80q0-50 35-85t85-35h400q50 0 85 35t35 85v80q50 0 85 35t35 85v200q0 50-35 85t-85 35v40q0 17-11.5 28.5T760-120q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120Zm-40-160h640q17 0 28.5-11.5T840-320v-200q0-17-11.5-28.5T800-560q-17 0-28.5 11.5T760-520v160H200v-160q0-17-11.5-28.5T160-560q-17 0-28.5 11.5T120-520v200q0 17 11.5 28.5T160-280Zm120-160h400v-80q0-27 11-49t29-39v-112q0-17-11.5-28.5T680-760H280q-17 0-28.5 11.5T240-720v112q18 17 29 39t11 49v80Zm200 0Zm0 160Zm0-80Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!--- seance de cinéma end ---->
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div x-show="tab === 'tomorrow'">
            <!-- Contenu pour l'onglet 'tomorrow' (similaire à 'today') -->
        </div>
    </div>
</body>
</html>
