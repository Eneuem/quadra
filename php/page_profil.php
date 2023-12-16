<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre profil.";
    exit;
}

include 'db_connect.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
$stmt->bindParam(':userid', $_SESSION['userid']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtAbonnement = $pdo->prepare("SELECT * FROM abonnements WHERE user_id = :userid");
$stmtAbonnement->bindParam(':userid', $_SESSION['userid']);
$stmtAbonnement->execute();
$abonnement = $stmtAbonnement->fetch(PDO::FETCH_ASSOC);

?>

<div class="w-full h-screen bg-slate-950 flex flex-col items-center justify-center mt-4 rounded-md">
    <div class="flex justify-center items-center pt-6">
        <div class="flex flex-col justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" height="100" viewBox="0 -960 960 960" width="100" class="text-white">
                <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z" fill="white" />
            </svg>
        </div>
        <div class="flex flex-col justify-start items-center text-gray-300">
            <?php if ($abonnement) : ?>
                <p>Type d'abonnement : <?= htmlspecialchars($abonnement['type_abonnement']); ?></p>
                <p>Date de début : <?= htmlspecialchars($abonnement['date_debut']); ?></p>
                <p>Date de fin : <?= htmlspecialchars($abonnement['date_fin']); ?></p>
            <?php else : ?>
                <p>Aucun abonnement actif.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="text-gray-300 flex flex-col items-center justify-center text-xl">
        <form action="php/update_profile.php" method="POST" class="flex flex-col gap-4">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" class="text-black">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" class="text-black">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="*********" class="text-black">

            <div class="flex flex-col md:flex-row">
                <button type="submit" class="btn-save w-full md:w-auto text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">Save Changes</button>
                <button onclick="deleteAccount()" class="btn-delete w-full md:w-auto mt-4 md:mt-0 text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete Your Account</button>
            </div>
        </form>
    </div>

</div>



<script>
    function deleteAccount() {
        if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ?")) {
            window.location.href = "php/delete_profile.php";
        }
    }
</script>