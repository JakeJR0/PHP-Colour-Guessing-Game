<?php
/*
    This file allows the game to retrive the remaining
    time in the game.
*/

# Ensures the site_info.php is required
require_once 'site_info.php';

# Starts the session
session_start();

# Sets the content type to JSON
header("Content-type: application/json; charset=utf-8");

# Checks if the logged in session is set
if (!isset($_SESSION['logged_in'])) {
    # Displays json error
    echo json_encode(array("success" => false, "message" => "You are not logged in.", "time_remaining" => 0));
    exit();
# Checks if the user is not logged in
} elseif ($_SESSION['logged_in'] == false) {
    # Displays json error
    echo json_encode(array("success" => false, "message" => "You are not logged in.", "time_remaining" => 0));
    exit();
# Checks if the active_game is set in the session
} elseif (!isset($_SESSION['active_game'])) {
    # Displays json error
    echo json_encode(array("success" => false, "message" => "You are not in a game.", "time_remaining" => 0));
    exit();
# Checks if the user is not in a game
} elseif ($_SESSION['active_game'] == false) {
    echo json_encode(array("success" => false, "message" => "You are not in a game.", "time_remaining" => 0));
    exit();
}

# Checks if the start_time is set in the session
if (!isset($_SESSION['start_time'])) {
    # Displays json error
    echo json_encode(array("success" => false, "message" => "You are not in a game.", "time_remaining" => 0));
    exit();
}

# Gets the start time from the session
$start_time = $_SESSION['start_time'];

# Calculates the time the game should end
$end_time = $start_time + GAME_TIME;

# Checks if the current time is past the end time
if (time() >= $end_time) {
    # Sets the active game to false
    $_SESSION['active_game'] = false;

    # Checks if the score is set in the session
    if (!isset($_SESSION['score'])) {
        # Sets the score to 0
        $_SESSION['score'] = 0;
    }

    # Checks if the user_id is set in the session
    if (!isset($_SESSION['user_id'])) {
        # Returns json error
        echo json_encode(array("success" => true, "message" => "You are not logged in so score was not saved", "time_remaining" => 0));
        exit();
    }

    # Gets the user_id from the session
    $user_id = $_SESSION['user_id'];
    # Gets the score from the session
    $score = $_SESSION['score'];

    # Resets the score in the session
    $_SESSION['score'] = 0;

    # Ensures the database connection is required
    require_once 'storage.php';

    # Removes any HTML tags from the user_id
    $user_id = strip_tags($user_id);
    # Excapes any special characters in the user_id
    $user_id = mysqli_real_escape_string($connection, $user_id);

    # Removes any HTML tags from the score
    $score = strip_tags($score);
    # Excapes any special characters in the score
    $score = mysqli_real_escape_string($connection, $score);

    # Inserts the game results into the database
    $query = "
        INSERT INTO games(user_id, score)
        VALUES ('$user_id', '$score')
    ";

    # Runs the query
    $result = mysqli_query($connection, $query);

    # Checks if the query failed
    if (!$result) {
        # Returns json error
        echo json_encode(array("success" => false, "message" => "Error saving score", "time_remaining" => 0));
        exit();
    } else {
        # Returns json success
        echo json_encode(array("success" => true, "message" => "Score saved", "time_remaining" => 0, "score" => $score));
        exit();
    }
} else {
    # Calculates the time remaining
    $time_remaining = $end_time - time();
    # Returns json success
    echo json_encode(array("success" => true, "message" => "The game is still in progress.", "time_remaining" => $time_remaining));
    exit();
}

?>