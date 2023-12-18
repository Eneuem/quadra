<div class="text-center bg-slate-950 h-screen mt-4 rounded-md flex flex-col justify-center items-center">
    <h1 class="text-lg leading-6 font-medium text-gray-300">Vérifier la Question Secrète</h1>
    <div class="mt-2 px-7 py-3">

        <form action="php/reset/verify_secret_question.php" method="post">
            <div class="mb-4">
                <label for="secret_answer" class="text-gray-300">Your Secret Question: <?php echo $_SESSION['secret_question']; ?> ?</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="secret_answer" name="secret_answer" required>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" name="verify_answer" class="bg-blue-700 hover:bg-blue-800 text-white font-bold mb-5 py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Vérifier la Réponse
                </button>
            </div>
        </form>
    </div>
</div>
