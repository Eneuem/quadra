<?php
session_start();

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
    $stmt->bindParam(':userid', $userId);

    if ($stmt->execute()) {
        echo "Informations mises à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
