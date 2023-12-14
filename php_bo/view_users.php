<?php
include 'db_connect.php';
include 'bo_check.php';
try {
    $stmt = $pdo->query("SELECT users.*, abonnements.type_abonnement, abonnements.date_debut, abonnements.date_fin FROM users LEFT JOIN abonnements ON users.id = abonnements.user_id");
    $users = $stmt->fetchAll();

    if ($users) {
        echo "<form action='update_user_power.php' method='post'>";
echo "<table class='border-b-2 py-4 gap-4 text-center'>";
echo "<tr class='border-b-2'><th>ID</th><th>Username</th><th>Admin</th><th>Email</th><th>Abonnement</th><th>Actions</th></tr>";

    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user["id"]. "</td>";
        echo "<td>" . $user["username"]. "</td>";
        echo "<td><input type='checkbox' name='user_power[" . $user["id"] . "]' " . ($user["user_power"] ? "checked" : "") . "></td>";
        echo "<td>" . $user["email"]. "</td>";
        echo "<td>" . ($user["type_abonnement"] ?? 'Aucun') . " du " . ($user["date_debut"] ?? 'N/A') . " au " . ($user["date_fin"] ?? 'N/A') . "</td>";
        echo "<td>";
        echo "<button type='submit' class='ml-4 bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-1 px-2 mx-4 rounded' name='update_power' value='" . $user["id"] . "' >Modifier</button>";
        echo "<a href='delete_user.php?id=" . $user["id"] . "' class='ml-4 bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 mx-4 rounded'>Supprimer</a>";
        echo "<button type='button' data-user-id='" . $user["id"] . "' class='offrir-premium ml-4 bg-blue-400 hover:bg-blue-600 text-white font-bold py-1 px-2 mx-4 rounded'>Offrir Premium</button>";
        echo "<button type='button' data-user-id='" . $user["id"] . "' class='offrir-basique ml-4 bg-green-400 hover:bg-green-600 text-white font-bold py-1 px-2 mx-4 rounded'>Offrir Basique</button>";
        echo "</td>";
        echo "</tr>";
    }
        echo "</table>";
        echo "</form>";
    } else {
        echo "Aucun utilisateur trouvé.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var boutonsPremium = document.querySelectorAll('.offrir-premium');
    boutonsPremium.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var userId = btn.getAttribute('data-user-id');
            offrirAbonnement('offrir_premium.php', userId);
        });
    });

    var boutonsBasique = document.querySelectorAll('.offrir-basique');
    boutonsBasique.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var userId = btn.getAttribute('data-user-id');
            offrirAbonnement('offrir_basique.php', userId);
        });
    });

    function offrirAbonnement(url, userId) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'userId=' + userId
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            window.location.reload(); // Recharge la page
        })
        .catch(error => console.error('Erreur:', error));
    }
});
</script>

