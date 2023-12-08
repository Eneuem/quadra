    function nextStep(step) {
        document.querySelectorAll('.step').forEach(function(div) {
            div.classList.add('hidden');
        });
        document.getElementById('step' + step).classList.remove('hidden');

        if (step === 3) {
            document.getElementById('displayLogin').textContent = document.getElementById('username').value; 
            document.getElementById('displayEmail').textContent = document.getElementById('email').value;
        }
    }
    
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var username = document.getElementById('username').value; 
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var formData = new FormData();
    formData.append('register', '1'); // Ajouter 'register'
    formData.append('userpower', '0'); // Ajouter 'register'
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);

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
