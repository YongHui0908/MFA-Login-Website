<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Check if image data exists
if (isset($data['image'])) {
    $imageData = $data['image'];

    // Remove the "data:image/png;base64," part of the string
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $image = base64_decode($imageData);

    // Create a unique filename
    $filename = uniqid() . '.png';

    // Define the directory to save the image
    $directory = __DIR__ . '/images/';

    // Make sure the directory exists
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // Save the image
    $filePath = $directory . $filename;
    if (file_put_contents($filePath, $image)) {
        echo json_encode(["message" => "Image uploaded successfully", "path" => $filePath]);
    } else {
        echo json_encode(["message" => "Failed to upload image"]);
    }
} else {
    echo json_encode(["message" => "No image data received"]);
}
?>
