<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/mainContent.css">
    <link type="text/css" rel='stylesheet' href="/CSS/checkout.css">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/movieRow.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php
        include_once 'includes/inc.topnav.php';
        include_once 'includes/inc.mysqlCon.php';
        


    ?>  

    <div class="main-content">
        <?php
        // Check if the user is logged in
        if (!isset($_SESSION['username'])) {
            // If not logged in, redirect to login page
            header("Location: /login.php");
            exit();
        }

        // Check if the user has any past rentals
        $stmt = $conn->prepare("SELECT * FROM past_rentals WHERE user_id = ?;");
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = mysqli_num_rows($result);

        if ($rows > 0) {
            // If the user has past rentals
            // Display the movies in their past rentals
            echo '<h1>Past Rentals</h1>';
            echo '<div class="main-gallery">';
            while($row = mysqli_fetch_assoc($result)) {
                $movie_id = $row['movie_id'];
                $sql = "SELECT * FROM movies WHERE id = $movie_id;";
                $movieResult = mysqli_query($conn, $sql);
                $movieResultCheck = mysqli_num_rows($movieResult);
                if($movieResultCheck > 0) { // If there are movies in the database
                    while($movieRow = mysqli_fetch_assoc($movieResult)) {
                        echo '<div class="gallery-cell">';
                        $name = $movieRow['name'];
                        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
                        $name = str_replace('\'', '', $name); // Remove apostrophes
                        $name = strtolower($name);
                        echo '<a href="/' . $name . '/' . $movieRow['id'] . '"><img src="' . $movieRow['cover'] . '" alt="' . $movieRow['name'] . '" class="movie-cover"></a>';
                        echo '</div>';
                    }
                }
            }
            echo '</div>';
        } else {
            // If the user has no past rentals
            echo '<h1>You have no past rentals</h1>';
        }


        ?>




        <script src="/javascript/flickity.pkgd.min.js"></script>
        <script>
            $('.main-gallery').flickity({
                // options
                cellAlign: 'left',
                contain: true,
                freeScroll: false, // disable freeScroll for groupCells to work
                groupCells: true,
                pageDots: false,
                wrapAround: true
            }).css('opacity', '1');

        </script>

    </div>
</body>
</html>