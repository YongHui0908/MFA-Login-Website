<?php
require 'vendor/autoload.php'; // Ensure you have installed vlucas/phpdotenv
require 'config.php';
session_start();
use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Assume user ID is stored in session
    $phonenumber = trim($_POST['phonenumber']);
    $homeaddress = trim($_POST['homeaddress']);

    // Server-side validation
    if (empty($phonenumber)) {
        echo json_encode(['status' => 'error', 'message' => 'Phone number cannot be empty.']);
        exit;
    }

    if (!preg_match('/^\+?[0-9]{7,15}$/', $phonenumber)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid phone number format.']);
        exit;
    }

    if (strlen($homeaddress) < 10) {
        echo json_encode(['status' => 'error', 'message' => 'Home address must be at least 10 characters long.']);
        exit;
    }

    try {
        $encryptionKey = $_ENV['ENCRYPTION_KEY']; // Load the encryption key
        $stmt = $pdo->prepare("
            UPDATE 
                user_details 
            SET 
                phonenumber = AES_ENCRYPT(:phonenumber, :encryption_key), 
                homeaddress = AES_ENCRYPT(:homeaddress, :encryption_key)
            WHERE 
                user_id = :user_id
        ");
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':homeaddress', $homeaddress, PDO::PARAM_STR);
        $stmt->bindParam(':encryption_key', $encryptionKey, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Send success response
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
        exit;
    } catch (PDOException $e) {
        // Send error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile: ' . $e->getMessage()]);
        exit;
    }
} else {
    // Send error response if not a POST request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}
?>
