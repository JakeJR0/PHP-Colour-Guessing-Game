/*
This javascript file is used to validate the input fields in the
login and signup pages.
*/

function submitForm() {
    /*
    This function is called when the user clicks the submit button.
    */

    // Gets the form elements and selects 0th element
    var form = document.getElementsByTagName("form")[0];
    // Submits the form
    form.submit();
}

function validInput(input) {
    /*
    This function is used to validate the input fields, 
    the function checks if the input is meeting the requirements and
    returns true or false.
    */

    // Checks if the input is empty
    if (input.value == "" || input.value == null) {
        return false;
    // Checks if the input matches the regex pattern in the attribute of the input field
    } else if (input.validity.patternMismatch) {
        return false;
    }

    // Checks if the input contains any spaces
    if (input.value.includes(" ")) {
        return false;
    }

    return true;
}

document.addEventListener("DOMContentLoaded", function(event) {
    /*
        This function is called when the DOM is loaded.
    */

    // Logs the event
    console.log("Running system_form.js");

    // Gets the username input field
    var username = document.getElementById("username");
    // Gets the password input field
    var password = document.getElementById("password");
    // Gets the submit button
    var submit_button = document.getElementById("submit_button");

    // Adds an event listener to the submit button
    username.addEventListener("input", function(event) {
        /*
            This function is called when the user types in the username input field.
        */

        // Checks if the input is valid
        if (!validInput(username)) {
            // Disables the submit button
            submit_button.disabled = true;
        // Checks if the password input is also valid
        } else if (validInput(password)) {
            // Enables the submit button
            submit_button.disabled = false;
        }
    });

    // Adds an event listener to the submit button
    username.addEventListener("blur", function(event) {
        /*
            This function is called when the user clicks out of the username input field.
        */

        // Checks if the input is valid
        if (!validInput(username)) {
            // Adds the system-form-input-error class to the input field
            username.classList.add("system-form-input-error");
        }
    });

    // Adds an event listener to the submit button
    username.addEventListener("focus", function(event) {
        /*
            This function is called when the user clicks into the username input field.
        */

        // Checks if the username input field has the system-form-input-error class
        if (username.classList.contains("system-form-input-error")) {
            // Removes the system-form-input-error class from the input field
            username.classList.remove("system-form-input-error");
        }
    });
    
    // Adds an event listener to the submit button
    password.addEventListener("input", function(event) {
        /*
            This function is called when the user types in the password input field.
        */

        // Checks if the password input is valid
        if (!validInput(password)) {
            // Disables the submit button
            submit_button.disabled = true;
        // Checks if the username input is also valid
        } else if (validInput(username)) {
            // Enables the submit button
            submit_button.disabled = false;
        }
    });

    // Adds an event listener to the submit button
    password.addEventListener("blur", function(event) {
        /*
            This function is called when the user clicks out of the password input field.
        */

        // Checks if the password input is valid
        if (!validInput(password)) {
            // Adds the system-form-input-error class to the input field
            password.classList.add("system-form-input-error");
        }
    });

    // Adds an event listener to the submit button
    password.addEventListener("focus", function(event) {
        /*
            This function is called when the user clicks into the password input field.
        */

        // Checks if the password input field has the system-form-input-error class
        if (password.classList.contains("system-form-input-error")) {
            // Removes the system-form-input-error class from the input field
            password.classList.remove("system-form-input-error");
        }
    });
});