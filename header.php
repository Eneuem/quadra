<?php
// Au début de votre fichier PHP
if (!isset($_SESSION)) {
    session_start();
}

// Vérifier l'ID de l'utilisateur

$userLoggedIn = isset($_SESSION['userid']) && $_SESSION['userid'] !== null;

// Obtenir l'URL
$currentUrl = $_SERVER['REQUEST_URI'];
?>
<style>
    .active-link {
        color: #aef359;
    }
</style>
<!-- Nav Container -->
<nav class="sticky top-0 mx-auto p-2  bg-slate-950 z-40">


    <!-- Flex Container For All Items -->
    <div class="flex items-center justify-between">

        <!-- Flex Container For Logo/Search -->
        <div class="flex items-center space-x-6">

            <!-- Logo -->
            <img src="./img/logo.png" class="w-10 h-10 bg-white rounded-full" alt="Quadra Logo" />

            <!-- Search -->
            <div>
                <form action="/search">
                    <div class="flex relative ">
                        <input type="text" name="q" class="w-full border h-10 shadow p-4 pl-10 pr-10 rounded-full placeholder:font-thin" placeholder="Find Movies & TV">
                        <button type="submit">
                            <svg class="text-yellow-400 h-5 w-5 absolute top-3 right-3 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Buttons Menu -->

        <div class="hidden items-center space-x-6 font-bold text-yellow-400 lg:flex">
            <div class=" hidden space-x-8 font-bold lg:flex">
                <a href="index.php?page=wishlist" class="<?php echo (strpos($currentUrl, 'page=wishlist') !== false) ? 'active-link' : ''; ?>">Wishlist</a>
                <a href="index.php?page=categories" class="<?php echo (strpos($currentUrl, 'page=categories') !== false) ? 'active-link' : ''; ?>">Categories</a>
                <a href="index.php?page=random_movie" class="<?php echo (strpos($currentUrl, 'page=random_movie') !== false) ? 'active-link' : ''; ?>">Random Movie</a>
            </div>
            <a href="#" class="text-yellow-400link-active cursor-default">|</a>



            <div class="items-center space-x-6 font-bold text-yellow-400 lg:flex">
                <div class="relative lg:flex items-center space-x-6">
                    <a href="index.php?page=login">
                        <div id="loginBtn" class="hover:text-lime-100">Login</div>
                    </a>
                    <a href="index.php?page=signup" id="signupBtn" data-page="signup" class="dynamic-load px-4 py-1 font-bold text-lime-100 bg-yellow-400 rounded-xl hover:opacity-70">Sign Up</a>
                    <div id="userName" class="hidden hover:text-lime-100 cursor-pointer"><?php echo $_SESSION['username']; ?></div>
                    <div id="userIcon">
                        <svg class="hidden text-yellow-400 h-8 w-8 top-3 fill-current" xmlns="http://www.w3.org/2000/svg" height="34" viewBox="0 -960 960 960" width="24">
                            <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"></path>
                        </svg>
                    </div>
                    <!-- User Menu -->
                    <div id="userMenu" class="hidden absolute right-0 top-10 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PROFILE</a>

                        <?php if (isset($_SESSION['user_power']) && $_SESSION['user_power'] != 0) : ?>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">SUPER-ADMIN</a>
                        <?php endif; ?>

                        <a href="php/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">LOGOUT</a>
                    </div>
                </div>
            </div>


            <!-- Hamburger Button -->
            <button id="menu-btn" class="block hamburger lg:hidden focus:outline-none" type="button">
                <span class="hamburger-top"></span>
                <span class="hamburger-middle"></span>
                <span class="hamburger-bottom"></span>
            </button>
        </div>


        <!-- Mobile Menu -->
        <div id="menu" class="absolute hidden p-6 bg-gray-800 left-6 right-6 top-20 z-50">

            <div class="flex flex-col items-center justify-center w-full space-y-6 font-bold text-yellow-400 rounded-md">
                <!-- <div class=" items-center justify-center space-x-2"> -->
                <a href="#" id="signupBtn-mobile" class="w-full text-center rounded-md px-full py-1  bg-yellow-400 text-lime-100">Sign Up</a>
                <a href="#" id="loginBtn-mobile" class="w-full text-center rounded-md">Login</a>
                <!-- </div> -->
                <div id="userName-mobile" class="hidden hover:text-lime-100"><?php echo $_SESSION['username']; ?></div>
                <div id="userIcon-mobile">
                    <svg class="hidden text-yellow-400 h-8 w-8 top-3 fill-current" xmlns="http://www.w3.org/2000/svg" height="34" viewBox="0 -960 960 960" width="24">
                        <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"></path>
                    </svg>
                </div>


                <a href=" #" class="w-full text-center ">Categories</a>
                <a href="#" class="w-full text-center">Wishlist</a>
                <a href=" #" class="w-full text-center ">Random Movie</a>

            </div>
        </div>


        <!-- <section class="bg-yellow-400 rounded-xl">
        <div class="py-4 px-2 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold leading-tight text-gray-900 ">Start your free trial today</h2>
                <p class="mb-6 text-white md:text-lg">Try quadra streaming for 30 days free. No credit card required.</p>

                <a href="#" class="text-yellow-400 bg-blue-800 hover:opacity-70 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">Free trial for 30 days</a>
            </div>
        </div>
    </section> -->



</nav>




<?php include("js/header_script.php"); ?>

<script>
    const btn = document.getElementById("menu-btn");
    const menu = document.getElementById("menu");

    btn.addEventListener("click", navToggle);

    // Toggle Mobile Menu
    function navToggle() {
        btn.classList.toggle("open");
        menu.classList.toggle("flex");
        menu.classList.toggle("hidden");
    }
</script>