/*
This file is used to allow the user to see the time remaining in the game.
*/

// Initializes the timer
var Timer;

function getTimeRemaining() {
    /*
    This function is used to get the time remaining in the game.
    */

    // This gets the index of the last / in the location of the pathname
    var fileNameIndex = location.pathname.lastIndexOf("/") + 1;
    // This gets the pathname of the current page without the file name
    var locationPath = location.pathname.substring(0, fileNameIndex);
    // This gets the file name of the timer.php file
    var url = location.origin + locationPath + "includes/game_timer.php";

    // This creates a new XMLHttpRequest object
    var xml = new XMLHttpRequest();

    // This opens the XMLHttpRequest object
    xml.open('GET', url);

    // This sets the expected response type
    xml.responseType = 'json';

    // This sends the request
    xml.send();

    xml.onload = function() {
        /*
        This function is called when the XMLHttpRequest object is loaded.
        */

        // This gets the response from the XMLHttpRequest object
        const data = xml.response;

        // This gets the success value from the response
        var success = data.success;

        // This checks if reply is successful
        if (success == true) {
            // This gets the time remaining from the response
            var timeRemaining = data.time_remaining;
            // This gets the score from the response or sets it to 0
            var score = data.score || 0;

            // This gets the timer element
            var timeRemainingDiv = document.getElementById("timer");

            // This updates the timer element
            timeRemainingDiv.innerHTML = timeRemaining;

            // Checks if the time remaining is 0 or less
            if (timeRemaining <= 0) {
                // Stops the timer
                clearInterval(Timer);
                // Alerts the user that the game is over
                alert("Game Over - Your time is up!\n\nYou scored " + score + " points.");
                // Reloads the page
                window.location.reload();
            }
        } else {
            // Stops the timer
            clearInterval(Timer);
            // Alerts the user that the game is over
            alert("Game Over");
            // Reloads the page
            window.location.reload();
        }     
    }
}

// Adds an event listener to the document
document.addEventListener("DOMContentLoaded", function() {
    /*
        This function is called when the DOM is loaded.
    */

    // Logs the event
    console.log("Running timer.js");
    // Runs the getTimeRemaining function
    getTimeRemaining();
    // Runs the getTimeRemaining function every second
    Timer = setInterval(getTimeRemaining, 1000);
});