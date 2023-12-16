<body class="common-background font-sans">

  <div class="flex flex-wrap justify-center items-center min-h-screen">
    <!-- Basic Plan -->
    <div class="max-w-md mx-4 my-6 p-8 bg-gray-800 text-white rounded-xl shadow-md w-full sm:w-1/2 md:w-1/3 lg:w-1/4 border-2 border-gray-400">

      <h2 class="text-2xl font-semibold mb-2 py-1 bg-yellow-500 rounded-xl flex items-center justify-center">Basic Plan</h2>

      <h3 class="text-2xl font-bold pb-6 mt-4 border-b-2">20 €</h3>

      <p class="mb-2 font-semibold py-6">Perfect for those who enjoy a cinematic experience on a budget.
        Access up to 2 movies per month from our carefully curated selection.
        Ideal for casual moviegoers looking for a cost-effective option.</p>
      <!-- Subscription Form for Basic Plan -->
      <form action="#" method="POST">
        <!-- Form fields go here -->
        <!-- ... -->
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl mt-10">Subscribe</button>
      </form>
    </div>

    <!-- Premium Plan -->
    <div class="max-w-md mx-4 my-6 bg-yellow-500 rounded-xl p-8 shadow-md w-full sm:w-1/2 md:w-1/3 lg:w-1/4 border-2 border-gray-200">

      <h2 class="text-2xl font-semibold text-yellow-400 mb-2 py-1 bg-gray-800 rounded-xl flex items-center justify-center">Premium Plan</h2>

      <h3 class="text-2xl font-bold pb-6 mt-4 text-red-700 border-b-2">55 €</h3>

      <p class="mb-2 font-semibold py-6">Elevate your movie-watching experience with unlimited access to all movies in
        our cinema.
        Enjoy the latest releases, classics, and exclusive content anytime you want.
        Recommended for avid movie lovers who want the full spectrum of cinematic entertainment.</p>
      <!-- Subscription Form for Basic Plan -->
      <form action="#" method="POST">
        <!-- Form fields go here -->
        <!-- ... -->
        <?= include 'php-stripes/premium/payement.php'; ?>
      </form>
    </div>

  </div>
</body>