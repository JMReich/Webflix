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

    // Display a form to change the user's password
    echo '<h1>Change Password</h1>';
    echo '<form id="change-pw-form" action="inc.change_pw.php" method="POST" class="signup">';
    echo '<label for="old-pw">Old Password</label>';
    echo '<input type="password" id="old-pw" name="old-pw" required>';
    echo '<label for="new-pw">New Password</label>';
    echo '<input type="password" id="new-pw" name="new-pw" required>';
    echo '<label for="confirm-pw">Confirm New Password</label>';
    echo '<input type="password" id="confirm-pw" name="confirm-pw" required>';
    echo '<input type="submit" value="Change Password">';
    echo '</form>';

    echo '</div>';


    ?>

    <script>
        // Ajax call to reset password
        $("#change-pw-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.change_pw.php",
                data: $("#change-pw-form").serialize(),
                success: function(data) {
                    if (data == "success") {
                        alert("Password changed successfully");
                        window.location.href = "/settings.php";
                    } else {
                        alert(data);
                    }
                }
            });
        });
    </script>


</body>
</html>