<?php
include 'db_connect.php'; // Inclure votre script de connexion
include 'bo_check.php';
$userId = $_POST['update_power'];
$userPower = isset($_POST['user_power'][$userId]) ? 1 : 0;

try {
    $stmt = $pdo->prepare("UPDATE users SET user_power = ? WHERE id = ?");
    $stmt->execute([$userPower, $userId]);

    echo "User power mis à jour avec succès.";
    header('Location: main.php?page=list'); 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
