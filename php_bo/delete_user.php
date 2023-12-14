<?php
include 'db_connect.php'; 
include 'bo_check.php';

$userId = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    echo "Utilisateur supprimé avec succès.";
    header('Location: main.php?page=list'); 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

?>
