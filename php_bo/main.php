<?php include"../php/start.php"; ?>

<?php $page = $_GET['page'] ?? 'default';

$titleMap = [
    'default' => 'Liste de films',
    'list' => 'Liste des utilisateurs',
    'add' => 'Ajouter un film',
    // Ajoutez ici d'autres cas
];

$title = $titleMap[$page];
?>

<body class="font-sans bg-gray-100">

<!-- Sidebar -->
<div class="flex h-screen bg-gray-900 text-yellow-400">
  <div class="w-64 bg-gray-700">
    <!-- Sidebar Content -->
    <div class="p-4">
      <h1 class="text-2xl font-bold mb-4 text-yellow-400 text-center">Dashboard</h1>
      <!-- Add your sidebar links here -->
      <ul class="text-center w-full">
        <li class="mb-2"><a href="main.php" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'default' ? 'active-link' : ''; ?>">Home</a></li>
        <li class="mb-2"><a href="main.php?page=add" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'add' ? 'active-link' : ''; ?>">Ajouter un film</a></li>
        <li class="mb-2"><a href="main.php?page=list" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'list' ? 'active-link' : ''; ?>">Accounts</a></li>
        <li class="mb-2"><a href="../index.php" target="_blank" class="text-gray-300 px-6 hover:text-white">Voir le site</a></li>
        <button onclick="goBack()">Retour</button>
      </ul>
    </div>
  </div>


  <div class="flex-1 flex flex-col overflow-hidden">

    <header class="bg-yellow-400 text-gray-900 ">

      <div class="p-4">
        <h1 class="text-2xl font-bold text-center">
          <?php echo $title; ?></h1>
      </div>
    </header>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-900">

      <div class="p-4">

        <p> 
        <?php 
         $page = isset($_GET['page']) ? $_GET['page'] : 'default';

         switch($page) 
         {
        case 'add':
            include("bo_add_movie.php");
            break;
        case 'list':
            include("view_users.php");
            break;
        case 'movieDetails':
            include("barre_resultat.php"); 
            break;
        default :
            include("bo_movie_list.php");
            break;
        }
         ?>
        </p>

      </div>
    </main>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('ul li a'); // Cible tous les liens dans les éléments <li> de la liste <ul>

    tabs.forEach(tab => {
        if (tab.classList.contains('active-link')) {
            tab.classList.add('bg-gray-900', 'text-white');
            tab.classList.remove('text-gray-300', 'hover:bg-gray-700', 'hover:text-white');
        } else {
            tab.classList.add('text-gray-300', 'hover:bg-gray-700', 'hover:text-white');
            tab.classList.remove('bg-gray-900', 'text-white');
        }
    });
});

function goBack() {
    window.history.back();
}


</script>