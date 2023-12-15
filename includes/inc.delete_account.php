<?php


    include_once 'inc.mysqlCon.php';
    session_start();

    if (empty($_POST['password'])) {
        echo 'Password is required';
    } else {
        // Check if the password is correct
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'Error';
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $pwdCheck = password_verify($_POST['password'], $row['password']);
            if ($pwdCheck == false) {
                echo 'Incorrect password';
            } else {
                // Delete the accounts past rentals
                $sql = "DELETE FROM past_rentals WHERE user_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
                    mysqli_stmt_execute($stmt);
                }
                // Delete the accounts current rentals
                $sql = "DELETE FROM current_rentals WHERE user_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
                    mysqli_stmt_execute($stmt);
                }
                // Delete the accounts reviews
                $sql = "DELETE FROM movie_reviews WHERE user_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
                    mysqli_stmt_execute($stmt);
                }




                // Delete the account
                $sql = "DELETE FROM accounts WHERE username = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    echo 'success';
                    //end session
                    session_unset();
                    session_destroy();
                    exit();
                }
            }
        }
    }





?>