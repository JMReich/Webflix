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

    // Display a form to add a movie
    echo '<h1>Add Movie</h1>';
    echo '<form id="add-movie-form" action="inc.add_movie.php" method="POST" class="signup">';
    echo '<label for="name">Title</label>';
    echo '<input type="text" id="name" name="name" required>';
    echo '<label for="genres">Genres in json format</label>';
    echo '<input type="text" id="genres" name="genres" required>';
    echo '<label for="length">Length (HH:MM:SS)</label>';
    echo '<input type="text" id="length" name="length" required>';
    echo '<label for="rating">Rating</label>';
    echo '<input type="text" id="rating" name="rating" required>';
    echo '<label for="trailer">Trailer url</label>';
    echo '<input type="text" id="trailer" name="trailer" required>';
    echo '<label for="cover">Cover url</label>';
    echo '<input type="text" id="cover" name="cover" required>';
    echo '<label for="release_date">Release Date (YYYY-MM-DD)</label>';
    echo '<input type="text" id="release_date" name="release_date" required>';
    echo '<label for="price">Price</label>';
    echo '<input type="text" id="price" name="price" required>';
    echo '<label for="available">Available (0 or 1)</label>';
    echo '<input type="text" id="available" name="available" required>';
    echo '<label for="collection">Collection id</label>';
    echo '<input type="text" id="collection" name="collection">';
    echo '<label for="collection_pos">Collection Position</label>';
    echo '<input type="text" id="collection_pos" name="collection_pos">';
    echo '<input type="submit" value="Add Movie">';



    ?>

    <script>
        // Ajax call to add movie
        $("#add-movie-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/includes/inc.add_movie.php",
                data: $("#add-movie-form").serialize(),
                success: function(data) {
                    if (data == "success") {
                        alert("Movie added successfully");
                        
                    } else {
                        alert(data);
                    }
                }
            });
        });
        
    </script>


</body>
</html>