// Script for "Add User" Button - Show/Hide Password

    function togglePassword() {
        // Get the password input field by its ID
        var passwordField = document.getElementById("password");
        // Get the eye icon element by its ID
        var eyeIcon = document.getElementById("eyeIcon");

        // Check if the password field is currently hidden
        if (passwordField.type === "password") {
            // Change the input type to text to show the password
            passwordField.type = "text";
            // Change the eye icon to indicate the password is visible
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            // Change the input type back to password to hide it
            passwordField.type = "password";
            // Change the eye icon back to indicate the password is hidden
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
        // Script for "User Modification" Button - Show/Hide Password

    function togglePassword() {
        // Get the password input field by its ID
        var passwordField = document.getElementById("password");
        // Get the eye icon element by its ID
        var eyeIcon = document.getElementById("eyeIcon");

        // Check if the password field is currently hidden
        if (passwordField.type === "password") {
            // Change the input type to text to show the password
            passwordField.type = "text";
            // Change the eye icon to indicate the password is visible
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            // Change the input type back to password to hide it
            passwordField.type = "password";
            // Change the eye icon back to indicate the password is hidden
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }


    }


