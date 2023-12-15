<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_power'] == 0) {
    header('Location: ../404.php');
    exit;
}
