<?php
# Sets the page name
define('PAGE_NAME', 'Home');

# Ensures storage.php is required
require_once 'includes/storage.php';

# Starts the session
session_start();

# Gets statistics about the games from the database
$game_info_query = "
    SELECT
        COUNT(users.ID) AS total_players,
        COUNT(games.ID) AS total_games,
        ROUND(COUNT(games.ID) / COUNT(users.ID), 0) AS average_games,
        ROUND(AVG(games.score), 0) AS average_score,
        MAX(games.score) AS high_score
    FROM users
    INNER JOIN games
    ON users.ID = games.user_id
";

# Runs the query
$game_info_result = mysqli_query($connection, $game_info_query);

# Checks if the query was successful
if (!$game_info_result) {
    die('Game info query failed: ' . mysqli_error($connection));
}

# Gets the game info from the result
$game_info = mysqli_fetch_assoc($game_info_result);

# Sets the variables to the game info or 0 if the game info is not set

$avg_games_per_player = $game_info['average_games'] ?? 0;
$avg_score = $game_info['average_score'] ?? 0;
$high_score = $game_info['high_score'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes\header.php'; ?>
    </head>
    <body>
        <header class="text-center">
            <!-- Page title -->
            <h1 class="display-4">
                Welcome to the Colour Guessing Game!
            </h1>
            <!-- Page Lead -->
            <lead>
                Can you guess the colour?
            </lead>
        </header>
        <main>
            <!-- Game Statistics -->
            <section class="text-center" id="game-stats">
                <!-- Game Statistics Title -->
                <h2>Game Infomation</h2>
                <!-- Game Total Players -->
                <p>
                    <strong>Total Players:</strong>
                    <?= $game_info['total_players']; ?>
                </p>
                <!-- Game Total Games -->
                <p>
                    <strong>Total Games:</strong>
                    <?= $game_info['total_games']; ?>

                </p>
                <!-- Game Average Games Per Player -->
                <p>
                    <strong>Average Games Per Player:</strong>
                    <?= $avg_games_per_player ?>
                </p>
                <!-- Game Average Score -->
                <p>
                    <strong>Average Score:</strong>
                    <?= $avg_score ?>
                </p>
                <!-- Game High Score -->
                <p>
                    <strong>High Score:</strong>
                    <?= $high_score ?>
                </p>
            </section>
        </main>
    </body>
</html>