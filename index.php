<?php if (!isset($_SESSION)) {
    session_start();
}
?>

<?php include("php/start.php"); ?>

<body>
    <?php
    include("header.php");

    $page = isset($_GET['page']) ? $_GET['page'] : 'default'; // Page par défaut si le paramètre 'page' n'est pas défini
    $id = isset($_GET['id']) ? $_GET['id'] : null; // ID IMDb (si présent)

    switch ($page) {
        case 'wishlist':
            include("php/wishlist_show.php");
            break;
        case 'movie_search':
            include("php/page_film.php");
            break;
        case 'login':
            include("php/login.php");
            break;
        case 'signup':
            include("php/page_signup.php");
            break;
        case 'users':
            include("php/page_profil.php");
            break;
        case 'privacy':
            include("php/page_privacy_policy.php");
            break;
        case 'about':
            include("php/page_about.php");
            break;
        case 'contact':
            include("php/page_contact.php");
            break;
        case 'subscription':
            include("php/page_sub.php");
            break;
        case 'seances':
            include("php/page_seance.php");
            break;
        case 'reset':
            include("php/reset/new_pass_req.php");
            break;
        case 'verify':
            include("php/reset/verify_secret_question_form.php");
            break;
        case 'reset_password':
            include("php/reset/password_form.php");
            break;
        case 'new_movie':
            include("php/comp/new.php");
            break;
        default:
            include("php/page_main.php");
    }


    include("footer.php"); ?>

</body>

</html>