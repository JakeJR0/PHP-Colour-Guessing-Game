<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isset($_SESSION['logged_in'])) {
        header('Location: login.php');
    } elseif ($_SESSION['logged_in'] == false) {
        header('Location: login.php');
    } elseif (!isset($_SESSION['active_game'])) {
        $_SESSION['active_game'] = false;
    }

    if ($_SESSION['active_game'] == false) {
        header('Location: game.php');
    }

    if (!isset($_POST['guess'])) {
        header('Location: game.php');
    } elseif (!isset($_SESSION['answer'])) {
        header('Location: game.php');
    }

    $guess = $_POST['guess'];
    $answer = $_SESSION['answer'];

    $guess = strtolower($guess);
    $answer = strtolower($answer);

    if ($guess == $answer) {
        if (!isset($_SESSION['score'])) {
            $_SESSION['score'] = 0;
        }

        $_SESSION['score'] += 1;
    }

    header('Location: game.php');
} else {
    header("Location: index.php");
}
?>