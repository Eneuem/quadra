<?php
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<!-- ... -->
<style>
    .backdrop-blur-lg {
        backdrop-filter: blur(10px);
    }
</style>

<div class="w-full h-full flex flex-col items-center justify-center backdrop-blur-lg">
    <!-- Formulaire multistep -->
    <div x-data="{ step: 1 }" class="w-4/6 h-4/6 md:w-96 md:h-96 rounded-lg bg-white">
        <!-- Étape 1 -->
        <div x-show="step === 1" class="text-center">
            <div class="border shadow-lg w-full h-full rounded-lg p-10 flex flex-col justify-evenly md:justify-between">
                <h2 class="text-lg font-semibold mb-4">Step 1 : Login and Password</h2>
                <!-- Champ de nom d'utilisateur (login) -->
                <div class="mb-4">
                    <input type="text" placeholder="Login" id="username" name="username" class="required:border-red-500 mt-1 p-2 w-full border rounded-md text-lg" required>
                </div>

                <!-- Champ de mot de passe avec bouton pour afficher/masquer -->
                <div class="mb-4 relative">
                    <input type="password" placeholder="Password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md pr-10 text-lg">
                    <button id="togglePassword" onclick="toggleVisibility()" class="absolute inset-y-0 right-0 mt-1 mr-2 flex items-center focus:outline-none">
                        <!-- Utilisez une icône pour afficher/masquer le mot de passe -->
                        <svg id="visibility" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                            <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                        </svg>
                        <svg id="visibility_off" class="hidden" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                            <path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z" />
                        </svg>
                    </button>
                    </input>
                </div>
                <button @click="step = 2" class="bg-blue-500 text-white px-4 py-2 rounded-md">Next</button>
            </div>
        </div>

        <!-- Étape 2 -->
        <div x-show="step === 2" class="text-center">

            <!-- Ajoutez vos champs de formulaire ici -->
            <div class="border shadow-lg w-full h-full rounded-lg p-10 flex flex-col items-center justify-evenly md:justify-between">
                <h2 class="text-lg font-semibold mb-4">Étape 2 : Email</h2>
                <input type="email" placeholder="Email" id="email" name="email" class="mt-1 p-2 w-full border rounded-md pr-10 text-lg" required>
                <div class="flex w-full justify-evenly">
                    <button @click="step = 1" class="bg-blue-500 text-white px-4 py-2 rounded-md">Previous</button>
                    <button @click="step = 3" class="bg-blue-500 text-white px-4 py-2 rounded-md">Next</button>
                </div>

            </div>
        </div>

        <!-- Étape 3 -->
        <div x-show="step === 3" class="text-center">
            <div class="border shadow-lg w-full h-full rounded-lg p-10 flex flex-col items-center justify-evenly md:justify-between">
                <h2 class="text-lg font-semibold mb-4">Step 3 : Connexion Details</h2>
                <!-- Affichez un récapitulatif des informations du formulaire -->
                <p>Login : your login</p>
                <p>Password : your password</p>
                <p>Email : your email</p>
                <div class="flex justify-between">
                    <button @click="step = 2" class="bg-blue-500 text-white px-4 py-2 rounded-md">Previous</button>
                    <button class="bg-green-500 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('multistepForm', () => ({
            step: 1,
        }));
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('passwordToggle', () => ({
            showPassword: false,
        }));
    });

    let isVisibilityOn = true;

    function toggleVisibility() {
        let visibility = document.getElementById("visibility");
        let visibility_off = document.getElementById("visibility_off");

        if (isVisibilityOn) {
            visibility.style.display = "none";
            visibility_off.style.display = "block";
        } else {
            visibility.style.display = "block";
            visibility_off.style.display = "none";
        }

        isVisibilityOn = !isVisibilityOn;
    }


    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
</script>