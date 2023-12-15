


<?php

$user_id = $_POST['user_id'];
$movie_id = $_POST['movie_id'];
$combinedID = $user_id . $movie_id;


include_once 'inc.mysqlCon.php';

// Delete movie from shopping_cart
$stmt = $conn->prepare("DELETE FROM shopping_cart WHERE combined_id = ?;");
$stmt->bind_param("s", $combinedID);
$stmt->execute();

// Send confrimation message
echo json_encode(['status' => 'success', 'message' => 'Movie removed from cart']);
exit();




?>