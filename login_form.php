<?php
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<!-- ... -->
<div x-data="{ step: 1 }">
    <!-- Étape 1 -->
    <div x-show="step === 1">
        <div class="h-full flex flex-col items-center justify-center">
            <h2 class="">Step 1 : Login and Password</h2>
            <!-- Champ de nom d'utilisateur (login) -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-600">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Champ de mot de passe avec bouton pour afficher/masquer -->
            <div class="mb-4 relative">
                <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md pr-10">
                <button id="togglePassword" class="absolute inset-y-0 right-0 mt-1 mr-2 flex items-center focus:outline-none">
                    <!-- Utilisez une icône pour afficher/masquer le mot de passe -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                    </svg>
                </button>
            </div>
            <button @click="step = 2" class="bg-blue-500 text-white px-4 py-2 rounded-md">Suivant</button>
        </div>
    </div>

    Étape 2
    <div x-show="step === 2">
        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <h2 class="text-lg font-semibold mb-4">Étape 2 : Détails de connexion</h2>
            <!-- Ajoutez vos champs de formulaire ici -->
            <div class="flex justify-between">
                <button @click="step = 1" class="text-blue-500">Précédent</button>
                <button @click="step = 3" class="bg-blue-500 text-white px-4 py-2 rounded-md">Suivant</button>
            </div>
        </div>
    </div>

    <!-- Étape 3 -->
    <div x-show="step === 3">
        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <h2 class="text-lg font-semibold mb-4">Étape 3 : Récapitulatif</h2>
            <!-- Affichez un récapitulatif des informations du formulaire -->

            <div class="flex justify-between">
                <button @click="step = 2" class="text-blue-500">Précédent</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-md">Soumettre</button>
            </div>
        </div>
    </div>
</div>


<!-- ... -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('multistepForm', () => ({
            step: 1,
        }));
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('passwordToggle', () => ({
            showPassword: false,
        }));
    });
</script>