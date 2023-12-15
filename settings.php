<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/mainContent.css">
    <link type="text/css" rel="stylesheet" href="/CSS/settings.css" media="screen">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php
        include_once 'includes/inc.topnav.php';
        include_once 'includes/inc.mysqlCon.php';
        


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
    if ($_SESSION['role'] == 'admin') {
        // Provide four buttons (add movie, rent movie to account, delete review, update account, delete account)
        
        echo '<h1>Admin Settings</h1>';
        echo '<div class="settings-button-container">';
        echo '<button class="admin-settings-button" onclick="window.location.href=\'/adminPages/add_movie.php\'">Add Movie</button>';
        echo '<button class="admin-settings-button" onclick="window.location.href=\'/adminPages/rent_movie.php\'">Rent Movie to account</button>';
        echo '<button class="admin-settings-button" onclick="window.location.href=\'/adminPages/delete_review.php\'">Delete Review</button>';
        echo '<button class="admin-settings-button" onclick="window.location.href=\'/adminPages/update_account.php\'">Update Account</button>';
        echo '<button class="admin-settings-button" onclick="window.location.href=\'/adminPages/delete_account.php\'">Delete Account</button>';
        
        
    } else {
        // Provide four buttons (change pw, change username, change email, delete account)
        echo '<h1>Settings</h1>';
        echo '<div class="settings-button-container">';
        echo '<button class="settings-button" onclick="window.location.href=\'/settings/change_pw.php\'">Change Password</button>';
        echo '<button class="settings-button" onclick="window.location.href=\'/settings/change_username.php\'">Change Username</button>';
        echo '<button class="settings-button" onclick="window.location.href=\'/settings/change_email.php\'">Change Email</button>';
        echo '<button class="settings-button" onclick="window.location.href=\'/settings/delete_account.php\'">Delete Account</button>';

        
    }
    echo '</div>';

    echo '</div>';


    ?>


</body>
</html>