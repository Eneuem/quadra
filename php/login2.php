<?php
include 'dbconnect.php';
session_start(); 

// Traitement du formulaire de connexion
if (isset($_POST['login'])) {
    $pseudoOrEmail = htmlspecialchars($_POST['pseudo']);
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $query = $pdo->prepare("SELECT * FROM formulaire WHERE pseudo = ? OR email = ?");
    $query->execute([$pseudoOrEmail, $pseudoOrEmail]);

    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['email'] = $user['email'];

            // Redirection vers la page d'accueil ou une autre page
            header("Location: accueil.php"); // Remplacez 'accueil.php' par le nom de votre page d'accueil
            exit;
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "L'utilisateur n'existe pas.";
    }
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $welcome_message = "Bienvenue " . $_SESSION['pseudo'] . " !";
    $logout_button = '<a href="deconnexion.php">Se déconnecter</a>';
} else {
    $welcome_message = "Bienvenue, veuillez vous connecter.";
    $logout_button = '';
}

// Formulaire d'inscription
// include 'inscription.php'; // Vérifiez si cela est nécessaire ici
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
    <?php echo $logout_button; ?>

    <!-- Formulaire d'inscription -->
    <!-- ... -->

    <!-- Formulaire de connexion -->
    <h2>Connexion</h2>
    <form action="login2.php" method="post">
        <input type="text" name="pseudo" placeholder="Votre identifiant (pseudo ou email)" required> <br/>
        <input type="password" name="password" placeholder="Votre Mot de passe" required><br/>
        <input type="submit" name="login" value="Se connecter"> <br/>
    </form>
</body>
</html>
