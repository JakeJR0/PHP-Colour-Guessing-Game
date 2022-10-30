<?php
define('PAGE_NAME', 'Game');

session_start();

require_once 'includes/game_functions.php';
require_once 'includes/storage.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
} elseif ($_SESSION['logged_in'] == false) {
    header('Location: login.php');
}

if (!isset($_SESSION['active_game'])) {
    $_SESSION['active_game'] = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $active_game = $_SESSION['active_game'];

    if ($active_game == true) {
        header('Location: game.php');
    } else {
        $_SESSION['active_game'] = true;
        $_SESSION['start_time'] = time();
        header('Location: game.php');
    }
}

if ($_SESSION['active_game'] == false) {
    DisplayMenu($connection);
} else {
    DisplayGame($connection);
}

function DisplayMenu($connection) {
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
            <h2>Leaderboard</h2>
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
                        $rank = 1;
                        foreach ($highscore as $row) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $rank; ?>
                        </td>
                        <td>
                            <?php echo $row['username']; ?>
                        </td>
                        <td>
                            <?php echo $row['score']; ?>
                        </td>
                    </tr>
                    <?php
                            $rank++;
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <main>
            <div class="text-center" style="margin-top: 5rem;">
                <form action="" method="POST">
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
            <h1 class="display-4">Guess the Colour</h1>
            <lead>Can you guess the colour?</lead>
        </header>
        <main id="game-wrapper">
            <section>
                <!-- Timer -->
                <div class="text-center">
                    <h2>Time Remaining: 
                        <span id="timer">
                            60
                        </span>
                    </h2>
                </div>
            </section>
            <section>
                <!-- Score -->
                <div class="text-center">
                    <?php $score = isset($_SESSION['score']) ? $_SESSION['score'] : 0 ?>
                    <h2>Score: <?php echo $score; ?></h2>
                </div>
            </section>
            <section id='colours'>
                <?php
                    // Get colours
                    $colours = getColours($connection, 2);
                    $colour1 = $colours[0];
                    $colour2 = $colours[1];

                    // Sets the colour to the session
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

                <!-- Answer -->
                <div class="text-center" id="game-answer">
                    <h2><?php echo ucwords($colour2['name']); ?></h2>
                    <p>Type the colour of the text</p>
                </div>
            </section>

            <section>
                <div id="game-form">
                    <form action="guess.php" method="post" id="game-answer-form">
                        <div class="form-group">
                            <label for="guess">Colour:</label>
                            <input class="form-control" autofocus type="text" name="guess" placeholder="Enter your guess" pattern="[A-z]{3,}">
                        </div>
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