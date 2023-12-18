<?php
include 'db_connect.php';
?>

<div class="w-full h-screen bg-slate-950 mt-4 rounded-md flex flex-col justify-center items-center">
    <form id="registrationForm" class="w-1/3" onsubmit="return validateForm()">
        <div class="mb-5">
            <label for="login" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Your username</label>
            <input type="text" name="username" id="username" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="enter your username" required>
        </div>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Your email</label>
            <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="name@gmail.com" required>
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Your password</label>
            <input type="password" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="enter your password" required>
        </div>
        <div class="mb-5">
            <label for="secret_question" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Your secret question</label>
            <select id="secret_question" name="secret_question" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                <option value="">Select a question</option>
                <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                <option value="What is the name of your primary school">What is the name of your primary school?</option>
                <option value="What was the first smartphone you had">What was the first smartphone you had ?</option>
                <option value="What is the name of your first love">What is the name of your first love?</option>
            </select>
        </div>
        <div class="mb-5">
            <label for="secret_answer" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Your answer</label>
            <input type="text" name="secret_answer" id="secret_answer" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Your answer" required>
        </div>


        <button type="submit" value="Register" id="submitBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>    </form>

</div>

<script>

</script>


<script src="js/signup.js"></script>

