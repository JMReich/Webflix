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
    // Check if the user is an admin
    if ($_SESSION['role'] != 'admin') {
        header("Location: /home");
        exit();
    } 

    // Display a form to update an account (user_id, username, password, role)
    echo '<h1>Update Account</h1>';
    echo '<form id="update-account-form" action="inc.update_account.php" method="POST" class="signup">';
    echo '<label for="user-id">User ID</label>';
    echo '<input type="text" id="user-id" name="user-id" required>';
    echo '<label for="username">Username</label>';
    echo '<input type="text" id="username" name="username" required>';
    echo '<label for="password">Password</label>';
    echo '<input type="password" id="password" name="password" required>';
    echo '<label for="role">Role</label>';
    echo '<input type="text" id="role" name="role" required>';
    echo '<input type="submit" value="Update Account">';
    echo '</form>';




    ?>

    <script>
        // Ajax call to update account
        $("#update-account-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.update_account.php",
                data: $("#update-account-form").serialize(),
                success: function(data) {
                    if (data == "success") {
                        alert("Account updated successfully");
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