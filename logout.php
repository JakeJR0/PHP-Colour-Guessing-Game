<?php
define('PAGE_NAME', 'Logout');

session_start();

if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true) {
        $_SESSION['logged_in'] = false;
        $_SESSION['username'] = null;
        $_SESSION['user_id'] = null;
    }
}

header("Location: login.php");
?>