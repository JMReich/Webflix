

<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        //send the user to the login page
        echo json_encode(['status' => 'login', 'message' => 'Not logged in']);
        exit();
    }

    include_once 'inc.mysqlCon.php';

    $errors = [];
    // Check if the movie is already in the shopping cart
    $stmt = $conn->prepare("SELECT * FROM shopping_cart WHERE user_id = ? AND movie_id = ?;");
    $stmt->bind_param("ii", $_SESSION['id'], $_POST['movie_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = mysqli_num_rows($result);

    if ($rows > 0) {
        // If the movie is already in the shopping cart
        // Return error
        $errors[] = ['status' => 'error', 'message' => 'Movie already in shopping cart', 'field' => 'all'];

        echo json_encode($errors);
        exit;
    }

    // Check if the user is currently renting the movie
    $stmt = $conn->prepare("SELECT * FROM current_rentals WHERE user_id = ? AND movie_id = ?;");
    $stmt->bind_param("ii", $_SESSION['id'], $_POST['movie_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = mysqli_num_rows($result);

    if ($rows > 0) {
        // If the user is currently renting the movie
        // Return error
        $errors[] = ['status' => 'error', 'message' => 'Movie already rented', 'field' => 'all'];

        echo json_encode($errors);
        exit;
    }



    // Add the movie to the shopping cart
    $combined_id = $_SESSION['id'] . $_POST['movie_id'];
    $stmt = $conn->prepare("INSERT INTO shopping_cart (combined_id, user_id, movie_id) VALUES (?, ?, ?);");
    $stmt->bind_param("iii", $combined_id, $_SESSION['id'], $_POST['movie_id']);
    $stmt->execute();

    // Return success
    echo json_encode(['status' => 'success', 'message' => 'Movie added to shopping cart']);
    exit;





?>