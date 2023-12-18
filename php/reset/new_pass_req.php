<div class="text-center bg-slate-950 h-screen mt-4 rounded-md flex flex-col justify-center items-center">
    <h1 class="text-lg leading-6 font-medium text-gray-300">Request Password Reset</h1>
    <div class="mt-2 px-7 py-3">
        <!-- Insérez ici les messages d'erreur ou de confirmation si nécessaire -->
        <form action="php/reset/password_reset_request.php" method="post">
            <div class="mb-4">
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="mb-4">
                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" name="request_reset" class="bg-blue-700 hover:bg-blue-800 text-white font-bold mb-5 py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Request Reset
                </button>
            </div>
        </form>
    </div>
</div>

