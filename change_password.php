<?php
require 'config.php'; // Include the database connection
session_start();

$user_id = $_SESSION['user_id']; // Assume `user_id` is stored in session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $renewPassword = $_POST['renewPassword'];

    // Validate the new passwords match
    if ($newPassword !== $renewPassword) {
        echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
        exit;
    }

    // Validate password requirements
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Password does not meet the required criteria.']);
        exit;
    }

    try {
        // Fetch the current password hash
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
            exit;
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt->execute();

        echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
