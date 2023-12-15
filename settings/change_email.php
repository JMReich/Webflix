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

    // Display a form to change the user's email
    echo '<h1>Change Email</h1>';
    echo '<form id="change-email-form" action="inc.change_email.php" method="POST" class="signup">';
    echo '<label for="new-email">New Email</label>';
    echo '<input type="text" id="new-email" name="new-email" required>';
    echo '<input type="submit" value="Change Email">';
    echo '</form>';


    //display current email
    $username = $_SESSION['username'];
    $sql = "SELECT email FROM accounts WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo '<p>Current Email: ' . $row['email'] . '</p>';
    


    ?>

    <script>
        // Ajax call to reset email
        $("#change-email-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.change_email.php",
                data: $("#change-email-form").serialize(),
                success: function(data) {
                    if (data == 'success') {
                        alert("Email changed successfully");
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