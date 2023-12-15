
<?php
    include_once 'inc.mysqlCon.php';
    session_start();

    if (empty($_POST['new-email'])) {
        echo 'New email is required';
    } else if (!filter_var($_POST['new-email'], FILTER_VALIDATE_EMAIL)) {
        echo 'New email must be a valid email address';
    } else {
        // Check if the email already exists
        $sql = "SELECT * FROM accounts WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'Error';
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_POST['new-email']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                echo 'Email already taken';
            } else {
                // Update the email
                $sql = "UPDATE accounts SET email = ? WHERE username = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'Error';
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $_POST['new-email'], $_SESSION['username']);
                    mysqli_stmt_execute($stmt);
                    echo 'success';
                }
            }
        }
    }


?>