<?php require_once 'includes/site_info.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo SITE_NAME." - ". PAGE_NAME; ?></title>
        <meta charset="utf-8">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="includes/style.css">
        <!-- Bootstrap JS -->

        <script defer src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="index.php" style="margin-left: 20px;">Home</a>
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#PageNavBar">
                <!-- Toggler Icon -->
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible Navbar -->
            <div class="collapse navbar-collapse" id="PageNavBar">
                <!-- Navbar Links -->
                <ul class="navbar-nav">
                    <?php
                    # Checks if the user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    ?>
                        <li>
                            <a class="nav-link" href="game.php">Game</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Register</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </body>
</html>