<?php
# Sets the page name
define('PAGE_NAME', 'Login Page');

# Starts the session
session_start();

# Checks if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    # Redirects to the index page
    header('Location: index.php');
    exit;
}

# Checks if the request method is post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Checks if the username and password was provided
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        # Redirects to the login page
        header('Location: login.php');
        exit;
    }

    # Gets the username and password from the post
    $username = $_POST['username'];
    $password = $_POST['password'];

    # Checks if the username or password is empty
    if (empty($username) || empty($password)) {
        # Redirects to the login page
        header('Location: login.php');
        exit;
    }

    # Ensures the database connection is required
    require_once 'includes/storage.php';

    # Removes any HTML tags from the username and password
    $username = strip_tags($username);
    $password = strip_tags($password);

    # Escapes the username and password
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    # Gets the user from the database
    $login_query = "
        SELECT ID, username, password
        FROM users
        WHERE username = '$username'
    ";

    # Runs the query
    $login_result = mysqli_query($connection, $login_query);

    # Checks if the query was successful
    if (!$login_result) {
        die('Login query failed: ' . mysqli_error($connection));
    }

    # Loops through the results
    while ($row = mysqli_fetch_assoc($login_result)) {
        # Checks if the password matches
        if (password_verify($password, $row['password'])) {
            # Sets the session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['ID'];

            # Redirects to the index page
            header('Location: index.php');
            exit;
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes/header.php'; ?>
        <!-- System Form Validation Script -->
        <script defer src="includes/JS/system_form.js"></script>
    </head>
    <body>
        <header class="text-center">
            <!-- Page Title -->
            <h1 class="display-4">Login Form</h1>
            <!-- Page Lead -->
            <lead>Enter your account details below</lead>
        </header>
        <main>
            <div>
                <!-- Login Form -->
                <form id="system-form" action="" method="POST">
                    <!-- Username Input -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" autocomplete="username" pattern="[A-z-0-9]{5,}" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" autocomplete="current-password" pattern="[A-z-0-9]{5,}" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <!-- Submit Button -->
                    <button disabled id="submit_button" type="button" class="btn btn-primary" onclick="submitForm()">
                        Submit
                    </button>
                </form>
            </div>
        </main>
    </body>
</html>
