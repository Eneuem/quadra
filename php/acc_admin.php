<?php if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("Location: login.php");
  exit;
}

include("meta.php");
?>

<div class="min-h-full">
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img class="h-8 w-8" src="img/favicon_cryptobel.png" alt="Cryptobel">
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="index.php" id="tab-view" target="_blank" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Voir le site</a>
              <a href="#" id="tab-modifier" class="link-modifier bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">FAQ'S</a>
              <a href="#" id="tab-contact" class="link-contact text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Contact</a>
              <a href="#" id="tab-partners" class="link-partners text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Partenaires</a>
              <a href="logout.php" id="tab-signout" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Déconnexion</a>
            </div>
          </div>
        </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <button type="button" class="menu-toggle relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!-- Menu closed -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Menu open -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <a href="index.php" id="mobile-view" target="_blank" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Voir le site</a>
        <a href="#" id="mobile-modifier" class="link-modifier bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Modifier</a>
        <a href="#" id="mobile-contact" class="link-contact text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Contact</a>
        <a href="#" id="mobile-partners" class="link-partners text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Partenaires</a>
      </div>
      <div class="border-t border-gray-700 pb-3 pt-4">
        <div class="mt-3 space-y-1 px-2">
          <a href="logout.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Déconnexion</a>
        </div>
      </div>
    </div>
  </nav>

  <header class="bg-white shadow">
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
  <h1 id="page-title" class="text-3xl font-bold tracking-tight text-gray-900">Gestion des FAQ's</h1>
</div>
  </header>
  <main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" id="form-admin">
        <?php include("form.php"); ?>
    </div>
    <div class="hidden mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" id="contact-admin">
        <?php include("contact_admin.php"); ?>
    </div>
    <div class="hidden mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" id="partners-admin">
        <?php include("edit_partners.php"); ?>
    </div>
  </main>
</div>





  
    <?php include("script.php"); ?>
    <script src="js/admin.js"></script>





    
</body>
</html>

