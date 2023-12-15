<?php

session_start();

// Uppload the user's review to the database
$userid = $_POST['user_id'];
$movieid = $_POST['movie_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];

include_once 'inc.mysqlCon.php';

// Update the review on the database
$stmt = $conn->prepare("UPDATE movie_reviews SET stars = ?, review = ? WHERE user_id = ? AND movie_id = ?;");
$stmt->bind_param("isii", $rating, $review, $userid, $movieid);
$stmt->execute();

// log any mysql errors



// Send confrimation message
echo json_encode(['status' => 'success', 'message' => '' . $userid . '']);
exit();




?>