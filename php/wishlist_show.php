<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre wishlist.";
    exit; // Arrête l'exécution du script si l'utilisateur n'est pas connecté
}

?>

<div class="bg-slate-950 h-screen mt-4 rounded-md p-10">
    <div class="flex items-center justify-between">
        <h1 class="text-gray-300 text-5xl">Wishlist</h1>
    </div>

    <div class="mt-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8">
        <?php
        try {
            $userId = $_SESSION['userid'];
            $stmt = $pdo->prepare("SELECT m.id, m.imdb_id, m.title, m.poster_url FROM wishlist w INNER JOIN movies m ON w.movie_id = m.id WHERE w.userid = :userid");
            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $filmUrl = "index.php?page=movie_search&id=" . htmlspecialchars($row['imdb_id']);  // Création de l'URL

                echo "<a href='$filmUrl' class='w-64 h-96 group relative flex flex-col text-white hover:scale-105 hover:shadow transition duration-700 cursor-pointer'>";
                echo "<img class='rounded-lg object-cover' src='https://image.tmdb.org/t/p/w500" . htmlspecialchars($row['poster_url']) . "'><br>";
                echo "<div class='opacity-0 rounded-lg bg-opacity-70 p-2  group-hover:opacity-100 bg-black transition duration-300 absolute inset-0 flex flex-col gap-2 justify-end text-white'>";
                echo "<h2 class='w-64 text-xl leading-tight pr-2 absolute top-12'>" . htmlspecialchars($row['title']) . "</h2>";
                echo "<form action='php/wishlist_delete.php' method='post' class='absolute top-0 right-0 mt-2 mr-2'>";
                echo "<input type='hidden' name='movie_id' value='" . $row['id'] . "'>";
                echo "<button type='submit'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' class='hover:scale-125 transition-all' height='24' viewBox='0 -960 960 960' width='24' fill='none'>";
                echo "<path d='M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z' stroke='red' stroke-width='20' />";
                echo "</svg>";
                echo "</button>";
                echo "</form>";
                echo "</div>";
                echo "</a>"; // Fin de la balise <a>
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<div id="messageModal" class="fixed z-10 inset-0 overflow-y-auto top-[40%] left-[50%] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

  <!-- Modal content -->
<div class="fixed z-10 inset-0 overflow-y-auto flex items-center justify-center">
    <div class="bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all w-[30%] left-[50%]">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="text-center">
                <h3 class="font-medium text-gray-900" id="modal-title">Notification</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500" id="modalText"></p>
                </div>
            </div>
            <div class="px-4 py-3 sm:flex sm:flex-row-reverse">
                <button type="button" id="closeModalButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm mx-auto">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>


  

</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById("messageModal");
    var closeButton = document.getElementById("closeModalButton");

    <?php if (isset($_SESSION['error_message']) || isset($_SESSION['success_message'])): ?>
        document.getElementById("modalText").innerText = "<?php 
            echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : $_SESSION['success_message'];
            unset($_SESSION['error_message']);
            unset($_SESSION['success_message']);
        ?>";
        modal.style.display = "block";
    <?php endif; ?>

    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

</script>

<script>
    document.getElementById('genre').addEventListener('change', function() {
        this.form.submit();
    });
</script>