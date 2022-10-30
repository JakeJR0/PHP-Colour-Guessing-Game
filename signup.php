<?php
# Sets the page name
define('PAGE_NAME', 'Registration');

# Starts the session
session_start();

# Checks if logged_in is set in the session
if (isset($_SESSION['logged_in'])) {
    # Checks if the user is logged in
    if ($_SESSION['logged_in'] == true) {
        # Redirects to the game page
        header("Location: game.php");
    }
}

# Checks if the request method is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Checks if username is set in the post
    if (!isset($_POST['username'])) {
        # Redirects to the signup page
        header("Location: signup.php");
    } elseif (!isset($_POST['password'])) {
        # Redirects to the signup page
        header("Location: signup.php");
    }

    # Gets the username from the post
    $username = $_POST['username'];
    # Gets the password from the post
    $password = $_POST['password'];

    # Checks if the username is empty
    if (empty($username)) {
        # Redirects to the signup page
        header("Location: signup.php");
    # Checks if the password is empty
    } elseif (empty($password)) {
        # Redirects to the signup page
        header("Location: signup.php");
    }

    # Ensures the storage.php is required

    require_once 'includes/storage.php';

    # Removes any HTML tags from the username and password
    $username = strip_tags($username);
    $password = strip_tags($password);

    # Escapes the username and password
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    # Hashes the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    # Adds the user to the database
    $query = "
    INSERT INTO users(username, password)
    VALUES ('$username', '$password')
    ";

    # Runs the query
    $result = mysqli_query($connection, $query);

    # Checks if the query was successful
    if ($result) {
        # Gets the user ID from the query
        $user_id = mysqli_insert_id($connection);

        # Sets the logged_in in the session
        $_SESSION['logged_in'] = true;
        # Sets the username in the session
        $_SESSION['username'] = $username;
        # Sets the user ID in the session
        $_SESSION['user_id'] = $user_id;

        # Redirects to the game page
        header("Location: game.php");
    } else {
        # Redirects to the signup page
        header("Location: signup.php");
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
            <h1 class="display-4">Signup Form</h1>
            <!-- Page Lead -->
            <lead>Choose your username wisely, you can only choose it once.</lead>
        </header>
        <main>
            <div>
                <!-- Signup Form -->
                <form id="system-form" action="" method="POST">
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" autocomplete="username" pattern="[A-z-0-9]{5,}" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <!-- Password -->
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
