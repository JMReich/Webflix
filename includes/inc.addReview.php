<?php
session_start();

// Uppload the user's review to the database

$userid = $_POST['user_id'];
$movieid = $_POST['movie_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];


include_once 'inc.mysqlCon.php';

// Insert the review into the database
$stmt = $conn->prepare("INSERT INTO movie_reviews (user_id, movie_id, stars, review) VALUES (?, ?, ?, ?);");
$stmt->bind_param("iiis", $userid, $movieid, $rating, $review);
$stmt->execute();


// Send confrimation message
echo json_encode(['status' => 'success', 'message' => 'Review added']);
exit();




?>