<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si déjà connecté, redirigez vers une autre page (comme le tableau de bord)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: ../index.php");
    exit;
}

require 'db_connect.php'; // Inclure db_connect.php

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Modifier ici pour inclure user_power dans la requête
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Ajouter user_power à la session
        $_SESSION['user_power'] = $user['user_power'];

        // Redirection vers index.php
        header("Location: ../index.php");
        exit;
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect";
    }
}

?>


        <div class="mt-3 text-center">
            <h1 class="text-lg leading-6 font-medium text-gray-900">Se connecter</h1>
            <div class="mt-2 px-7 py-3">
                <?php if (isset($error_message)) { ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>
                <form action="php/login.php" method="post">
                    <div class="mb-4">
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="mb-4">
                        <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="flex items-center justify-center">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline " name="submit" type="submit">
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>


