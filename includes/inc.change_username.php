<?php
    include_once 'inc.mysqlCon.php';
    session_start();

    if (empty($_POST['new-username'])) {
        echo 'New username is required';
    } if (strlen($_POST['new-username']) < 8) {
        echo 'New username must be at least 8 characters';
    } else if (strlen($_POST['new-username']) > 20) {
        echo 'New username must be less than 20 characters';
    } else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['new-username'])) {
        echo 'New username must be alphanumeric';
    } else {
        // Check if the username already exists
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'Error';
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_POST['new-username']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                echo 'Username already taken';
            } else {
                // Update the username
                $sql = "UPDATE accounts SET username = ? WHERE username = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $_POST['new-username'], $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    $_SESSION['username'] = $_POST['new-username'];
                    echo 'success';
                    exit();
                }
            }
        }
    }


?>


