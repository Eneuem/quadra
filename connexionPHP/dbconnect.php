
<?php

define('HOST', 'localhost');
define('DB_NAME', 'Connexion');
define('USER', 'root');
define('PASS', 'root');




try {
    // Création de l'objet de connexion PDO
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    // Configuration pour afficher les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {}

?>
