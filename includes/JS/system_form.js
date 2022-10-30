function submitForm() {
    var form = document.getElementsByTagName("form")[0];
    form.submit();
}

function validInput(input) {
    if (input.value == "" || input.value == null) {
        return false;
    } else if (input.validity.patternMismatch) {
        return false;
    }

    if (input.value.includes(" ")) {
        return false;
    }

    return true;
}

document.addEventListener("DOMContentLoaded", function(event) {
    console.log("Running system_form.js");
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var submit_button = document.getElementById("submit_button");

    username.addEventListener("input", function(event) {
        if (!validInput(username)) {
            submit_button.disabled = true;
        } else if (validInput(password)) {
            submit_button.disabled = false;
        }
    });

    username.addEventListener("blur", function(event) {
        if (!validInput(username)) {
            username.classList.add("system-form-input-error");
        }
    });

    username.addEventListener("focus", function(event) {
        if (username.classList.contains("system-form-input-error")) {
            username.classList.remove("system-form-input-error");
        }
    });
    
    password.addEventListener("input", function(event) {
        if (!validInput(password)) {
            submit_button.disabled = true;
        } else if (validInput(username)) {
            submit_button.disabled = false;
        }
    });

    password.addEventListener("blur", function(event) {
        if (!validInput(password)) {
            password.classList.add("system-form-input-error");
        }
    });

    password.addEventListener("focus", function(event) {
        if (password.classList.contains("system-form-input-error")) {
            password.classList.remove("system-form-input-error");
        }
    });

});