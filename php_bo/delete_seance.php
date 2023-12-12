<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $seanceId = $_GET['id'];

    $deleteStmt = $pdo->prepare("DELETE FROM seances WHERE id = ?");
    $deleteStmt->execute([$seanceId]);

    header("Location: main.php?page=listseance");
    exit;
}
?>
