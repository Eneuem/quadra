 <form action="wishlist_process.php" method="post">
        <label for="movie_id">ID du Film:</label>
        <input type="text" id="movie_id" name="movie_id" required>
        <input type='hidden' name='user_id' value='<?php echo $_SESSION['user_id']; ?>'>
        <input type="submit" value="Ajouter à la Wishlist">
    </form>