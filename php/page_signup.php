
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

<?php
include 'db_connect.php';
?>

<div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto my-10">
        <form id="registrationForm">
            <!-- Step 1: Profile -->
            <div id="step1" class="step">
                <div>
                    <label for="login" class="font-bold mb-1 text-gray-700 block">Login</label>
                    <input type="text" id="pseudo" name="pseudo" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your login...">
                </div>
                <div class="mt-5">
                    <label for="email" class="font-bold mb-1 text-gray-700 block">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your email...">
                </div>
                <div class="mt-5 text-right">
                    <button type="button" onclick="nextStep(2)" class="py-2 px-5 rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 font-medium">Next</button>
                </div>
            </div>

            <!-- Step 2: Password -->
            <div id="step2" class="step hidden">
                <div>
                    <label for="password" class="font-bold mb-1 text-gray-700 block">Set up password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Your strong password...">
                </div>
                <div class="mt-5 flex justify-between">
                    <button type="button" onclick="nextStep(1)" class="py-2 px-5 rounded-lg shadow-sm text-gray-600 bg-white hover:bg-gray-100 font-medium">Previous</button>
                    <button type="button" onclick="nextStep(3)" class="py-2 px-5 rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 font-medium">Next</button>
                </div>
            </div>

            <!-- Step 3: Profile Details -->
            <div id="step3" class="step hidden">
                <div>
                    <!-- Display login and email as text -->
                    <div class="mb-5">
                        <span class="font-bold text-gray-700">Login: </span><span id="displayLogin"></span>
                    </div>
                    <div class="mb-5">
                        <span class="font-bold text-gray-700">Email: </span><span id="displayEmail"></span>
                    </div>
                    <input type="hidden" name="register" value="1">
                </div>
                <div class="mt-5 flex justify-between">
                    <button type="button" onclick="nextStep(2)" class="py-2 px-5 rounded-lg shadow-sm text-gray-600 bg-white hover:bg-gray-100 font-medium">Previous</button>
                    <input type="submit" value="Register" class="py-2 px-5 rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 font-medium">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function nextStep(step) {
        document.querySelectorAll('.step').forEach(function(div) {
            div.classList.add('hidden');
        });
        document.getElementById('step' + step).classList.remove('hidden');

        if (step === 3) {
            document.getElementById('displayLogin').textContent = document.getElementById('pseudo').value; 
            document.getElementById('displayEmail').textContent = document.getElementById('email').value;
        }
    }
    
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        event.preventDefault();
    
        var pseudo = document.getElementById('pseudo').value; 
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        var formData = new FormData();
        formData.append('pseudo', pseudo);
        formData.append('email', email);
        formData.append('password', password);
   
        fetch('inscription.php', {
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
            alert('Form submitted successfully!');
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error submitting form');
        });
    });
    
</script>

</body>
</html>
