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

    <div class="text-xl text-gray-300 flex flex-col items-center justify-center">
        <div class="flex flex-col gap-4">
            <p>
                Username : <span id="username" class="cursor-pointer">
                    <?php echo $_SESSION['username']; ?>
                    <i class="fas fa-pencil-alt" onclick="editField('username')"></i>
                </span>
            </p>
            <p>
                Email :
                <span id="email" class="cursor-pointer">
                    <?php echo $_SESSION['email']; ?>
                    <i class="fas fa-pencil-alt" onclick="editField('email')"></i>
                </span>
            </p>
            <p>
                Password : <span id="password" class="cursor-pointer">
                    <?php echo $_SESSION['password']; ?>
                    <i class="fas fa-pencil-alt" onclick="editField('password')"></i>
                </span>
            </p>
        </div>
        <button type="button" id="saveChanges" onclick="saveChanges()" class="relative top-10  w-56 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900">Save Changes</button>
        <button type="button" class="relative top-10  w-56 text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete Your Account</button>
    </div>
</div>

<script>
    function editField(field) {
        var currentValue = document.getElementById(field).innerText;
        var inputField = document.createElement("input");
        inputField.value = currentValue;
        inputField.className = "border rounded p-1 text-black ";
        document.getElementById(field).innerText = '';
        document.getElementById(field).appendChild(inputField);
        var saveChangesButton = document.getElementById('saveChanges');
        // Ajoutez un gestionnaire de clic au bouton saveChanges
        saveChangesButton.addEventListener('click', function() {
            saveChanges(field, inputField.value);
        });
        inputField.focus();
    }

    function saveChanges(field, newValue) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_profile.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var data = "field=" + field + "&value=" + encodeURIComponent(newValue);
        xhr.send(data);
        document.getElementById(field).innerText = newValue;
        console.log("Changements sauvegardés pour le champ " + field + ": " + value);
    }
</script>