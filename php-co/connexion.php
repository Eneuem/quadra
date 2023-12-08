<?php

// Formulaire de connexion 
if (isset($_POST['login'])) {
  $pseudoOrEmail = htmlspecialchars($_POST['pseudo']);
  $password = $_POST['password'];

  // Vérifier si l'utilisateur existe avec le pseudo ou l'email fourni
  $query = $pdo->prepare("SELECT * FROM formulaire WHERE pseudo = ? OR email = ?");
  $query->execute([$pseudoOrEmail, $pseudoOrEmail]);

  if ($query->rowCount() > 0) {
      // Utilisateur trouvé, vérifier le mot de passe
      $user = $query->fetch(PDO::FETCH_ASSOC);

      if (password_verify($password, $user['password'])) {
          // Mot de passe correct, l'utilisateur est connecté
          echo "Connexion réussie.";

          // Stockez des informations sur l'utilisateur dans la session
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['pseudo'] = $user['pseudo'];
          $_SESSION['email'] = $user['email'];
      } else {
          echo "Mot de passe incorrect.";
      }
  } else {
      echo "L'utilisateur n'existe pas.";
  }

}