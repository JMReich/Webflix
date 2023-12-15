<?php
    include_once 'inc.mysqlCon.php';
    session_start();

    // Check if the user is an admin
    if ($_SESSION['role'] != 'admin') {
        //send them back to the home page
        header("Location: /index.php");
        exit();
    }

    





?>