<!-- Assurez-vous que cette page est accessible seulement si l'utilisateur a passé la première étape -->
<form action="php/reset/verify_secret_question.php" method="post">
    <div>
        <label for="secret_answer">Your Secret Question: <?php echo $_SESSION['secret_question']; ?> ?</label>
        <input type="text" id="secret_answer" name="secret_answer" required>
    </div>
    <button type="submit" name="verify_answer">Verify Answer</button>
</form>
