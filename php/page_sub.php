<body class="common-background font-sans">

  <div class="flex flex-wrap justify-center">
    <!-- Basic Plan -->
    <div
      class="max-w-md mx-4 my-8 bg-gray-900 text-white rounded-xl p-8 shadow-md w-full sm:w-1/2 md:w-1/3 lg:w-1/4 border-2 border-yellow-400">
      <h2 class="text-2xl font-semibold mb-2 py-1 bg-yellow-400 rounded-xl flex items-center justify-center">Basic Plan
      </h2>

      <h3 class="text-2xl font-bold pb-6 mt-4 border-b-2">20 €</h3>

      <p class=" mb-2 font-semibold py-6 ">Parfait pour ceux qui apprécient une expérience cinématographique à moindre
        coût.
        Accédez jusqu'à 2 films par mois parmi notre sélection soigneusement choisie.
        Idéal pour les cinéphiles occasionnels à la recherche d'une option économique.</p>
      <!-- Subscription Form for Basic Plan -->
      <form action="#" method="POST">
        <!-- Form fields go here -->
        <!-- ... -->
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl mt-10 ">Subscribe</button>



      </form>
    </div>


    <!-- Premium Plan -->
    <div
      class="max-w-md mx-4 my-8 bg-yellow-400  rounded-xl p-8 shadow-md w-full sm:w-1/2 md:w-1/3 lg:w-1/4 border-2 border-gray-200">
      <h2
        class="text-2xl font-semibold text-yellow-400 mb-2 py-1 bg-gray-900 rounded-xl flex items-center justify-center">
        Premium Plan
      </h2>
      <h3 class="text-2xl font-bold pb-6 mt-4 text-red-700 border-b-2 ">55 €</h3>

      <p class=" mb-2 font-semibold py-6 ">Rehaussez votre expérience cinématographique avec un accès illimité à tous
        les films de notre cinéma.
        Profitez des dernières sorties, des classiques et d'un contenu exclusif à tout moment.
        Recommandé pour les amateurs de cinéma qui veulent profiter pleinement de toute la gamme du divertissement
        cinématographique.</p>
      <!-- Subscription Form for Basic Plan -->
      <form action="#" method="POST">
        <!-- Form fields go here -->
        <!-- ... -->
      <?= include '../php-stripes/premium/payement.php';?>


      </form> 
    </div>

  </div>
  </div>

</body>