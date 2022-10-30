<?php
define('PAGE_NAME', 'Registration');

session_start();

if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true) {
        header("Location: game.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username'])) {
        header("Location: signup.php");
    } elseif (!isset($_POST['password'])) {
        header("Location: signup.php");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        header("Location: signup.php");
    } elseif (empty($password)) {
        header("Location: signup.php");
    }

    require_once 'includes/storage.php';

    $username = strip_tags($username);
    $password = strip_tags($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "
    INSERT INTO users(username, password)
    VALUES ('$username', '$password')
    ";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $user_id = mysqli_insert_id($connection);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        header("Location: game.php");
    } else {
        header("Location: signup.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes/header.php'; ?>
        <script defer src="includes/JS/system_form.js"></script>
    </head>
    <body>
        <header class="text-center">
            <h1 class="display-4">Signup Form</h1>
            <lead>Choose your username wisely, you can only choose it once.</lead>
        </header>
        <main>
            <div>
                <form id="system-form" action="" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" autocomplete="username" pattern="[A-z-0-9]{5,}" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" autocomplete="current-password" pattern="[A-z-0-9]{5,}" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button disabled id="submit_button" type="button" class="btn btn-primary" onclick="submitForm()">
                        Submit
                    </button>
                </form>
            </div>
        </main>
    </body>
</html>
