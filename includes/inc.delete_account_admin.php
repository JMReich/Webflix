<?php
    include_once 'inc.mysqlCon.php';
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // If not logged in, redirect to login page
        header("Location: /login.php");
        exit();
    }

    // Check if the user is an admin
    if ($_SESSION['role'] != 'admin') {
        //send them back to the home page
        header("Location: /index.php");
        exit();
    }


    // Check if the user_id is set
    if (!isset($_POST['user-id'])) {
        echo "Please enter a user ID";
        exit();
    }

    // Check if the user_id is valid
    if (!is_numeric($_POST['user-id'])) {
        echo "Please enter a valid user ID";
        exit();
    }

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Error";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $_POST['user-id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 0) {
            echo "User does not exist";
            exit();
        }
    }

    // Delete the accounts past rentals
    $sql = "DELETE FROM past_rentals WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Error';
    } else {
        mysqli_stmt_bind_param($stmt, "s", $_POST['user-id']);
        mysqli_stmt_execute($stmt);
    }
    // Delete the accounts current rentals
    $sql = "DELETE FROM current_rentals WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Error';
    } else {
        mysqli_stmt_bind_param($stmt, "s", $_POST['user-id']);
        mysqli_stmt_execute($stmt);
    }
    // Delete the accounts reviews
    $sql = "DELETE FROM movie_reviews WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Error';
    } else {
        mysqli_stmt_bind_param($stmt, "s", $_POST['user-id']);
        mysqli_stmt_execute($stmt);
    }

    // Delete the account
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Error';
    } else {
        mysqli_stmt_bind_param($stmt, "s", $_POST['user-id']);
        mysqli_stmt_execute($stmt);
        echo 'success';
        exit();
    }
    

    







?>