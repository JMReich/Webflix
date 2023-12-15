<?php

$errors = [];


if (empty($_POST['username'])) {
    $errors[] = ['status' => 'error', 'message' => 'Username is required', 'field' => 'username'];
}
else if (strlen($_POST['username']) < 6) {
    $errors[] = ['status' => 'error', 'message' => 'Username must be at least 6 characters', 'field' => 'username'];
}
else if (strlen($_POST['username']) > 20) {
    $errors[] = ['status' => 'error', 'message' => 'Username must be less than 20 characters', 'field' => 'username'];
}
else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    $errors[] = ['status' => 'error', 'message' => 'Username must be alphanumeric', 'field' => 'username'];
}
else {
    $username = $_POST['username'];
}


if (empty($_POST['email'])) {
    $errors[] = ['status' => 'error', 'message' => 'Email is required', 'field' => 'email'];
}
else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = ['status' => 'error', 'message' => 'Email must be valid', 'field' => 'email'];
}
else {
    $email = $_POST['email'];
}

if (empty($_POST['password'])) {
    $errors[] = ['status' => 'error', 'message' => 'Password is required', 'field' => 'password'];
} 
else if (strlen($_POST['password']) < 8) {
    $errors[] = ['status' => 'error', 'message' => 'Password must be at least 8 characters', 'field' => 'password'];
}
else if (strlen($_POST['password']) > 20) {
    $errors[] = ['status' => 'error', 'message' => 'Password must be less than 20 characters', 'field' => 'password'];
}
else if (!preg_match('/[a-z]/', $_POST['password'])) {
    $errors[] = ['status' => 'error', 'message' => 'Password must contain at least one lowercase letter', 'field' => 'password'];
} 
else if (!preg_match('/[A-Z]/', $_POST['password'])) {
    $errors[] = ['status' => 'error', 'message' => 'Password must contain at least one uppercase letter', 'field' => 'password'];
}
else if (!preg_match('/\d/', $_POST['password'])) {
    $errors[] = ['status' => 'error', 'message' => 'Password must contain at least one number', 'field' => 'password'];
}
else if (!preg_match('/[!@#\$%\^&\*\(\)_\-=+\[\]{};:\'",<.>]/', $_POST['password'])) {
    $errors[] = ['status' => 'error', 'message' => 'Password must contain at least one special character (!@#\$%\^&\*\(\)_\-=+\[\]{};:\'",<.>])', 'field' => 'password'];
}
else if ($_POST['password'] !== $_POST['passwordRepeat']) {
    $errors[] = ['status' => 'error', 'message' => 'Passwords must match', 'field' => 'password-repeat'];
}
else {
    $password = $_POST['password'];
}



if (!empty($errors)) {
    // Return/display errors
    echo json_encode($errors);
    exit;
}
else {
    // Check if username already exists
    include_once 'inc.mysqlCon.php';
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        // Username already exists return error
        $errors[] = ['status' => 'exists', 'message' => 'Username already taken', 'field' => 'username'];
        echo json_encode($errors);
        exit();
    }
    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        // Email already exists return error
        $errors[] = ['status' => 'exists', 'message' => 'Email already taken', 'field' => 'email'];
        echo json_encode($errors);
        exit();
    }
    // All Checks passed, create account
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Get user role
    if (isset($_POST['role'])) {
        $userRule = $_POST['role'];
    }
    else {
    $userRule = "user";
    }
    // get date of creation
    $doc = date("Y-m-d");
    // Insert into database
    $sql = "INSERT INTO accounts (username, email, password, doc, role) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Return/display errors - shouldn't happen but always good to check
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPassword, $doc, $userRule);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Getuser info from database
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();
    $info = mysqli_fetch_assoc($result);

    //create session
    session_start();
    $_SESSION['username'] = $info['username'];
    $_SESSION['role'] = $info['role'];
    $_SESSION['id'] = $info['id'];

    // Let client know registration was successful and redirect to home page
    echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
    exit();
}


?>