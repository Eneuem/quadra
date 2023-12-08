<?php include"../php/start.php"; ?>
<div class="flex lg:flex-row flex-col">
    <!-- Sidebar -->
    <div class="w-80 bg-gray-200 text-base-content min-h-screen">
        <ul class="p-4">
            <li><a href="main.php?page=add" class="block p-2 hover:bg-base-300 rounded">Ajouter film</a></li>
            <li><a href="main.php?page=list" class="block p-2 hover:bg-base-300 rounded">Voir liste</a></li>
            <li><a href="#" class="block p-2 hover:bg-base-300 rounded">Modifier films</a></li>
            <!-- Ajouter d'autres éléments de la barre latérale ici -->
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 flex items-center justify-center">
        <?php 
         $page = isset($_GET['page']) ? $_GET['page'] : 'default';

         switch($page) 
         {
        case 'add':
            include("bo_add_movie.php");
            break;
        case 'list':
            include("bo_movie_list.php");
            break;
        }
         ?>
        <label for="sidebar-toggle" class="btn btn-primary lg:hidden">Open drawer</label>
    </div>
</div>

<!-- Bouton de basculement de la barre latérale pour les petits écrans -->
<input type="checkbox" id="sidebar-toggle" class="hidden">
