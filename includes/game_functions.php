<?php
require_once 'includes/site_info.php';

function get_highscores($connection, $limit=10) {
    $limit = strip_tags($limit);
    $limit = mysqli_real_escape_string($connection, $limit);
    
    $query = "
        SELECT g.score, u.username
        FROM Games AS g
        INNER JOIN Users AS u
        ON g.user_id = u.ID
        ORDER BY g.score DESC
        LIMIT $limit;
    ";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($connection));
    }

    $highscores = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $highscores[] = $row;
    }

    while (count($highscores) < $limit) {
        $highscores[] = array('score' => 0, 'username' => 'Unclaimed');
    }

    arsort($highscores);

    return $highscores;
}

function getColours($connection, $limit=2) {
    $limit = strip_tags($limit);
    $limit = mysqli_real_escape_string($connection, $limit);

    $query = "
        SELECT colour_name AS name, colour_hex AS colour
        FROM colours
        ORDER BY RAND()
        LIMIT $limit;
    ";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($connection));
    }

    $colours = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $colours[] = $row;
    }

    return $colours;
}

?>