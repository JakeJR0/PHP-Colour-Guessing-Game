<?php

# Sets the page name
define('PAGE_NAME', 'Game');

# Starts the session
session_start();

# Ensures the site_info.php is required
require_once 'includes/game_functions.php';
# Ensures the game_functions.php is required
require_once 'includes/storage.php';

# Checks if the logged in session is set
if (!isset($_SESSION['logged_in'])) {
    # Redirects to the login page
    header('Location: login.php');
# Checks if the user is not logged in
} elseif ($_SESSION['logged_in'] == false) {
    # Redirects to the login page
    header('Location: login.php');
}

# Checks if the active_game is set in the session
if (!isset($_SESSION['active_game'])) {
    # Sets the active game to false
    $_SESSION['active_game'] = false;
}

# Checks if the request method is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Gets the active game from the session
    $active_game = $_SESSION['active_game'];

    # Checks if the game is active
    if ($active_game == true) {
        # Redirects to the game page
        header('Location: game.php');
    } else {
        # Sets the active game to true
        $_SESSION['active_game'] = true;
        # Sets start time to the current time
        $_SESSION['start_time'] = time();
        # Redirects to the game page
        header('Location: game.php');
    }
}

# Checks if the user is in a game
if ($_SESSION['active_game'] == false) {
    # Displays the start game menu
    DisplayMenu($connection);
} else {
    # Displays the game
    DisplayGame($connection);
}

function DisplayMenu($connection) {
    # Gets the leaderboard from the database
    $highscore = get_highscores($connection, 10);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes\header.php'; ?>
    </head>
    <body>
        <!-- Leaderboard -->
        <section class="text-center">
            <!-- Leaderboard Title -->
            <h2>Leaderboard</h2>
            <!-- Leaderboard Table -->
            <table class="table" id="leaderboard">
                <thead>
                    <tr>
                        <th>
                            Rank
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            Score
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        # Sets the rank to 1
                        $rank = 1;
                        # Loops through the highscore array
                        foreach ($highscore as $row) {
                    ?>
                    <tr>
                        <!-- Leaderboard Rank <?= $rank ?> -->
                        <td>
                            <!-- Rank -->
                            <?php echo $rank; ?>
                        </td>
                        <td>
                            <!-- Username -->
                            <?php echo $row['username']; ?>
                        </td>
                        <td>
                            <!-- Score -->
                            <?php echo $row['score']; ?>
                        </td>
                    </tr>
                    <?php
                            # Increments the rank
                            $rank++;
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <main>
            <!-- Start Game Form -->
            <div class="text-center" style="margin-top: 5rem;">
                <form action="" method="POST">
                    <!-- Start Game Button -->
                    <input class="btn btn-primary" type="submit" name="new_game" value="New Game">
                </form>
            </div>
        </main>
    </body>
</html>
<?php
}

function DisplayGame($connection) {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes\header.php'; ?>
        <!-- Game Timer -->
        <script defer src="includes/JS/timer.js"></script>
    </head>
    <body>
        <header class="text-center">
            <!-- Page Title -->
            <h1 class="display-4">Guess the Colour</h1>
            <!-- Page Lead -->
            <lead>Can you guess the colour?</lead>
        </header>
        <!-- Game -->
        <main id="game-wrapper">
            <!-- Game Timer -->
            <section>
                <div class="text-center">
                    <h2>Time Remaining: 
                        <span id="timer">
                            60
                        </span>
                    </h2>
                </div>
            </section>
            <!-- Game Score -->
            <section>
                <div class="text-center">
                    <?php $score = isset($_SESSION['score']) ? $_SESSION['score'] : 0 ?>
                    <h2>Score: <?php echo $score; ?></h2>
                </div>
            </section>
            <!-- Game Colour -->
            <section id='colours'>
                <?php
                    # Get 2 random colours
                    $colours = getColours($connection, 2);
                    $colour1 = $colours[0];
                    $colour2 = $colours[1];

                    # Sets the colour to the session
                    $_SESSION['answer'] = $colour1['name'];
                ?>
                <style type="text/css">
                    /* 
                        This changes the style depending on colour selected
                        by the server.
                    */
                    :root {
                        --game-background-color: <?php echo $colour1['colour']; ?>;
                        --game-text-color: <?php echo $color1['colour']; ?>;
                    }

                </style>

                <!-- Game Answer -->
                <div class="text-center" id="game-answer">
                    <!-- Game Answer Text -->
                    <h2><?php echo ucwords($colour2['name']); ?></h2>
                    <!-- Game Answer Hint -->
                    <p>Type the colour of the text</p>
                </div>
            </section>
            <!-- Game Form -->
            <section>
                <div id="game-form">
                    <form action="guess.php" method="post" id="game-answer-form">
                        <!-- Colour Input -->
                        <div class="form-group">
                            <label for="guess">Colour:</label>
                            <input class="form-control" autofocus type="text" name="guess" placeholder="Enter your guess" pattern="[A-z]{3,}">
                        </div>
                        <!-- Submit Button -->
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>
<?php
}
?>