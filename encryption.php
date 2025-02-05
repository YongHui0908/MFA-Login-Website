<?php
// Function to encrypt image using AES-256-CBC
function encryptImage($imageData, $key) {
    // Generate a random IV (Initialization Vector)
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encrypt the image data using AES-256-CBC algorithm
    $encryptedData = openssl_encrypt($imageData, 'aes-256-cbc', $key, 0, $iv);

    if ($encryptedData === false) {
        // Log the error
        error_log("Encryption failed: " . openssl_error_string());
        return false;
    }

    // Combine the IV and encrypted data to store them together
    return base64_encode($iv . $encryptedData);
}

// Function to decrypt image using AES-256-CBC
function decryptImage($encryptedImage, $key) {
    // Decode the base64 encoded string
    $data = base64_decode($encryptedImage);

    if ($data === false) {
        // Log base64 decode error
        error_log("Base64 decode failed.");
        return false;
    }

    // Extract the IV and encrypted data
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivLength);
    $encryptedData = substr($data, $ivLength);

    // Decrypt the data
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);

    if ($decryptedData === false) {
        // Log the error
        error_log("Decryption failed: " . openssl_error_string());
        return false;
    }

    return $decryptedData;
}

?>
