<?php
include 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll();

    if ($users) {
        echo "<form action='update_user_power.php' method='post'>";
        echo "<table class='border-b-2 py-4 gap-4 text-center'>";
        echo "<tr class='border-b-2'><th>ID</th><th>Username</th><th>Admin</th><th>Email</th><th>Actions</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user["id"]. "</td>";
            echo "<td>" . $user["username"]. "</td>";
            echo "<td><input type='checkbox' name='user_power[" . $user["id"] . "]' " . ($user["user_power"] ? "checked" : "") . "></td>";
            echo "<td>" . $user["email"]. "</td>";
            echo "<td><button type='submit' class='ml-4 bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-1 px-2 mx-4 rounded' name='update_power' value='" . $user["id"] . "' >Modifier</button>";
            echo "<a href='delete_user.php?id=" . $user["id"] . "' class='ml-4 bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 mx-4 rounded'>Supprimer</a></td>";
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
