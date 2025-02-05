<?php
require 'vendor/autoload.php'; // Ensure you have installed vlucas/phpdotenv
require 'config.php'; // Include the database connection
require 'encryption.php';
use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Fetch the encryption key securely from environment variables
$encryptionKey = getenv('ENCRYPTION_KEY');

// Assume user_id is stored in session after login
$user_id = $_SESSION['user_id'];

try {
    // Fetch user profile data
    $stmt = $pdo->prepare("
        SELECT 
            users.username,
            users.email,
            AES_DECRYPT(user_details.phonenumber, :encryption_key) AS phonenumber,
            AES_DECRYPT(user_details.nationalid, :encryption_key) AS nationalid,
            user_details.course,
            AES_DECRYPT(user_details.homeaddress, :encryption_key) AS homeaddress
        FROM 
            users
        JOIN 
            user_details 
        ON 
            users.id = user_details.user_id
        WHERE 
            users.id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':encryption_key', $encryptionKey, PDO::PARAM_STR);
    $stmt->execute();
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$profile) {
        die("Profile not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
