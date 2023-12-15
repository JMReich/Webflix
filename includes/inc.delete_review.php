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
        header("Location: /index.php");
        exit();
    }

    // Check if the user entered a user id and movie id
    if (!isset($_POST['user-id']) || !isset($_POST['movie-id'])) {
        echo "Please enter a user id and movie id";
        exit();
    }

    // delete review
    $sql = "DELETE FROM movie_review WHERE user_id = ? AND movie_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Error';
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $_POST['user-id'], $_POST['movie-id']);
        mysqli_stmt_execute($stmt);
        echo 'success';
        exit();
    }
    






?>