<?php
include 'db_connect.php';
?>

<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto my-10">
        <form id="registrationForm">
            <!-- Step 1: Profile -->
            <div id="step1" class="step">
                <div>
                    <label for="login" class="font-bold mb-1 text-gray-700 block">Login</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your login...">
                    <input type="text" id="pseudo" name="pseudo" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your login...">
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your login...">
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
                    <input type="hidden" name="userpower" value="0">
                </div>
                <div class="mt-5 flex justify-between">
                    <button type="button" onclick="nextStep(2)" class="py-2 px-5 rounded-lg shadow-sm text-gray-600 bg-white hover:bg-gray-100 font-medium">Previous</button>
                    <input type="submit" value="Register" class="py-2 px-5 rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 font-medium">
                </div>
            </div>
        </form>
    </div>
</div>

<script src="js/signup.js"></script>

</body>
</html>
