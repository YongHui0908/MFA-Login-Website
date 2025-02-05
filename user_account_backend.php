<?php
require 'vendor/autoload.php'; // Ensure you have installed vlucas/phpdotenv
require 'config.php'; // Include the database connection

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Fetch the encryption key securely from environment variables
$encryptionKey = getenv('ENCRYPTION_KEY');

try {
    // Fetch user account data
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
            users.role != 'admin';
    ");
    $stmt->bindParam(':encryption_key', $encryptionKey, PDO::PARAM_STR);
    $stmt->execute();
    $userAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
