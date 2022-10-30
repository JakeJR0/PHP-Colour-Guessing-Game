<?php
require_once 'site_info.php';

session_start();

header("Content-type: application/json; charset=utf-8");

if (!isset($_SESSION['logged_in'])) {
    echo json_encode(array("success" => false, "message" => "You are not logged in.", "time_remaining" => 0));
    exit();
} elseif ($_SESSION['logged_in'] == false) {
    echo json_encode(array("success" => false, "message" => "You are not logged in.", "time_remaining" => 0));
    exit();
} elseif (!isset($_SESSION['active_game'])) {
    echo json_encode(array("success" => false, "message" => "You are not in a game.", "time_remaining" => 0));
    exit();
} elseif ($_SESSION['active_game'] == false) {
    echo json_encode(array("success" => false, "message" => "You are not in a game.", "time_remaining" => 0));
    exit();
}

if (!isset($_SESSION['start_time'])) {
    echo json_encode(array("success" => false, "message" => "You are not in a game.", "time_remaining" => 0));
    exit();
}

$start_time = $_SESSION['start_time'];

$end_time = $start_time + GAME_TIME;

if (time() >= $end_time) {
    $_SESSION['active_game'] = false;

    if (!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
    }

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(array("success" => true, "message" => "You are not logged in so score was not saved", "time_remaining" => 0));
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $score = $_SESSION['score'];

    $_SESSION['score'] = 0;

    require_once 'storage.php';

    $user_id = strip_tags($user_id);
    $user_id = mysqli_real_escape_string($connection, $user_id);

    $score = strip_tags($score);
    $score = mysqli_real_escape_string($connection, $score);

    $query = "
        INSERT INTO games(user_id, score)
        VALUES ('$user_id', '$score')
    ";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo json_encode(array("success" => false, "message" => "Error saving score", "time_remaining" => 0));
        exit();
    } else {
        echo json_encode(array("success" => true, "message" => "Score saved", "time_remaining" => 0, "score" => $score));
        exit();
    }
} else {
    $time_remaining = $end_time - time();
    echo json_encode(array("success" => true, "message" => "The game is still in progress.", "time_remaining" => $time_remaining));
    exit();
}

?>