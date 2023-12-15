<?php
    include_once 'inc.mysqlCon.php';
    session_start();

    if (empty($_POST['old-pw'])) {
        echo 'Old password is required';
    } else if (empty($_POST['new-pw'])) {
        echo 'New password is required';
    } else if (empty($_POST['confirm-pw'])) {
        echo 'Confirm password is required';
    } else if (strlen($_POST['new-pw']) < 8) {
        echo 'New password must be at least 8 characters';
    } else if (strlen($_POST['new-pw']) > 20) {
        echo 'New password must be less than 20 characters';
    } else if (!preg_match('/[a-z]/', $_POST['new-pw'])) {
        echo 'New password must contain at least one lowercase letter';
    } else if (!preg_match('/[A-Z]/', $_POST['new-pw'])) {
        echo 'New password must contain at least one uppercase letter';
    } else if (!preg_match('/\d/', $_POST['new-pw'])) {
        echo 'New password must contain at least one number';
    } else if (!preg_match('/[!@#\$%\^&\*\(\)_\-=+\[\]{};:\'",<.>]/', $_POST['new-pw'])) {
        echo 'New password must contain at least one special character (!@#\$%\^&\*\(\)_\-=+\[\]{};:\'",<.>])';
    } else if ($_POST['new-pw'] !== $_POST['confirm-pw']) {
        echo 'New passwords must match';
    } else {
        // Check if the old password is correct
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'Error';
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $pwdCheck = password_verify($_POST['old-pw'], $row['password']);
            if ($pwdCheck == false) {
                echo 'Incorrect password';
            } else {
                // Update the password
                $sql = "UPDATE accounts SET password = ? WHERE username = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    $hashedPwd = password_hash($_POST['new-pw'], PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    echo 'success';
                }
            }
        }
    }
    
    
    




?>