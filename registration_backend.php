<?php
// session_start();
require 'rekognition.php';
require 'encryption.php';
use Aws\Rekognition\RekognitionClient;
use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
header('Content-Type: text/html; charset=UTF-8');

$encryptionKey = getenv('ENCRYPTION_KEY'); // Secret key for AES encryption (store securely)

// Generate CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['imageData'])) {
//     if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//         echo json_encode(['error' => 'Invalid CSRF token.']);
//         exit;
//     }
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['error' => 'Invalid CSRF token.']);
        exit;
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phonenumber = preg_replace('/[^0-9]/', '', $_POST['phonenumber']);
    $nationalid = preg_replace('/[^0-9]/', '', $_POST['nationalid']);
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $allowedCourses = ['Cyber Security', 'Software Engineering', 'Computer Science', 'Artificial Intelligence', 'E-Business'];
    $homeaddress = htmlspecialchars($_POST['homeaddress']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $imageData = $_POST['imageData'];

    // Validate inputs
    if (empty($username)) {
        $errors['u'] = "*Username is Required";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['u'] = "*Please fulfill the requirement";
    } elseif (empty($email)) {
        $errors['e'] = "*Email is Required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['e'] = "*Invalid Email";
    } elseif (empty($phonenumber)) {
        $errors['phone'] = "*Phone Num is Required";
    } elseif (!preg_replace('/[^0-9]/', '', $phonenumber)) {
        $errors['phone'] = "*Invalid Phone Number";
    } elseif (empty($nationalid)) {
        $errors['n'] = "*National ID is Required";
    } elseif (!preg_replace('/[^0-9]/', '', $nationalid)) {
        $errors['n'] = "*Invalid National ID";
    } elseif (!$course || !in_array($course, $allowedCourses)) {
        $errors['course'] = "*Course is Required";
    } elseif (empty($homeaddress)) {
        $errors['h'] = "*Home Address is Required";
    } elseif (empty($password)) {
        $errors['p'] = "*Password is Required";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $errors['p'] = "Please fulfill the requirement";
    } elseif (empty($cpassword)) {
        $errors['cp'] = "*Confirm Password is Required";
    } elseif ($password !== $cpassword) {
        $errors['cp'] = "Passwords do not match.";
    } elseif (empty($imageData)) {
        $errors['face'] = "*Face Image is Required";
    }
    

    if (count($errors) === 0) {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=fyp_db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check for duplicate username or email
            $stmt = $pdo->prepare("SELECT username, email FROM users WHERE username = :username OR email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);
            $result = $stmt->fetchAll();

            // Check for existing username or email
            if (count($result) > 0) {
                $existingUsers = array_column($result, 'username');
                $existingEmails = array_column($result, 'email');

                if (in_array($username, $existingUsers)) {
                    $_SESSION['duplicate'] = 'username'; // Set session variable for username duplicate
                } elseif (in_array($email, $existingEmails)) {
                    $_SESSION['duplicate'] = 'email'; // Set session variable for email duplicate
                }

                header('Location: registration.php'); // Redirect to the registration page
                exit; // Stop further execution
            }       

            // Decode and validate the image
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
            if (!$imageData) {
                $_SESSION['decode_error'] = 'Invalid image data';
                header('Location: registration.php');
                // echo json_encode(['error' => 'Invalid image data']);
                exit;
            }

            // Validate that the image contains a face
            if (detectFace($imageData)) {
                $_SESSION['detect_face_error'] = 'No face detected in the image';
                header('Location: registration.php');
                // echo json_encode(['error' => 'No face detected in the image']);
                exit;
            }

            // Check for duplicate face
            if (checkDuplicateFace($imageData)) {
                $_SESSION['check_duplicate_face_error'] = 'Duplicate face detected';
                header('Location: registration.php');
                 // echo json_encode(['error' => 'Duplicate face detected']);
                exit;
            }

            // Index the face in Rekognition
            $faceId = indexFace($imageData);
            if (is_array($faceId)) {
                $_SESSION['index_face_error'] = 'Face indexing error';
                header('Location: registration.php');
                // echo json_encode(['error' => 'Face indexing error']);
                exit;
            }

            // Encrypt the image and save locally
            $encryptedImage = encryptImage($imageData, $encryptionKey);
            $imagePath = 'uploads/' . uniqid() . '.enc';
            if (!file_put_contents($imagePath, $encryptedImage)) {
                $_SESSION['encrypted_image_error'] = 'Failed to save encrypted image';
                header('Location: registration.php');
                // echo json_encode(['error' => 'Failed to save encrypted image']);
                exit;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert into the shared `user` table
            $query = $pdo->prepare(
                "INSERT INTO users (username, email, password, role, created_at) 
                VALUES (:username, :email, :password, :role, NOW())"
            );

            $query->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => 'user' // Default role is 'user'. Change to 'admin' for admin registrations
            ]);

            // Get the last inserted user ID
            $lastInsertId = $pdo->lastInsertId();

            // Insert user-specific details into the `user_details` table
            // VALUES (:user_id, :phonenumber, :nationalid, :course, :homeaddress, :face_id, :image_path)
            
            $queryUserDetails = $pdo->prepare(
                "INSERT INTO user_details (user_id, phonenumber, nationalid, course, homeaddress, face_id, image_path) 
                    VALUES (
                        :user_id, 
                        AES_ENCRYPT(:phonenumber, :encryption_key), 
                        AES_ENCRYPT(:nationalid, :encryption_key), 
                        :course, 
                        AES_ENCRYPT(:homeaddress, :encryption_key), 
                        :face_id, 
                        :image_path
                    )"
            );

            $queryUserDetails->execute([
                ':user_id' => $lastInsertId,
                ':phonenumber' => $phonenumber,
                ':nationalid' => $nationalid,
                ':course' => $course,
                ':homeaddress' => $homeaddress,
                ':face_id' => $faceId,
                ':image_path' => $imagePath,
                ':encryption_key' => $encryptionKey // Bind the encryption key for MySQL
            ]);
            $_SESSION['registration_success'] = true;
            header('Location: registration.php'); // Redirect back to the frontend
            exit;


        } catch (PDOException $e) {
            $_SESSION['database_error'] = 'Database error: ' . $e->getMessage();
            header('Location: registration.php');
            // echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        } catch (Exception $e) {
            $_SESSION['unexpected_error'] = 'An unexpected error occurred: ' . $e->getMessage();
            header('Location: registration.php');
            // echo json_encode(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
            exit;
        }
    }
}
ob_end_flush(); // Flush the output buffer
?>