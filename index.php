<?php
define('PAGE_NAME', 'Home');
require_once 'includes/storage.php';
session_start();

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

$game_info_result = mysqli_query($connection, $game_info_query);

if (!$game_info_result) {
    die('Game info query failed: ' . mysqli_error($connection));
}

$game_info = mysqli_fetch_assoc($game_info_result);

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
            <h1 class="display-4">
                Welcome to the Colour Guessing Game!
            </h1>
            <lead>
                Can you guess the colour?
            </lead>
        </header>

        <main>
            <section class="text-center" id="game-stats">
                <h2>Game Infomation</h2>
                <p>
                    <strong>Total Players:</strong>
                    <?= $game_info['total_players']; ?>
                </p>
                <p>
                    <strong>Total Games:</strong>
                    <?= $game_info['total_games']; ?>

                </p>
                <p>
                    <strong>Average Games Per Player:</strong>
                    <?= $avg_games_per_player ?>
                </p>
                <p>
                    <strong>Average Score:</strong>
                    <?= $avg_score ?>

                </p>
                <p>
                    <strong>High Score:</strong>
                    <?= $high_score ?>
                </p>
            </section>
        </main>
    </body>
</html>