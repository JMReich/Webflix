<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel='stylesheet' href="CSS/navBar.css">
    <title>Webflix</title>
</head>
<body>
    <div class="top-nav-div">
        <!-- Logo -->
        <div class="logo">
            <img src="images/logo.png" alt="Webflix Logo">
        </div>
        <!-- Search bar -->
        <div class="search-bar">
            <input type="text" placeholder="Search">
        </div>
        <!-- Filter Menu -->
        <div class="search-filters">
            <span>Hover here</span>
            <div class="dropdown">
                <!-- Genre: select one -->
                <select name="genre" id="genre">
                    <option value="genre">Genre</option>
                    <option value="action">Action</option>
                    <option value="comedy">Comedy</option>
                    <option value="drama">Drama</option>
                    <option value="horror">Horror</option>
                    <option value="romance">Romance</option>
                    <option value="sci-fi">Sci-Fi</option>
                    <?php
                    /*
                        Pagination? Maybe?
                        Show x results until user clicks
                        show more/show all

                        TODO: Retrieve genres from database (stored as json's)
                        and display them as options in the dropdown menu
                        without duplicates.
                    */
                        $sql = "SELECT * FROM genres";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['genre_id'] . "'>" . $row['genre_name'] . "</option>";
                        }
                    ?>
                </select>
                <!-- Rating: Greater than -->
                <select name="rating" id="rating">
                    <option value="rating">Rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                <!-- Year:  -->
                <?php //make this a pick between two dates ?>
                <select name="year" id="year">
                    <option value="year">Year</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                </select>
            </div>
        </div>

        <nav class="top-nav">
            <ul class="top-nav-list">
                <li><a href="#">Home</a></li>
                <li><a href="#">TV Shows</a></li>
                <li><a href="#">Movies</a></li>
                <li><a href="#">Recently Added</a></li>
                <li><a href="#">My List</a></li>
            </ul>

    </div>
    
</body>
</html>