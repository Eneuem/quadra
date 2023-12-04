<?php

require 'db_connect.php';
// Formulaire d'inscription
if (isset($_POST['register'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
  
    // Vérifier si le pseudo ou l'email n'est pas déjà utilisé
    $query = $pdo->prepare("SELECT * FROM users WHERE pseudo = ? OR email = ?");
    $query->execute([$pseudo, $email]);
  
    if ($query->rowCount() == 0) {
        // Insertion des données dans la base de données
        $insert = $pdo->prepare("INSERT INTO users (pseudo, email, password) VALUES (?, ?, ?)");
        $insert->execute([$pseudo, $email, $password]);
  
        if ($insert) {
            echo "Inscription réussie.";
  
            // Stockez des informations sur l'utilisateur dans la session
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $email;
        } else {
            echo "Erreur lors de l'inscription.";
        }
    } else {
        echo "Le pseudo ou l'email est déjà utilisé.";
    }
  }
?>

