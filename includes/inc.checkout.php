<?php
session_start();

$userid = $_POST['user_id'];

include_once 'inc.mysqlCon.php';

// Get the user's shopping cart
$stmt = $conn->prepare("SELECT * FROM shopping_cart WHERE user_id = ?;");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$rows = mysqli_num_rows($result);

// Add the movies to the user's rentals (table: current_rentals)
// Values (combined_id, user_id, movie_id, price, date_rented, date_expired)
while($row = mysqli_fetch_assoc($result)) {
    // Get the movie price from the movies table
    $movie_id = $row['movie_id'];
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?;");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $movieResult = $stmt->get_result();
    $movieRow = mysqli_fetch_assoc($movieResult);



    $combined_id = $row['combined_id'];
    $user_id = $row['user_id'];
    $movie_id = $row['movie_id'];
    $price = $movieRow['price'];
    $date_rented = new DateTime();
    $date_expired = new DateTime();
    $date_expired->modify('+48 hours');
    $date_rented = $date_rented->format('Y-m-d H:i:s');
    $date_expired = $date_expired->format('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO current_rentals (combined_id, user_id, movie_id, price, date_rented, date_expired) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("siisss", $combined_id, $user_id, $movie_id, $price, $date_rented, $date_expired);
    $stmt->execute();
}

// Delete the user's shopping cart
$stmt = $conn->prepare("DELETE FROM shopping_cart WHERE user_id = ?;");
$stmt->bind_param("i", $userid);
$stmt->execute();


// Send confrimation message
echo json_encode(['status' => 'success', 'message' => 'Movies rented']);
exit();




?>