<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    echo "Veuillez vous connecter pour voir votre profil.";
    exit; 
}

include 'db_connect.php';

// Récupération des informations de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
$stmt->bindParam(':userid', $_SESSION['userid']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="w-full h-screen bg-slate-950 flex flex-col p-10 justify-evenly items-center">
    <div class="text-xl text-gray-300 flex flex-col items-center justify-center">
        <div class="flex flex-col gap-4">
            <p>Username : <span id="username" class="cursor-pointer" onclick="editField('username')"><?= htmlspecialchars($user['username']); ?></span></p>
            <p>Email : <span id="email" class="cursor-pointer" onclick="editField('email')"><?= htmlspecialchars($user['email']); ?></span></p>
            <p>Password : <span id="password" class="cursor-pointer" onclick="editField('password')">*********</span></p>
        </div>
        <button type="button" id="saveChanges" class="btn">Save Changes</button>
        <button type="button" onclick="deleteAccount()" class="btn">Delete Your Account</button>
    </div>
</div>

<script>
    function editField(field) {
        var currentValue = document.getElementById(field).innerText;
        var inputField = document.createElement("input");
        inputField.type = field === 'password' ? 'password' : 'text';
        inputField.value = currentValue;
        inputField.id = field + 'Input';
        document.getElementById(field).innerHTML = '';
        document.getElementById(field).appendChild(inputField);
    }

    document.getElementById('saveChanges').addEventListener('click', function() {
        var username = document.getElementById('usernameInput') ? document.getElementById('usernameInput').value : null;
        var email = document.getElementById('emailInput') ? document.getElementById('emailInput').value : null;
        var password = document.getElementById('passwordInput') ? document.getElementById('passwordInput').value : null;

        // Envoyer les données mises à jour au serveur
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_profile.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        xhr.send("username=" + username + "&email=" + email + "&password=" + password);
    });

    function deleteAccount() {
        if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ?")) {
            window.location.href = "delete_account.php";
        }
    }
</script>
