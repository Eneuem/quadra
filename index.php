
<?php include("php/start.php"); ?>
<body>
    <?php 
    include("header.php");
    
    $page = isset($_GET['page']) ? $_GET['page'] : 'default';

    switch($page) 
    {
    case 'wishlist':
        include("php/page_wishlist.php");
        break;
    case 'categories':
        include("php/page_categories.php");
        break;
    case 'random_movie':
        include("php/page_film.php");
        break;
    case 'login':
        include("php/login.php");
        break;
    case 'signup':
        include("php/page_signup.php");
        break;
    case 'users':
        include("php/profile_page.php");
        break;
    default:
        include("php/page_film.php");
    }
    

    include("footer.php"); ?>

</body>

</html>