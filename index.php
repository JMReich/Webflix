<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.41, maximum-scale=1" />
    <link type="text/css" rel="stylesheet" href="/CSS/flickity.css" media="screen">
    <link type="text/css" rel='stylesheet' href="CSS/mainContent.css">
    <link type="text/css" rel='stylesheet' href="CSS/movieRow.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- loads the rest of the head and the begining of the body -->
    <?php
        include_once 'includes/inc.topnav.php';
    ?>


    <?php
        include_once 'includes/inc.mysqlCon.php';
    ?>

    <div class="main-content">
        

        <!-- If signed in -->
        <!-- 
            -display a row if they have current rentals
            -display a row if they have past rentals (10 at a time?)
            -display a row of recommended movies 
        -->

        <!-- If not signed in -->

        <!-- Show for both -->
        <!-- 
            -display a row of new releases
            -display a row of popular movies (based on 7 day count: Top 10)
            
        -->
        <h3 class="gallery-header">Most Recent Releases</h3>
        <div class="main-gallery">
            <?php
                include_once 'includes/inc.displayMovieRows.php';
                getMostRecentReleases($conn);
            ?>
        </div>
        
        <h3 class="gallery-header">Popular Movies</h3>
        <div class="main-gallery">
            <?php
                
                getPopularMovies($conn);
            ?>
        </div>


        <?php
            getRandomCollection($conn);

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
</body>
</html>