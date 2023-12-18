<div class="text-center bg-slate-950 h-screen mt-4 rounded-md flex flex-col justify-center items-center">
    <h1 class="text-lg leading-6 font-medium text-gray-300">Reset Password</h1>
    <div class="mt-2 px-7 py-3">
        <!-- Insert error or confirmation messages here if needed -->
        <form action="php/reset/reset_password.php" method="post">
            <div class="mb-4">
                <label for="new_password" class="text-gray-300">New Password:</label>
                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="new_password" name="new_password" required>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" name="reset_password" class="bg-blue-700 hover:bg-blue-800 text-white font-bold mb-5 py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
