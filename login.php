<?php
define('PAGE_NAME', 'Login Page');

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        header('Location: login.php');
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header('Location: login.php');
        exit;
    }

    require_once 'includes/storage.php';

    $username = strip_tags($username);
    $password = strip_tags($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $login_query = "
        SELECT ID, username, password
        FROM users
        WHERE username = '$username'
    ";

    $login_result = mysqli_query($connection, $login_query);

    if (!$login_result) {
        die('Login query failed: ' . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_assoc($login_result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['ID'];
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
        <script defer src="includes/JS/system_form.js"></script>
    </head>
    <body>
        <header class="text-center">
            <h1 class="display-4">Login Form</h1>
            <lead>Enter your account details below</lead>
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
