<?php
http_response_code(404);
?>
    <script src="https://cdn.tailwindcss.com"></script>
<div class="bg-gray-900 h-screen flex items-center justify-center">
  <div class="text-center flex flex-col items-center">
    <h1 class="text-4xl font-bold text-yellow-400 mb-8 animate-ping">Error 404</h1>

    <img id="image1" class="animate-bounce jumping-image h-64 w-full object-cover md:w-64" src="./img/error.png"
      alt="image1">

    <a href="#">
      <button
        class="bg-yellow-400 hover:bg-orange-500 text-white font-semibold px-6 py-3 rounded-md mb-6 transform hover:scale-110 transition-transform duration-300 ease-in-out">
        HOME
      </button>
    </a>

    <p class="text-xl text-yellow-400 mb-8 animate-pulse">Page not found</p>
  </div>
</div>
