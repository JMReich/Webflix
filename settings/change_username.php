<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/mainContent.css">
    <link type="text/css" rel="stylesheet" href="/CSS/signUpForm.css" media="screen">
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php
        include_once '../includes/inc.topnav.php';
        include_once '../includes/inc.mysqlCon.php';
        


    ?>

    <?php
    echo '<div class="main-content">';
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // If not logged in, redirect to login page
        header("Location: /login.php");
        exit();
    }

    // Display a form to change the user's username
    echo '<h1>Change Username</h1>';
    echo '<form id="change-username-form" action="inc.change_username.php" method="POST" class="signup">';
    echo '<label for="new-username">New Username</label>';
    echo '<input type="text" id="new-username" name="new-username" required>';
    echo '<input type="submit" value="Change Username">';
    echo '</form>';

    // Display current username
    echo '<p>Current Username: ' . $_SESSION['username'] . '</p>';
    

    echo '</div>';



    ?>

    <script>
        // Ajax call to reset username
        $("#change-username-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.change_username.php",
                data: $("#change-username-form").serialize(),
                success: function(data) {
                    if (data == "success") {
                        alert("Username changed successfully");
                        window.location.href = "/home";
                    } else {
                        alert(data);
                    }
                }
            });
        });
    </script>







</body>
</html>