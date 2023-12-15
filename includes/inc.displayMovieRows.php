<?php

// Displays the most recent movies released
function getMostRecentReleases($conn) {
    
    $sql = "SELECT * FROM movies ORDER BY release_date DESC LIMIT 10;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0) { // If there are movies in the database
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="gallery-cell">';
            $name = $row['name'];
            $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
            $name = str_replace('\'', '', $name); // Remove apostrophes
            $name = strtolower($name);
            
            echo '<a href="' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
            echo '</div>';
        }
    }
    else {
        echo '<p>Server Error</p>';
    }
}



function getPopularMovies($conn) {
    $sql = "SELECT * FROM movies ORDER BY seven_day_rentals DESC LIMIT 10;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0) { // If there are movies in the database
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="gallery-cell">';
            $name = $row['name'];
            $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
            $name = str_replace('\'', '', $name); // Remove apostrophes
            $name = strtolower($name);
            
            echo '<a href="' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
            echo '</div>';
        }
    }
    else {
        /*
        // Sends random movies if there are no popular movies in the last 7 days
        $sql = "SELECT * FROM movies ORDER BY RAND() LIMIT 10;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) { // If there are movies in the database
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="gallery-cell">';
                $name = $row['name'];
                $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
                $name = str_replace('\'', '', $name); // Remove apostrophes
                $name = strtolower($name);

                echo '<a href="' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
                echo '</div>';
            }
        }
        else {
            echo '<p>Server Error</p>';
        }
        */
    }
}


    function getRandomCollection($conn) {
        // Get random collection id from database collections table
        $sql = "SELECT * FROM collections ORDER BY RAND() LIMIT 1;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) { // If there are movies in the database
            $row = mysqli_fetch_assoc($result);
            $collection_id = $row['id'];
            $collection_name = $row['name'];

            // Get movies from database that have the collection id. Order them by collection_position
            $stmt = $conn->prepare("SELECT * FROM movies WHERE collection_id = ? ORDER BY collection_position ASC;");
            $stmt->bind_param("i", $collection_id);
            $stmt->execute();
            $result = $stmt->get_result();

            echo '<h3 class="gallery-header"> The ' . $collection_name . ' Collection</h3>';
            echo '<div class="main-gallery">';
            // loop through movies and display them
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="gallery-cell">';
                $name = $row['name'];
                $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
                $name = str_replace('\'', '', $name); // Remove apostrophes
                $name = strtolower($name);

                echo '<a href="' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
                echo '</div>';
            }
            echo '</div>';


        }
        else {
            exit;
        }




    }

    function getCollection($conn, $movie_id) {
        // Check if the movie is in a collection
        $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?;");
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        
        
        if (isset($row['collection_id'])) {
            // If the movie is in a collection
            $collection_id = $row['collection_id'];
            // Search for collection name
            $stmt = $conn->prepare("SELECT * FROM collections WHERE id = ?;");
            $stmt->bind_param("i", $collection_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = mysqli_fetch_assoc($result);
            $collection_name = $row['name'];

            // Get movies from database that have the collection id. Order them by collection_position
            $stmt = $conn->prepare("SELECT * FROM movies WHERE collection_id = ? ORDER BY collection_position ASC;");
            $stmt->bind_param("i", $collection_id);
            $stmt->execute();
            $result = $stmt->get_result();

            echo '<h3 class="gallery-header"> The ' . $collection_name . ' Collection</h3>';
            echo '<div class="main-gallery">';
            // loop through movies and display them
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="gallery-cell">';
                $name = $row['name'];
                $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Remove special characters
                $name = str_replace('\'', '', $name); // Remove apostrophes
                $name = strtolower($name);

                echo '<a href="/' . $name . '/' . $row['id'] . '"><img src="' . $row['cover'] . '" alt="' . $row['name'] . '" class="movie-cover"></a>';
                echo '</div>';
            }
            echo '</div>';
        }
        else {
            // If the movie is not in a collection
            exit;
        }




        



    }




?>