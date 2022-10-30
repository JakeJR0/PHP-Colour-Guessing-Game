<?php
# Database Settings

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'colour_game');

# Connects to the database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

# Checks if the connection is successful
if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error() . ' (' . mysqli_connect_errno() . ')');
}

# Ensures the colours table exists
$colours_table = "
    CREATE TABLE IF NOT EXISTS colours (
        ID INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        colour_name VARCHAR(20) NOT NULL,
        colour_hex VARCHAR(7) NOT NULL
    ) AUTO_INCREMENT = 1000000;
";

# Ensures the users table exists
$users_table = "
    CREATE TABLE IF NOT EXISTS users (
        ID INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        username VARCHAR(20) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    ) AUTO_INCREMENT = 1000000;
";

# Ensures the games table exists
$games_table = "
    CREATE TABLE IF NOT EXISTS games (
        ID INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        user_id INTEGER NOT NULL,
        score INTEGER NOT NULL,
        recorded_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(ID)
    ) AUTO_INCREMENT = 1000000;
";

# Creates the tables if they don't exist

$colours_table_result = mysqli_query($connection, $colours_table);
$users_table_result = mysqli_query($connection, $users_table);
$games_table_result = mysqli_query($connection, $games_table);

# Checks if the tables were created successfully

if (!$colours_table_result) {
    die('Table colours creation failed: ' . mysqli_error($connection));
}

if (!$users_table_result) {
    die('Table users creation failed: ' . mysqli_error($connection));
}

if (!$games_table_result) {
    die('Table games creation failed: ' . mysqli_error($connection));
}

?>