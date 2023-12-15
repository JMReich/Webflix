<?php
    include_once 'inc.mysqlCon.php';
    session_start();

    // Add movie to specified account
    $sql = "INSERT INTO current_rentals (combined_id, user_id, movie_id, date_rented, date_expired) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Error';
    } else {
        // Combine id
        $combined_id = $_SESSION['user_id'] . $_GET['movie_id'];
        // Get the current date
        $date = date("Y-m-d");
        // Get the date two days from now
        $twoDays = date('Y-m-d', strtotime($date. ' + 2 days'));

        mysqli_stmt_bind_param($stmt, "sssss", $combined_id, $_SESSION['user_id'], $date, $twoDays);
        mysqli_stmt_execute($stmt);
        echo 'success';
        exit();
    }





?>