<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel='stylesheet' href="CSS/mainContent.css">
    <link type="text/css" rel='stylesheet' href="CSS/signUpForm.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <?php
        include_once 'includes/inc.topnav.php';
        include_once 'includes/inc.mysqlCon.php';
    ?>

    <div class="main-content">
        <form action="/includes/inc.login.php" method="POST" class="signup" id="signup"> <!-- old class reused from signup form -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" required>
                <i toggle="#password" class="fa fa-eye toggle-password"></i>
            </div>     
            <input type="submit" value="Log in">
        </form>
    </div>
    <div id="errorText"></div>



    <script>
        $(document).ready(function() {
            $('.signup').on('submit', function(e) {
                e.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();
                $.ajax({
                    url: '/includes/inc.login.php',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#success').text("");
                        $('#errorText').text("");
                        
                        if (response[0] && response[0].status === 'error') { // There were errors
                            // Loop over the errors and handle each one
                            for (var i = 0; i < response.length; i++) {
                                $('#errorText').append(response[i].message + '<br>');
                            }
                        } else { // Student registered successfully
                            console.log("success");
                            window.location.href = "/home"; 
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>






    
</body>
</html>