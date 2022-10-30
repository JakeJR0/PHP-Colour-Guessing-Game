
var Timer;

function getTimeRemaining() {
    var fileNameIndex = location.pathname.lastIndexOf("/") + 1;
    var locationPath = location.pathname.substring(0, fileNameIndex);
    var url = location.origin + locationPath + "includes/game_timer.php";

    var xml = new XMLHttpRequest();
    console.log(url);
    xml.open('GET', url);
    xml.responseType = 'json';
    xml.send();

    xml.onload = function() {
        const data = xml.response;
        var success = data.success;
        if (success == true) {
            var timeRemaining = data.time_remaining;
            var score = data.score || 0;

            var timeRemainingDiv = document.getElementById("timer");

            timeRemainingDiv.innerHTML = timeRemaining;

            if (timeRemaining == 0) {
                clearInterval(Timer);
                alert("Game Over - Your time is up!\n\nYou scored " + score + " points.");
                window.location.reload();
            }
        } else {
            clearInterval(Timer);
            alert("Game Over");
            window.location.reload();
        }
        
    }
}

document.addEventListener("DOMContentLoaded", function() {
    console.log("Running timer.js");
    getTimeRemaining();
    Timer = setInterval(getTimeRemaining, 1000);
});