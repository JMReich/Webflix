<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="/CSS/mainContent.css">
    <link type="text/css" rel='stylesheet' href="/CSS/checkout.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php
        include_once 'includes/inc.topnav.php';
        include_once 'includes/inc.mysqlCon.php';
        


    ?>  

    <div class="main-content">
        <?php
        if (!isset($_SESSION['username'])) {
            // redirect to login page
            header("Location: /login.php");
            exit();
        } 
        loadCheckout($conn);

        function loadCheckout($conn) {
            //if the user is not logged redirect to the login page
            if (!isset($_SESSION['username'])) {
                // redirect to login page
                header("Location: /login.php");
                exit();
            } 
            else {
                // Check if the user has any movies in their shopping_cart
                $stmt = $conn->prepare("SELECT * FROM shopping_cart WHERE user_id = ?;");
                $stmt->bind_param("i", $_SESSION['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $rows = mysqli_num_rows($result);
                $totalCost = 0.0;

                if ($rows > 0) {
                    // If the user has movies in their shopping_cart
                    // Display the movies in their shopping_cart with a button to remove it from the shopping cart
                    // do not use flikity for this
                    echo '<h1>Shopping Cart</h1>';
                    echo '<div class="checkout-container">'; 
                    echo '<div class="left-side">';
                    while($row = mysqli_fetch_assoc($result)) {
                        $movie_id = $row['movie_id'];
                        $sql = "SELECT * FROM movies WHERE id = $movie_id;";
                        $movieResult = mysqli_query($conn, $sql);
                        $movieResultCheck = mysqli_num_rows($movieResult);
                        if($movieResultCheck > 0) { // If there are movies in the database
                            while($movieRow = mysqli_fetch_assoc($movieResult)) {
                                echo '<div class="movie">';
                                echo '<img src="' . $movieRow['cover'] . '" alt="' . $movieRow['name'] . '">';
                                echo '<div class="movie-info">';
                                echo '<h3>' . $movieRow['name'] . '</h3>';
                                echo '<p>Release Date: ' . $movieRow['release_date'] . '</p>';
                                echo '<p>Rating: ' . $movieRow['rating'] . '</p>';
                                echo '<p>Price: $' . $movieRow['price'] . '</p>';
                                echo '<form action="/includes/inc.removeFromCart.php" method="POST" class="delete">';
                                echo '<input type="hidden" name="movie_id" id="movie_id" value="' . $movieRow['id'] . '">';
                                echo '<input type="hidden" name="user_id" id="user_id" value="' . $_SESSION['id'] . '">';
                                echo '<input type="submit" value="Remove From Cart">';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                                $totalCost += $movieRow['price'];
                            }
                            
                        }
                    }
                    echo '</div>';
                    echo '<div class="right-side">';
                    echo '<h1>Checkout</h1>';
                    echo '<h4>Total Cost: $' . $totalCost . '</h4>';
                    echo '<p>(This is a demo site, just press checkout without filling out the form)</p>';
                    echo '<form action="/includes/inc.checkout.php" method="POST" class="checkout-form">';
                    echo '<input type="hidden" name="user_id" id="user_id" value="' . $_SESSION['id'] . '">'; // hidden input for user_id
                    echo '<label for="cardNumber">Card Number:</label>';
                    echo '<input type="text" id="cardNumber" name="cardNumber" >';
                    echo '<label for="cardName">Name on Card:</label>';
                    echo '<input type="text" id="cardName" name="cardName" >';
                    echo '<label for="cardExp">Expiration Date:</label>';
                    echo '<input type="text" id="cardExp" name="cardExp" >';
                    echo '<label for="cardCVV">CVV:</label>';
                    echo '<input type="text" id="cardCVV" name="cardCVV" >';
                    echo '<input type="submit" value="Checkout">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';

                    
                }
                else {
                    // If the user does not have any movies in their shopping_cart
                    // Display a message
                    echo '<h1>Shopping Cart</h1>';
                    echo '<p>You do not have any movies in your shopping cart.</p>';
                    
                }
            }
        }
        ?>

        <script>
            //ajax call to remove movie from shopping cart and reload content
            $(document).ready(function() {
                $('.delete').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '/includes/inc.removeFromCart.php',
                        data: $(this).serialize(),
                        success: function(data) {
                            //reload content
                            console.log(data);
                            window.location.href = "/checkout.php";
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    })
                })
            })


            //ajax call to checkout and reload content
            $(document).ready(function() {
                $('.checkout-form').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '/includes/inc.checkout.php',
                        data: $(this).serialize(),
                        success: function(data) {
                            //reload content
                            console.log(data);
                            window.location.href = "/current_rentals.php";
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    })
                })
            })

        </script>


    </div>
</body>
</html>