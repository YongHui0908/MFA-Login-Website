<?php
require 'config.php'; // Database connection

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['error' => 'Invalid CSRF token.']);
        exit;
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username)) {
        $errors['u'] = "*Username is Required";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['u'] = "*Invalid username format";
    } elseif (empty($password)) {
        $errors['p'] = "*Password is Required";
    }

    // If there are validation errors, store them in session and redirect back to login
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['username'] = $username; // Preserve username value for form repopulation
        header('Location: login.php');
        exit;
    }

    try {
        // Prepare SQL query to fetch user details
        $stmt = $pdo->prepare("
            SELECT 
                users.id AS user_id, 
                users.username, 
                users.password, 
                users.role,
                user_details.face_id, 
                user_details.image_path 
            FROM 
                users 
            JOIN 
                user_details 
            ON 
                users.id = user_details.user_id 
            WHERE 
                users.username = :username
        ");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify username and password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['image_path'] = $user['image_path'];
            $_SESSION['success'] = "Login successful! Proceed to face verification."; // Set success message

            // Redirect to face verification page
            header('Location: login.php');
            exit;
        } else {
            $_SESSION['errors']['auth'] = "Invalid username or password.";
            header('Location: login.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['errors']['db'] = "Database error: " . $e->getMessage();
        header('Location: login.php');
        exit;
    }
}

?>
