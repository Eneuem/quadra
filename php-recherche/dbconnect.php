<?php
define('HOST', 'localhost');
define('DB_NAME', 'Connexion');
define('USER', 'root');
define('PASS', 'root'); // Laissez ceci comme une chaîne vide si le mot de passe de MAMP est vide par défaut

try {
    // Création de l'objet de connexion PDO
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    // Configuration pour afficher les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Afficher l'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    // Arrêter l'exécution du script
    die();
}
?>


