<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['clear_error'])) {
    unset($_SESSION['error_message']);
}

// Si déjà connecté, redirigez vers une autre page (comme le tableau de bord)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: index.php?page=login");
    exit;
}

require 'db_connect.php'; 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_power'] = $user['user_power'];

        header("Location: ../index.php"); // Redirection vers index.php
        exit;
    } else {
        $_SESSION['error_message'] = "Nom d'utilisateur ou mot de passe incorrect";
        header("Location: ../index.php?page=login");
    }
}


?>

<div class="text-center bg-slate-950 h-screen mt-4 rounded-md flex flex-col justify-center items-center">
    <h1 class="text-lg leading-6 font-medium text-gray-300">Sign In</h1>
    <div class="mt-2 px-7 py-3">
        <?php if (isset($error_message)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative z-50" role="alert">
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
                <button class=" bg-blue-700 hover:bg-blue-800 text-white font-bold mb-5 py-2 px-4 rounded focus:outline-none focus:shadow-outline " name="submit" type="submit">
                    Connect
                </button>
            </div>
            <a href="index.php?page=signup" class=" text-gray-300 hover:text-white">Not Account Yet ?</a>
            <a href="index.php?page=reset" class=" text-gray-300 hover:text-white">Forgot Password ?</a>
        </form>
    </div>
</div>

<!-- Modal -->
<div id="errorModal" class="fixed z-10 inset-0 overflow-y-auto top-[40%] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- Modal content -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Erreur de connexion</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Nom d'utilisateur ou mot de passe incorrect. Veuillez réessayer.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="closeModalButton" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Fermer
        </button>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
      // Affiche la modal si un message d'erreur est défini
      if (<?php echo isset($_SESSION['error_message']) ? 'true' : 'false'; ?>) {
          $('#errorModal').removeClass('hidden');
      }

      // Fermer la modal et rediriger pour effacer le message d'erreur
      $('#closeModalButton').on('click', function(){
          window.location.href = 'index.php?page=login&clear_error=1';
      });
  });
</script>