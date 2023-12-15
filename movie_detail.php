<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.41, maximum-scale=1" />
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/mainContent.css">
    <link type="text/css" rel='stylesheet' href="/CSS/movieDetail.css">
    <link type="text/css" rel='stylesheet' href="/CSS/movieRow.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- loads the rest of the head and the begining of the body -->
    <?php
        include_once 'includes/inc.topnav.php';
        include_once 'includes/inc.mysqlCon.php';
        include_once 'includes/inc.displayMovieRows.php';


    ?>    
    <div class="main-content">
        <?php 
            if(null !== ($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM movies WHERE id = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $resultCheck = mysqli_num_rows($result);
                
                
                

                if($resultCheck > 0) { // If there are movies in the database
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="movie">';
                        echo '<iframe width="100%" height="500rem" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="true"
                        src="' . $row['trailer'] .'">
                        </iframe>';
                        echo '<div class="movie-info">';
                        echo '<h3>' . $row['name'] . '</h3>';

                        // display stars if not null
                        if ($row['stars'] != null) {
                            echo '<div class="card">';
                            if ($row['stars'] == 5) {
                                echo '
                                <span onclick="gfg(1)" 
                                    class="starz five">★ 
                                </span>
                                <span onclick="gfg(2)" 
                                    class="starz five">★ 
                                </span> 
                                <span onclick="gfg(3)" 
                                    class="starz five">★ 
                                </span> 
                                <span onclick="gfg(4)" 
                                    class="starz five">★ 
                                </span> 
                                <span onclick="gfg(5)" 
                                    class="starz five">★ 
                                </span>
                                ';
                            } else if ($row['stars'] == 4) {
                                echo '
                                <span onclick="gfg(1)" 
                                    class="starz four">★
                                </span>
                                <span onclick="gfg(2)" 
                                    class="starz four">★
                                </span>
                                <span onclick="gfg(3)" 
                                    class="starz four">★
                                </span>
                                <span onclick="gfg(4)" 
                                    class="starz four">★
                                </span>
                                <span onclick="gfg(5)" 
                                    class="starz">★
                                </span>

                                ';
                            } else if ($row['stars'] == 3) {
                                echo '
                                <span onclick="gfg(1)" 
                                    class="starz three">★
                                </span>
                                <span onclick="gfg(2)" 
                                    class="starz three">★
                                </span>
                                <span onclick="gfg(3)" 
                                    class="starz three">★
                                </span>
                                <span onclick="gfg(4)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(5)" 
                                    class="starz">★ 
                                </span>
                                ';
                            } else if ($row['stars'] == 2) {
                                echo '
                                <span onclick="gfg(1)" 
                                    class="starz two">★
                                </span>
                                <span onclick="gfg(2)" 
                                    class="starz two">★
                                </span>
                                <span onclick="gfg(3)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(4)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(5)" 
                                    class="starz">★
                                </span>
                                ';
                            } else if ($row['stars'] == 1) {
                                echo '
                                <span onclick="gfg(1)" 
                                    class="starz one">★
                                </span>
                                <span onclick="gfg(2)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(3)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(4)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(5)" 
                                    class="starz">★
                                </span>
                                ';
                            } else {
                                echo '
                                <span onclick="gfg(1)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(2)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(3)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(4)" 
                                    class="starz">★
                                </span>
                                <span onclick="gfg(5)" 
                                    class="starz">★
                                </span>
                                ';
                            }
                            echo '</div>';
                        }

                        echo '<p>Release Date: ' . $row['release_date'] . '</p>';
                        echo '<p>Rating: ' . $row['rating'] . '</p>';

                        

                        // If user is logged in
                        if (isset($_SESSION['username'])) {
                            // Check if is currently renting the movie
                            $stmt = $conn->prepare("SELECT * FROM current_rentals WHERE movie_id = ? AND user_id = ?;");
                            $stmt->bind_param("ii", $row['id'], $_SESSION['id']);
                            $stmt->execute();
                            $userRenting = $stmt->get_result();
                            $rows = mysqli_num_rows($userRenting);
                            
                            if ($rows > 0) {
                                // If user is renting the movie
                                // Display play button and return date
                                $info = mysqli_fetch_assoc($userRenting);
                                echo '<p>Experation Date: ' . $info['date_expired'] . '</p>';
                                echo '<form action="/playMovie.php?movie_id="' . $row['id'] . '" method="POST" class="play" id="play">';
                                echo '<input type="hidden" name="movie_id="' . $row['id'] . '" value="' . $row['id'] . '">';
                                echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">';
                                echo '<input type="submit" value="Play">';
                                echo '</form>';
                            }
                            else {
                                // Check if user has rented the movie in the past
                                $stmt = $conn->prepare("SELECT * FROM past_rentals WHERE movie_id = ? AND user_id = ?;");
                                $stmt->bind_param("ii", $row['id'], $_SESSION['id']);
                                $stmt->execute();
                                $userRenting = $stmt->get_result();
                                $rows = mysqli_num_rows($userRenting);

                                if ($rows > 0) {
                                    // If user has rented the movie in the past
                                    // Display rent again button
                                    echo '<form action="/includes/inc.addToCart.php" method="POST" class="addToCart" id="addToCartForm">';
                                    echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">';
                                    echo '<input type="submit" value="Rent Again">';
                                    echo '</form>';
                                }
                                else {
                                    // If user has not rented the movie
                                    // Display rent button
                                    echo '<form action="/login.php" method="POST" class="addToCart" id="addToCartForm">';
                                    echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">';
                                    echo '<input type="submit" value="Rent">';
                                    echo '</form>';
                                }
                                
                            }
                            
                        } else {
                            echo '<form action="/login.php" method="POST" class="addToCart" id="addToCartForm">';
                            echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">';
                            echo '<input type="submit" value="Rent">';
                            echo '</form>';
                        }
                        




                        echo '</div>';
                        
                    }
                }
                else {
                    echo '<p>Server Error</p>';
                }
                

                // display collection if movie is in one
                getCollection($conn, $id);

                // TODO display similar movies based on genre
                //getSimilarMovies($conn, $id);
                


                
                $id = $_GET['id'];
                $sql = "SELECT * FROM movies WHERE id = $id;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);
                
                echo '<div class="movie-reviews">';
                echo '<h3>Reviews</h3>';
                echo '<div class="review-enter-box">';

                // Check if user has already reviewed the movie
                if (isset($_SESSION['username'])) {
                    $stmt = $conn->prepare("SELECT * FROM movie_reviews WHERE user_id = ? AND movie_id = ?;");
                    $stmt->bind_param("ii", $_SESSION['id'], $row['id']);
                    $stmt->execute();
                    $userRenting = $stmt->get_result();
                    $rows = mysqli_num_rows($userRenting);

                    
                    
                    if ($rows > 0) {
                        // If user has already reviewed the movie
                        // Fill their review into a review form for editing
                        $info = mysqli_fetch_assoc($userRenting);
                        echo '<div class="star-rating-selection">';
                        echo '<div class="card">';
                        if ($info['stars'] == 5) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="star five" id="star-check">★ 
                            </span>
                            <span onclick="gfg(2)" 
                                class="star five">★ 
                            </span> 
                            <span onclick="gfg(3)" 
                                class="star five">★ 
                            </span> 
                            <span onclick="gfg(4)" 
                                class="star five">★ 
                            </span> 
                            <span onclick="gfg(5)" 
                                class="star five">★ 
                            </span>
                            ';
                        } else if ($info['stars'] == 4) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="star four" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="star four">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="star four">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="star four">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="star">★
                            </span>

                            ';
                        } else if ($info['stars'] == 3) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="star three" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="star three">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="star three">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="star">★ 
                            </span>
                            ';
                        } else if ($info['stars'] == 2) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="star two" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="star two">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="star">★
                            </span>
                            ';
                        } else if ($info['stars'] == 1) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="star one" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="star">★
                            </span>
                            ';
                        } else {
                            echo '
                            <span onclick="gfg(1)" 
                                class="star" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="star">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="star">★
                            </span>
                            ';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<form action="/includes/inc.editReview.php" method="POST" class="edit-review">';
                        echo '<input type="hidden" name="movie_id" value="' . $info['movie_id'] . '">';
                        echo '<input type="hidden" name="user_id" id="rating" value="' . $_SESSION['id'] . '">';
                        echo '<textarea name="review" id="review" placeholder="Enter your review here">' . $info['review'] . '</textarea>';
                        echo '<input type="submit" value="Edit Review">';
                    } // if user is logged in and is renting or has rented the movie display review enter box
                    else if (isset($_SESSION['username'])) {
                        echo '<div class="star-rating-selection">';
    
    
                        // Check if is currently renting the movie
                        $stmt = $conn->prepare("SELECT * FROM current_rentals WHERE user_id = ? AND movie_id = ?;");
                        $stmt->bind_param("ii", $_SESSION['id'], $row['id']);
                        $stmt->execute();
                        $userRenting = $stmt->get_result();
                        $rows = mysqli_num_rows($userRenting);
                        
                        
                        if ($rows > 0) {
                            // If user is renting the movie
                            // Display play button and return date
    
                            echo '
                                <div class="card"> 
                                 
                                <span onclick="gfg(1)" 
                                    class="star" id="star-check">★ 
                                </span> 
                                <span onclick="gfg(2)" 
                                    class="star">★ 
                                </span> 
                                <span onclick="gfg(3)" 
                                    class="star">★ 
                                </span> 
                                <span onclick="gfg(4)" 
                                    class="star">★ 
                                </span> 
                                <span onclick="gfg(5)" 
                                    class="star">★ 
                                </span> 
                                
                                </div> ';
                            echo '</div>';
                            echo '<form action="/includes/inc.addReview.php" method="POST" class="post-review">';
                            echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">';
                            echo '<input type="hidden" name="user_id" id="rating" value="' . $_SESSION['id'] . '">';
                            echo '<textarea name="review" id="review" placeholder="Enter your review here"></textarea>';
                            echo '<input type="submit" value="Submit Review">';
                            echo '</form>';
                        }
                        else {
                            // Check if user has rented the movie in the past
                            $stmt = $conn->prepare("SELECT * FROM past_rentals WHERE user_id = ? AND movie_id = ?;");
                            $stmt->bind_param("ii", $_SESSION['id'], $row['id']);
                            $stmt->execute();
                            $userRenting = $stmt->get_result();
                            $rows = mysqli_num_rows($userRenting);
    
                            if ($rows > 0) {
                                // If user has rented the movie in the past
                                // Display review enter box
                                $info = mysqli_fetch_assoc($result);
                                echo '<form action="/includes/inc.addReview.php" method="POST" class="post-review">';
                                echo '<input type="hidden" name="movie_id" value="' . $info['id'] . '">';
                                echo '<input type="hidden" name="user_id" id="rating" value="' . $_SESSION['id'] . '">';
                                echo '<textarea name="review" id="review" placeholder="Enter your review here"></textarea>';
                                echo '<input type="submit" value="Submit Review">';
                                echo '</form>';
                            }
                        }
                        
                    }
                } 
                echo '</div>';

                // display reviews (10 at a time)
                // TODO add pagination to reviews to show all of them
                $stmt = $conn->prepare("SELECT * FROM movie_reviews WHERE movie_id = ? ORDER BY id DESC LIMIT 10;");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $rows = mysqli_num_rows($result);

                if ($rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="review">';
                        echo '<div class="card">';
                        if ($row['stars'] == 5) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="starz five" id="star-check">★ 
                            </span>
                            <span onclick="gfg(2)" 
                                class="starz five">★ 
                            </span> 
                            <span onclick="gfg(3)" 
                                class="starz five">★ 
                            </span> 
                            <span onclick="gfg(4)" 
                                class="starz five">★ 
                            </span> 
                            <span onclick="gfg(5)" 
                                class="starz five">★ 
                            </span>
                            ';
                        } else if ($row['stars'] == 4) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="starz four" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="starz four">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="starz four">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="starz four">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="starz">★
                            </span>

                            ';
                        } else if ($row['stars'] == 3) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="starz three" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="starz three">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="starz three">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="starz">★ 
                            </span>
                            ';
                        } else if ($row['stars'] == 2) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="starz two" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="starz two">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="starz">★
                            </span>
                            ';
                        } else if ($row['stars'] == 1) {
                            echo '
                            <span onclick="gfg(1)" 
                                class="starz one" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="starz">★
                            </span>
                            ';
                        } else {
                            echo '
                            <span onclick="gfg(1)" 
                                class="starz" id="star-check">★
                            </span>
                            <span onclick="gfg(2)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(3)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(4)" 
                                class="starz">★
                            </span>
                            <span onclick="gfg(5)" 
                                class="starz">★
                            </span>
                            ';
                        }
                        echo '</div>';
                        echo '<p>' . $row['review'] . '</p>';
                        
                        echo '</div>';
                    }
                }
                else {
                    echo '<p>No reviews yet</p>';
                }
                echo '</div>';



            }

        ?>


    </div>

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

    <script>
        // To access the stars 
        let stars =  
            document.getElementsByClassName("star"); 

        
        // Funtion to update rating 
        function gfg(n) { 
            remove(); 
            for (let i = 0; i < n; i++) { 
                if (n == 1) cls = "one"; 
                else if (n == 2) cls = "two"; 
                else if (n == 3) cls = "three"; 
                else if (n == 4) cls = "four"; 
                else if (n == 5) cls = "five"; 
                stars[i].className = "star " + cls; 
            } 
            
        } 
        
        // To remove the pre-applied styling 
        function remove() { 
            let i = 0; 
            while (i < 5) { 
                stars[i].className = "star"; 
                i++; 
            } 
        }


    </script>

    <script>
        // Ajax call to post review
        $(document).ready(function() {
            $('.post-review').on('submit', function(e) {
                e.preventDefault();

                
                if (document.getElementById("star-check").classList.contains("one")) {
                    rating = 1;
                }
                else if (document.getElementById("star-check").classList.contains("two")) {
                    rating = 2;
                }
                else if (document.getElementById("star-check").classList.contains("three")) {
                    rating = 3;
                }
                else if (document.getElementById("star-check").classList.contains("four")) {
                    rating = 4;
                }
                else if (document.getElementById("star-check").classList.contains("five")) {
                    rating = 5;
                }
                else {
                    rating = 0;
                }


                $.ajax({
                    type: "POST",
                    url: "/includes/inc.addReview.php",
                    data: {
                        movie_id: $(this).find('input[name="movie_id"]').val(),
                        user_id: $(this).find('input[name="user_id"]').val(),
                        review: $(this).find('textarea[name="review"]').val(),
                        rating: rating
                    },
                    
                    success: function(response) {
                        console.log(response);
                        location.reload(true);
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });

        // Ajax to update review
        $(document).ready(function() {
            $('.edit-review').on('submit', function(e) {
                e.preventDefault();

                
                if (document.getElementById("star-check").classList.contains("one")) {
                    rating = 1;
                }
                else if (document.getElementById("star-check").classList.contains("two")) {
                    rating = 2;
                }
                else if (document.getElementById("star-check").classList.contains("three")) {
                    rating = 3;
                }
                else if (document.getElementById("star-check").classList.contains("four")) {
                    rating = 4;
                }
                else if (document.getElementById("star-check").classList.contains("five")) {
                    rating = 5;
                }
                else {
                    rating = 0;
                }

                $.ajax({
                    type: "POST",
                    url: "/includes/inc.updateReview.php",
                    data: {
                        movie_id: $(this).find('input[name="movie_id"]').val(),
                        user_id: $(this).find('input[name="user_id"]').val(),
                        review: $(this).find('textarea[name="review"]').val(),
                        rating: rating
                    },
                    
                    success: function(response) {
                        console.log(response);
                        location.reload(true);
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });

        // Ajax to handle play form
        $(document).ready(function() {
            $('.play').on('submit', function(e) {
                e.preventDefault();
                window.location.href = "/playMovie.php?movie_id=" + $(this).find('input[name="movie_id"]').val();
                
            });
        });
        


    </script>


    <script>
        // Ajax call to add movie to shopping cart
        $(document).ready(function() {
            $('.addToCart').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "/includes/inc.addToCart.php",
                    data: {
                        movie_id: $(this).find('input[name="movie_id"]').val()
                    },
                    
                    success: function(response) {
                        console.log(response);
                        response = JSON.parse(response);
                        if (response.status == "success") {
                            alert(response.message);
                        }
                        else if (response.status == "login") {
                            window.location.href = "/login.php";
                        }
                        else {
                            alert(response[0].message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });


            

        });

    </script>
    
</div>
</body>
</html>