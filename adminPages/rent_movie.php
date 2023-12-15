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

    // Display a form to rent a movie to an account (user_id and movie_id)
    echo '<h1>Rent Movie</h1>';
    echo '<form id="rent-movie-form" action="inc.rent_movie.php" method="POST" class="signup">';
    echo '<label for="user-id">User ID</label>';
    echo '<input type="text" id="user-id" name="user-id" required>';
    echo '<label for="movie-id">Movie ID</label>';
    echo '<input type="text" id="movie-id" name="movie-id" required>';
    echo '<input type="submit" value="Rent Movie">';
    echo '</form>';

    ?>

    <script>
        // Ajax call to rent a movie to an account
        $("#rent-movie-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.rent_movie.php",
                data: $("#rent-movie-form").serialize(),
                success: function(data) {
                    if (data == "success") {
                        alert("Movie rented successfully");
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