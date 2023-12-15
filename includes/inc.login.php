<?php




if (empty($_POST['username'])) {
    $errors[] = ['status' => 'error', 'message' => 'Username is required', 'field' => 'username'];
} else {
    $username = $_POST['username'];
}

if (empty($_POST['password'])) {
    $errors[] = ['status' => 'error', 'message' => 'Password is required', 'field' => 'password'];
} else {
    $password = $_POST['password'];
}


if (!empty($errors)) {
    echo json_encode($errors);
    exit;
}

// Connect to the database
include_once 'inc.mysqlCon.php';

$stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$rows = mysqli_num_rows($result);

if ($rows <= 0) {
    $errors[] = ['status' => 'error', 'message' => '1', 'field' => 'all'];
    echo json_encode($errors);
    exit;
}

$info = mysqli_fetch_assoc($result);
$isValid = password_verify($password, $info['password']);

if (!$isValid) {
    $errors[] = ['status' => 'error', 'message' => $hashedPassword, 'field' => 'all'];
    echo json_encode($errors);
    exit;
}

session_start();
    $_SESSION['username'] = $info['username'];
    $_SESSION['role'] = $info['role'];
    $_SESSION['id'] = $info['id'];

    // Let client know registration was successful and redirect to home page
    echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
    exit();
?>  