<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/CSS/mainContent.css'>
    <link type='text/css' rel='stylesheet' href='/CSS/playMovie.css'>
    <title>Webflix</title>
</head>
<body>
    <?php
        $movieID = $_GET['movie_id'];

        include_once 'includes/inc.mysqlCon.php';

        // Get the movie trailer from the database
        $sql = "SELECT trailer FROM movies WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'Error';
        } else {
            mysqli_stmt_bind_param($stmt, "s", $movieID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            echo '<iframe width="560" height="315" src="' . $row['trailer'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
    ?>
    
</body>
</html>