<?php
# Starts the session
session_start();

# Checks if the logged in is set in the session
if (isset($_SESSION['logged_in'])) {
    # Checks if the user is logged in
    if ($_SESSION['logged_in'] == true) {
        # Resets the variables in the session related to the logged in user
        $_SESSION['logged_in'] = false;
        $_SESSION['username'] = null;
        $_SESSION['user_id'] = null;
    }
}

# Redirects to the login page
header("Location: login.php");
?>