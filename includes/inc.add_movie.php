<?php

include_once 'inc.mysqlCon.php';
session_start();

// check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    echo 'You do not have permission to add a movie';
    exit();
}

// insert into movies table
// no checks for now since it is an admin account

$sql = "INSERT INTO movies (name, genres, length, rating, trailer, cover, release_date, price, available, collection_id, collection_position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo 'Error';
} else {
    mysqli_stmt_bind_param($stmt, "sssssssssss", $_POST['name'], $_POST['genres'], $_POST['length'], $_POST['rating'], $_POST['trailer'], $_POST['cover'], $_POST['release_date'], $_POST['price'], $_POST['available'], $_POST['collection'], $_POST['collection_pos']);
    mysqli_stmt_execute($stmt);
    echo 'success';
    exit();
}



?>