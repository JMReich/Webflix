
<?php
session_start();


?>
    
    
    <link type="text/css" rel='stylesheet' href="/CSS/navBar.css">
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer" 
    />
    
    <title>Webflix</title>
</head>
<body>
<div class="top-nav-div">
        <div class="nav-size">
            <div class="row-1"> <!-- Logo, search, sign in/ sing up -->
                <!-- Logo -->
                <div class="logo">
                    <a href="/index.php">Webflix</a>
                </div>

                <!-- Search -->
                <div class="search">
                    <form action="/search.php" method="GET">
                        <div class="search-wrapper">
                            <input type="text" name="search" id="search-bar" placeholder="Search Movies...">
                            <button type="submit" name="submit-search"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <?php
                // If not logged in
                if (!isset($_SESSION['username'])) {
                    echo '<div class="sign-in-up">';
                    echo '<li><a href="/login.php">Sign-in</a></li>';
                    echo '<li>•</li>'; // bullet point seperator
                    echo '<li><a href="/signup.php">Sign-up</a></li>';
                    echo '</div>';
                } else {
                    // If logged in
                    echo '<div class="sign-in-up">';
                    // Delete cookies/log out user and redirect to home page
                    echo '<li><a href="/includes/inc.signout.php">Sign-out</a></li>';
                    echo '<li>•</li>'; // bullet point seperator
                    echo '<li><a href="/settings.php">Settings</a></li>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="row-2"> <!-- Links, Checkout -->
                <div class="links">
                    <li><a href="/index.php" id="home">Home</a></li>
                    <li><a href="/about.php">About</a></li>
                    
                    <!-- only show if logged in -->
                    <?php
                        // Check if the user is logged in
                        if (isset($_SESSION['username'])) {
                            // If logged in, show the current rentals and past rentals links
                            echo '<li><a href="/current_rentals.php">Current Rentals</a></li>';
                            echo '<li><a href="/past_rentals.php">Past Rentals</a></li>';
                        }

                    ?>

                </div>

                <div class="checkout">
                    <a href="/checkout.php"><i class="fas fa-shopping-cart"></i></a>
                </div>

            </div>
        
            
        </div>
    </div>


    <script>
        // Underline the current page in the nav bar
        var url = window.location.href;
        var page = url.substring(url.lastIndexOf('/') + 1);
        if (page == "") {
            page = "index.php";
        }
        var links = document.querySelectorAll(".links a");
        for (var i = 0; i < links.length; i++) {
            if (links[i].href.indexOf(page) != -1) {
                links[i].classList.add("underline");
            }
        }
        // underline #home if the current page is home
        if (page == "home") {
            document.getElementById("home").classList.add("underline");
        }
    </script>
    <script>
        //underlines the current page in the nav bar in the sign-up/sign-in section
        var url = window.location.href;
        var page = url.substring(url.lastIndexOf('/') + 1);
        if (page == "") {
            page = "index.php";
        }
        var links = document.querySelectorAll(".sign-in-up a");
        for (var i = 0; i < links.length; i++) {
            if (links[i].href.indexOf(page) != -1) {
                links[i].classList.add("underline");
            }
        }
    </script>
    <script>
        //underlines the current page in the nav bar in the checkout section
        var url = window.location.href;
        var page = url.substring(url.lastIndexOf('/') + 1);
        if (page == "") {
            page = "index.php";
        }
        var links = document.querySelectorAll(".checkout a");
        for (var i = 0; i < links.length; i++) {
            if (links[i].href.indexOf(page) != -1) {
                links[i].classList.add("underline");
            }
        }
    </script>