# Colour Guessing Game

## Introduction

This is a recreation of the game that I was tasked to make in python during my T-Level course, I have descided to recreate it in PHP as a way to learn the language.

## Dependencies

This game requires the following dependencies to be installed:

- [WampServer](https://www.wampserver.com/en/) or [XAMPP](https://www.apachefriends.org/index.html)

## Usage

### Installation

- Clone Repository into your `www` or `htdocs` folder
- Start WampServer or XAMPP

### Database Setup

- Open phpMyAdmin
- Create a new database called `colour_game`
- Runs the following SQL command:

```sql
INSERT INTO colours(colour_name, colour_hex) 
VALUES
('red', '#FF0000'),
('green', '#00FF00'),
('blue', '#0000FF'),
('pink', '#FF00FF'),
('orange', '#FFA500'),
('purple', '#800080'),
('brown', '#A52A2A'),
('black', '#000000')
```

### Playing the Game

- Go to [localhost/PHP-Colour-Guessing-Game/index.php](http://localhost/PHP-Colour-Guessing-Game/index.php)

## Project Requirements

- The game must provide a random colour for both the text and background, the user must then guess the colour of the text.
- The game should have a timer of 30 seconds.
- The game should keep track of the users score.

## Additional Features

- The game should allow the user to login or register an account.
- The game should store the users score in a database.
- The game should have a leaderboard that keeps track of the top 10 scores.

## Possible Future Features

- The game could have a difficulty setting that changes the time limit.
