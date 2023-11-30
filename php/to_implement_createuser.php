<?php
require 'db_connect.php';

$username = 'admin2';
$password = 'pass';

// Hacher le mot de passe avec la fonction password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$username, $hashed_password]);

echo "Utilisateur ajouté avec succès";
?>
