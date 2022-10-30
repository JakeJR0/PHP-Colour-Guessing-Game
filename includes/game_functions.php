<?php
/*
    This file contains the functions used in the game.php file.
*/

# Ensures the site_info.php is required
require_once 'includes/site_info.php';

function get_highscores($connection, $limit=10) {
    /*
        This function gets the highscores from the database.
        It returns an array of the highscores.
    */

    # Removes any HTML tags from the limit
    $limit = strip_tags($limit);
    # Excapes any special characters in the limit
    $limit = mysqli_real_escape_string($connection, $limit);
    
    # Gets the highscores from the database
    $query = "
        SELECT g.score, u.username
        FROM Games AS g
        INNER JOIN Users AS u
        ON g.user_id = u.ID
        ORDER BY g.score DESC
        LIMIT $limit;
    ";

    # Runs the query
    $result = mysqli_query($connection, $query);

    # Checks if the query failed
    if (!$result) {
        die('Query failed: ' . mysqli_error($connection));
    }

    # Creates an array to store the highscores
    $highscores = array();

    # Loops through the results
    while ($row = mysqli_fetch_assoc($result)) {
        # Adds the highscore to the array
        $highscores[] = $row;
    }

    # Loops through the highscores until the limit is reached
    while (count($highscores) < $limit) {
        # Adds a blank highscore to the array
        $highscores[] = array('score' => 0, 'username' => 'Unclaimed');
    }

    # Sorts the highscores by score
    arsort($highscores);

    # Returns the highscores
    return $highscores;
}

function getColours($connection, $limit=2) {
    /*
        This function gets the colours from the database.
        It returns an array of the colours.
    */

    # Removes any HTML tags from the limit
    $limit = strip_tags($limit);
    # Excapes any special characters in the limit
    $limit = mysqli_real_escape_string($connection, $limit);

    # Gets random colours from the database
    $query = "
        SELECT colour_name AS name, colour_hex AS colour
        FROM colours
        ORDER BY RAND()
        LIMIT $limit;
    ";

    # Runs the query
    $result = mysqli_query($connection, $query);

    # Checks if the query failed
    if (!$result) {
        die('Query failed: ' . mysqli_error($connection));
    }

    # Creates an array to store the colours
    $colours = array();

    # Loops through the results
    while ($row = mysqli_fetch_assoc($result)) {
        # Adds the colour to the array
        $colours[] = $row;
    }

    # Returns the colours
    return $colours;
}

?>