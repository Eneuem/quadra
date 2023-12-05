<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre wishlist.";
    exit; // Arrête l'exécution du script si l'utilisateur n'est pas connecté
}
?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="w-full h-screen bg-slate-950 flex flex-col p-10 justify-evenly items-center">
    <svg xmlns="http://www.w3.org/2000/svg" height="150" viewBox="0 -960 960 960" width="150">
        <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z" FILL="white" />
    </svg>


    <div class="text-xl text-gray-300 flex flex-col">
        <div class="flex flex-col gap-4">
            <p>
                Username : <span id="username" onclick="editField('username')" class="cursor-pointer"><?php echo $_SESSION['username']; ?></span>
            </p>
            <p>
                Email : <span id="email" onclick="editField('email')" class="cursor-pointer"><?php echo $_SESSION['email']; ?></span>
            </p>
            <p>
                Password : <span id="password" onclick="editField('password')" class="cursor-pointer">********</span>
            </p>
        </div>
        <button type="button" class="relative top-10  w-56 text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete Your Account</button>
    </div>
</div>

<script>
    function editField(field) {
        var currentValue = document.getElementById(field).innerText;

        // Créer un champ d'entrée
        var inputField = document.createElement("input");
        inputField.value = currentValue;
        inputField.className = "border rounded p-1 text-black "; // Ajoutez les classes Tailwind nécessaires ici

        // Remplacer le texte par le champ d'entrée
        document.getElementById(field).innerText = '';
        document.getElementById(field).appendChild(inputField);

        // Ajouter un événement pour sauvegarder les changements lorsqu'on appuie sur Enter
        inputField.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                saveChanges(field, inputField.value);
            }
        });

        // Focus sur le champ d'entrée
        inputField.focus();
    }

    function saveChanges(field, newValue) {
        // Vous pouvez utiliser AJAX ici pour envoyer les nouvelles valeurs au serveur et les mettre à jour en base de données
        // En supposant que vous avez une page de traitement appelée update_profile.php

        // Exemple d'utilisation de XMLHttpRequest pour effectuer une requête AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_profile.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Construire les données à envoyer
        var data = "field=" + field + "&value=" + encodeURIComponent(newValue);
        xhr.send(data);

        // Mettre à jour la valeur dans le DOM sans recharger la page
        document.getElementById(field).innerText = newValue;
    }
</script>