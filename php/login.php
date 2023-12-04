<?php
include 'dbconnect.php';

// Session de connexion
session_start(); 

// Acceder à la session
if (isset($_SESSION['user_id'])) {
    $welcome_message = "Bienvenue " . $_SESSION['pseudo'] . " !";
    $logout_button = '<a href="deconnexion.php">Se déconnecter</a>';
} else {
    $welcome_message = "Bienvenue, veuillez vous connecter.";
    $logout_button = ''; // Pas de bouton de déconnexion si l'utilisateur n'est pas connecté
}

// Formulaire d'inscription
include 'inscription.php';

// Formulaire de connexion 
include 'connexion.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1><?php echo $welcome_message; ?></h1>

    <!-- Bouton de déconnexion -->
    <?php echo $logout_button; ?>


    <h2>Inscription</h2>
    <form action="" method="post">
        <input type="text" name="pseudo" id="pseudo" placeholder="Votre identifiant" required> <br/>
        <input type="text" name="email" placeholder="Votre Email" required><br/>
        <input type="password" name="password" id="password" placeholder="Votre Mot de passe" required><br/>
        <input type="submit" name="register" value="S'inscrire"> <br/>
    </form>

    <h2>Connexion</h2>
    <form action="" method="post">
        <input type="text" name="pseudo" id="pseudo" placeholder="Votre identifiant (pseudo ou email)" required> <br/>
        <input type="password" name="password" id="password" placeholder="Votre Mot de passe" required><br/>
        <input type="submit" name="login" value="Se connecter"> <br/>
        <a href="formulaire.php">mot de passe oublié</a>
        
    </form>
</body>
</html>
