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

    // Display a form to delete the users account require password
    echo '<h1>Delete Account</h1>';
    echo '<form id="delete-account-form" action="inc.delete_account.php" method="POST" class="signup">';
    echo '<label for="password">Password</label>';
    echo '<input type="password" id="password" name="password" required>';
    echo '<input type="submit" value="Delete Account">';
    echo '</form>';





    ?>

    <script>
        // Ajax call to delete account 
        $("#delete-account-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.delete_account.php",
                data: $("#delete-account-form").serialize(),
                success: function(data) {
                    if (data == "success") {
                        alert("Account deleted successfully");
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