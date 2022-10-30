<?php

# Starts the session
session_start();

# Checks if the request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    # Checks if logged_in is set in the session
    if (!isset($_SESSION['logged_in'])) {
        # Redirects to the login page
        header('Location: login.php');
    # Checks if the user is not logged in
    } elseif ($_SESSION['logged_in'] == false) {
        # Redirects to the login page
        header('Location: login.php');
    # Checks if active_game is set in the session
    } elseif (!isset($_SESSION['active_game'])) {
        # Sets the active game to false
        $_SESSION['active_game'] = false;
    }

    # Checks if the user is not in a game
    if ($_SESSION['active_game'] == false) {
        # Redirects to the game page
        header('Location: game.php');
    }

    # Checks if guess is not set in the post
    if (!isset($_POST['guess'])) {
        # Redirects to the game page
        header('Location: game.php');
    # Checks if the answer is not set in the session
    } elseif (!isset($_SESSION['answer'])) {
        # Redirects to the game page
        header('Location: game.php');
    }

    # Gets the guess from the post
    $guess = $_POST['guess'];
    # Gets the answer from the session
    $answer = $_SESSION['answer'];

    # Converts the guess into lowercase
    $guess = strtolower($guess);
    # Converts the answer into lowercase
    $answer = strtolower($answer);

    # Checks if the user guessed the answer correctly
    if ($guess == $answer) {
        # Checks if the score is not set in the session
        if (!isset($_SESSION['score'])) {
            # Sets the score to 0
            $_SESSION['score'] = 0;
        }

        # Increases the score by 1
        $_SESSION['score'] =+ 1;
    }

    # Redirects to the game page
    header('Location: game.php');
} else {
    # Redirects to the game page
    header("Location: index.php");
}
?>