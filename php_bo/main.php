<?php 
session_start();
include 'start.php'; 
include 'bo_check.php';?>

<?php $page = $_GET['page'] ?? 'default';

$titleMap = [
  'default' => 'Liste de films',
  'list' => 'Liste des utilisateurs',
  'add' => 'Ajouter un film',
  'featured' => 'Ajouter un film en vedette',
  'seance' => 'Ajouter une séance',
  'listseance' => 'Liste des séances',
  'editseance' => 'Modifier une séance',
  // Ajoutez ici d'autres cas
];

$title = $titleMap[$page];
?>

<body class="font-sans bg-slate-950">

  <!-- Sidebar -->
  <div class="flex h-screen bg-slate-950 text-gray-300">
    <div class="w-64">
      <!-- Sidebar Content -->
      <div class="p-4">
        <h1 class="text-2xl font-bold mb-4 text-yellow-400 text-center">Dashboard</h1>
        <!-- Add your sidebar links here -->
        <ul class="text-center w-full">
          <li class="mb-2"><a href="main.php" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'default' ? 'active-link' : ''; ?>">Home</a></li>
          <li class="mb-2"><a href="main.php?page=featured" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'featured' ? 'active-link' : ''; ?>">Films en Vedette</a></li>
          <li class="mb-2"><a href="main.php?page=add" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'add' ? 'active-link' : ''; ?>">Ajouter un film</a></li>
          <li class="mb-2"><a href="main.php?page=seance" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'seance' ? 'active-link' : ''; ?>">Ajouter une séance</a></li>
          <li class="mb-2"><a href="main.php?page=sortie" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'sortie' ? 'active-link' : ''; ?>">Ajouter une sortie</a></li>
          <li class="mb-2"><a href="main.php?page=listseance" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'listseance' ? 'active-link' : ''; ?>">Voir les séances</a></li>
          <li class="mb-2"><a href="main.php?page=list" class="text-gray-300 px-6 hover:text-white <?php echo $page == 'list' ? 'active-link' : ''; ?>">Accounts</a></li>
          <br>
          <li class="mb-2"><a href="php/logout.php" class="text-gray-300 px-6 hover:text-white">Logout</a></li>
          <li class="mb-2"><a href="../index.php" target="_blank" class="text-gray-300 px-6 hover:text-white">Voir le site</a></li>
          <button onclick="goBack()">Retour</button>
        </ul>
      </div>
    </div>


    <div class="flex-1 flex flex-col overflow-hidden">

      <header class="bg-slate-950 text-gray-300 ">

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

            switch ($page) {
              case 'add':
                include("bo_add_movie.php");
                break;
              case 'list':
                include("view_users.php");
                break;
              case 'movieDetails':
                include("barre_resultat.php");
                break;
              case 'movieDBDetails':
                include("bo_view_movie.php");
                break;
              case 'featured':
                include("bo_featured_movies_form.php");
                break;
              case 'seance':
                include("bo_add_seance_form.php");
                break;
              case 'listseance':
                include("bo_manage_seance.php");
                break;
              case 'editseance':
                include("edit_seance.php");
                break;
              case 'sortie':
                include("bo_new_movies_form.php");
                break;
              default:
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