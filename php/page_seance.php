<?php
// Configuration et inclusion des fichiers nécessaires
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php'; // Assurez-vous que ce fichier contient votre connexion PDO

// Fonction pour obtenir les séances pour un jour donné de la semaine
function getSeancesForDay($pdo, $dayOfWeek) {
    $sql = "SELECT seances.*, movies.title AS movie_title FROM seances
            INNER JOIN movies ON seances.movie_id = movies.id
            WHERE seances.jour_de_seance = :dayOfWeek";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':dayOfWeek', $dayOfWeek);
    $stmt->execute();
    $seances = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Regroupement des séances par film
    $groupedSeances = [];
    foreach ($seances as $seance) {
        $groupedSeances[$seance['movie_title']][] = $seance;
    }

    return $groupedSeances;
}

// Déterminer le jour de la semaine actuel et le jour suivant
$daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
$todayIndex = date('w');
$tomorrowIndex = ($todayIndex + 1) % 7;

$today = $daysOfWeek[$todayIndex];
$tomorrow = $daysOfWeek[$tomorrowIndex];

$seancesToday = getSeancesForDay($pdo, $today);
$seancesTomorrow = getSeancesForDay($pdo, $tomorrow);

?>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<div class="p-4 w-full h-screen text-gray-300 bg-slate-950">
    <div x-data="{ tab: 'today' }">
        <!-- Onglets -->
        <div class="flex mb-4">
            <button @click="tab = 'today'" :class="{ 'bg-blue-500': tab === 'today', 'text-white': tab === 'today' }" class="py-2 px-4 rounded-l">Aujourd'hui</button>
            <button @click="tab = 'tomorrow'" :class="{ 'bg-blue-500': tab === 'tomorrow', 'text-white': tab === 'tomorrow' }" class="py-2 px-4 rounded-r">Demain</button>
        </div>

        <!-- Contenu de l'onglet "Aujourd'hui" -->
        <div x-show="tab === 'today'">
            <table class="w-full bg-slate-950 border text-left border-gray-300">
                <thead>
                    <tr>
                        <th class="w-1/4 px-4 py-2">Titre du Film</th>
                        <th class="px-4 py-2">Détails des Séances</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($seancesToday as $movie_title => $seances) : ?>
                        <tr>
                            <td class="border px-4 py-2"><?= htmlspecialchars($movie_title); ?></td>
                            <td class="border px-4 py-2">
                                <div class="flex items-center gap-4">
                                    <?php foreach ($seances as $seance) : ?>
                                        <button class="bg-slate-900 hover:bg-slate-800 w-36 p-2 text-gray-300 mr-2 flex items-center justify-around rounded-lg">
                                        <div>
                                            <p>Heure : <?php echo htmlspecialchars(date('H\hi', strtotime($seance['heure_de_seance']))); ?></p>
                                            <p>Langue : <?= htmlspecialchars($seance['langue']); ?></p>
                                            <p>Salle : <?= htmlspecialchars($seance['nom_salle']); ?></p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" style="fill: #ffffff;">
                                            <path d="M200-120q-17 0-28.5-11.5T160-160v-40q-50 0-85-35t-35-85v-200q0-50 35-85t85-35v-80q0-50 35-85t85-35h400q50 0 85 35t35 85v80q50 0 85 35t35 85v200q0 50-35 85t-85 35v40q0 17-11.5 28.5T760-120q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120Zm-40-160h640q17 0 28.5-11.5T840-320v-200q0-17-11.5-28.5T800-560q-17 0-28.5 11.5T760-520v160H200v-160q0-17-11.5-28.5T160-560q-17 0-28.5 11.5T120-520v200q0 17 11.5 28.5T160-280Zm120-160h400v-80q0-27 11-49t29-39v-112q0-17-11.5-28.5T680-760H280q-17 0-28.5 11.5T240-720v112q18 17 29 39t11 49v80Zm200 0Zm0 160Zm0-80Z" />
                                        </svg>
                                    </button>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Contenu de l'onglet "Demain" -->
        <div x-show="tab === 'tomorrow'">
        <table class="w-full bg-slate-950 border text-left border-gray-300">
                <thead>
                    <tr>
                        <th class="w-1/4 px-4 py-2">Titre du Film</th>
                        <th class="px-4 py-2">Détails des Séances</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($seancesTomorrow as $movie_title => $seances) : ?>
                        <tr>
                            <td class="border px-4 py-2"><?= htmlspecialchars($movie_title); ?></td>
                            <td class="border px-4 py-2">
                                <div class="flex items-center gap-4">
                                    <?php foreach ($seances as $seance) : ?>
                                        <button class="bg-slate-900 hover:bg-slate-800 w-36 p-2 text-gray-300 mr-2 flex items-center justify-around rounded-lg">
                                        <div>
                                            <p>Heure : <?php echo htmlspecialchars(date('H\hi', strtotime($seance['heure_de_seance']))); ?></p>
                                            <p>Langue : <?= htmlspecialchars($seance['langue']); ?></p>
                                            <p>Salle : <?= htmlspecialchars($seance['nom_salle']); ?></p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" style="fill: #ffffff;">
                                            <path d="M200-120q-17 0-28.5-11.5T160-160v-40q-50 0-85-35t-35-85v-200q0-50 35-85t85-35v-80q0-50 35-85t85-35h400q50 0 85 35t35 85v80q50 0 85 35t35 85v200q0 50-35 85t-85 35v40q0 17-11.5 28.5T760-120q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120Zm-40-160h640q17 0 28.5-11.5T840-320v-200q0-17-11.5-28.5T800-560q-17 0-28.5 11.5T760-520v160H200v-160q0-17-11.5-28.5T160-560q-17 0-28.5 11.5T120-520v200q0 17 11.5 28.5T160-280Zm120-160h400v-80q0-27 11-49t29-39v-112q0-17-11.5-28.5T680-760H280q-17 0-28.5 11.5T240-720v112q18 17 29 39t11 49v80Zm200 0Zm0 160Zm0-80Z" />
                                        </svg>
                                    </button>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
