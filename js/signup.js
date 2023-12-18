function validatePassword(password) {
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;
    return regex.test(password);
}

function validateForm() {
    var password = document.getElementById('password').value;
    if (!validatePassword(password)) {
        alert('Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et être d\'au moins 6 caractères.');
        return false;
    }
    return true;
}
    
    // function nextStep(step) {
    //     document.querySelectorAll('.step').forEach(function(div) {
    //         div.classList.add('hidden');
    //     });
    //     document.getElementById('step' + step).classList.remove('hidden');

    //     if (step === 3) {
    //         document.getElementById('displayLogin').textContent = document.getElementById('username').value; 
    //         document.getElementById('displayEmail').textContent = document.getElementById('email').value;
    //     }
    // }
    
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var username = document.getElementById('username').value; 
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var secret_question = document.getElementById('secret_question').value;
    var secret_answer = document.getElementById('secret_answer').value;

    var formData = new FormData();
    formData.append('register', '1'); // Ajouter 'register'
    formData.append('userpower', '0'); // Ajouter 'register'
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('secret_question', secret_question);
    formData.append('secret_answer', secret_answer);
    

    fetch('php/inscription.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        console.log('Success:', data); // Utiliser console.log pour voir la réponse du serveur
        alert('Response from server: ' + data); // Afficher la réponse du serveur
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting form: ' + error.message);
    });
});
