<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/mainContent.css">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/movieRow.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php
        include_once 'includes/inc.topnav.php';
        include_once 'includes/inc.mysqlCon.php';
        


    ?>  

    <div class="main-content">
        <?php
        // Read ?search= from URL
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $percent = '%';
            $search = $percent . $search . $percent;

            //prefill the search bar
            echo '<script>';
            echo '$(document).ready(function() {';
            echo '$("#search-bar").val("' . $_GET['search'] . '");';
            echo '});';
            echo '</script>';
            
            
            // Search for movies that match the search term
            $stmt = $conn->prepare("SELECT * FROM movies WHERE name LIKE ? LIMIT 50;");
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = mysqli_num_rows($result);

            if ($rows > 0) {
                // If there are movies that match the search term
                // Display the movies
                echo '<h1>Search Results</h1>';
                // Provide a drop down box to allow the user to filter by genre (if there are more than 1 results)
                if ($rows > 1) {
                    echo '<form action="/search.php" method="GET">';
                    echo '<select name="genre">';
                    echo '<option value="all">All</option>';
                    $genres = array();
                    while($row = mysqli_fetch_assoc($result)) {
                        $genre = $row['genres'];
                        // Convert to a json
                        $genre = json_decode($genre);
                        // Loop through each genre
                        foreach ($genre as $g) {
                            if (!in_array($g, $genres)) {
                                array_push($genres, $g);
                                echo '<option value="' . $g . '">' . $g . '</option>';
                            }
                        }
                        
                        

                    }
                    echo '</select>';
                    echo '<input type="hidden" name="search" value="' . $_GET['search'] . '">';
                    echo '<input type="submit" value="Filter">';
                    echo '</form>';
                }

                $stmt = $conn->prepare("SELECT * FROM movies WHERE name LIKE ? LIMIT 50;");
                $stmt->bind_param("s", $search);
                $stmt->execute();
                $result = $stmt->get_result();
                $rows = mysqli_num_rows($result);

                echo '<div class="search-results">';
                while($row = mysqli_fetch_assoc($result)) {
                    // Check if genre is set
                    if (isset($_GET['genre'])) {
                        // If genre is set, check if the movie matches the genre
                        $genre = $row['genres'];
                        // Convert to a json
                        $genre = json_decode($genre);
                        // Loop through each genre
                        $match = false;
                        foreach ($genre as $g) {
                            if ($g == $_GET['genre']) {
                                $match = true;
                            }
                        }
                        if ($match == false) {
                            // If the movie does not match the genre, skip it
                            continue;
                        } else {
                            // If the movie matches the genre, display it
                            echo '<div class="movie-cell">';
                            $name = $row['name'];
                            $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
                            $name = str_replace('\'', '', $name); // Remove apostrophes
                            $name = strtolower($name);
                            echo '<a href="/' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
                            echo '</div>';
                        }
                    } else {
                        // If genre is not set, display the movie
                        echo '<div class="movie-cell">';
                        $name = $row['name'];
                        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
                        $name = str_replace('\'', '', $name); // Remove apostrophes
                        $name = strtolower($name);
                        echo '<a href="/' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
                        echo '</div>';
                    }




                    
                }
                echo '</div>';
            } else {
                // If there are no movies that match the search term
                echo '<h1>No Results Found</h1>';
            }



        } else {
            // If no search term is provided, redirect to home page
            header("Location: /index.php");
            exit();
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