<!DOCTYPE html>
<html lang="en">
<head>
    <link type="text/css" rel='stylesheet' href="CSS/mainContent.css">
    <link type="text/css" rel='stylesheet' href="CSS/signUpForm.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- loads the rest of the head and the begining of the body -->
    <?php
        include_once 'includes/inc.topnav.php';
    ?>    
    <div class="main-content">
        <form action="/includes/inc.signup.php" method="POST" class="signup" id="signup">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" required>
                <i toggle="#password" class="fa fa-eye toggle-password"></i>
            </div> 

            <label for="password-repeat">Repeat Password:</label>
            <input type="password" id="password-repeat" name="password-repeat" required>
            
            
            <input type="submit" value="Sign Up">
        </form>

        
        <div id="errorText"></div>
    </div>


    <script>
        $(document).ready(function() {
            $('.signup').on('submit', function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var username = $('#username').val();
                var email = $('#email').val();
                var dob = $('#dob').val();
                var password = $('#password').val();
                var passwordRepeat = $('#password-repeat').val();
                $.ajax({
                    url: '/includes/inc.signup.php',
                    type: 'POST',
                    data: {
                        username: username,
                        email: email,
                        password: password,
                        passwordRepeat: passwordRepeat
                    },
                    success: function(response) {
                        console.log(response);
                        var response = JSON.parse(response);
                        $('#success').text("");
                        $('#errorText').text("");
                        if (response[0] && response[0].status === 'exists') { // Student already registered
                            // Update the text in the popup dialog
                            $('#errorText').text(response[0].message);
                        } else if (response[0] && response[0].status === 'error') { // There were errors
                            // Loop over the errors and handle each one
                            console.log(response);
                            for (var i = 0; i < response.length; i++) {
                                var error = response[i];
                                // Display the error message to the user
                                $('#errorText').append(error.message + '<br/>');
                                // TODO: Highlight/underline the field that the error is for
                            }
                        } else { // Registration was successful
                            alert("You have successfully registered!");
                            window.location.href = "/home";
                        }
                    },
                    error: function(data) {
                        
                    }
                });
            });
        });



    </script>
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            var input2 = document.getElementById("password-repeat");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
            if (input2.type == "password") {
                input2.type = "text";
            } else {
                input2.type = "password";
            }
        });
    </script>

</body>
</html>