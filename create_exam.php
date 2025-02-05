<?php
session_start();
require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $examName = trim($_POST['examName']);
    $associatedCourses = isset($_POST['associatedCourses']) ? $_POST['associatedCourses'] : [];
    $examLink = trim($_POST['examLink']);

    $errors = [];

    // Validate Exam Name
    if (empty($examName) || strlen($examName) > 100) {
        $errors[] = "Exam Name is required and should not exceed 100 characters.";
    }

    // Validate Associated Courses
    if (empty($associatedCourses) || !is_array($associatedCourses)) {
        $errors[] = "Please select at least one associated course.";
    } else {
        $allowedCourses = [
            "Cyber Security", 
            "Software Engineering", 
            "Computer Science", 
            "Artificial Intelligence", 
            "E-Business"
        ];
        foreach ($associatedCourses as $course) {
            if (!in_array($course, $allowedCourses)) {
                $errors[] = "Invalid course selection.";
                break;
            }
        }
    }

    // Validate Exam Link
    if (empty($examLink) || !filter_var($examLink, FILTER_VALIDATE_URL)) {
        $errors[] = "Please provide a valid URL for the exam link.";
    }

    // Check if there are any errors
    if (!empty($errors)) {
        // Return errors as JSON for better handling on the frontend
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }
    // $examName = $_POST['examName'];
    // $examLink = $_POST['examLink'];
    // $associatedCourses = $_POST['associatedCourses'];

    try {
        $pdo->beginTransaction();

        // Insert exam details
        $stmt = $pdo->prepare("INSERT INTO exams (exam_name, exam_link) VALUES (:examName, :examLink)");
        $stmt->execute([':examName' => $examName, ':examLink' => $examLink]);

        // Get the last inserted exam ID
        $examId = $pdo->lastInsertId();

        // Insert associated courses
        $courseStmt = $pdo->prepare("INSERT INTO exam_courses (exam_id, course_name) VALUES (:examId, :courseName)");
        foreach ($associatedCourses as $course) {
            $courseStmt->execute([':examId' => $examId, ':courseName' => $course]);
        }

        $pdo->commit();

        // Respond with success
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Exam created successfully!']);
        exit;
    } catch (PDOException $e) {
        // Handle database errors
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Failed to create exam: ' . $e->getMessage()]);
        exit;
    }
} else {
    // Invalid request method
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

        // SweetAlert2 popup for success
//         echo "<script>
//             document.addEventListener('DOMContentLoaded', function() {
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Exam Created Successfully!',
//                     text: 'The exam has been added with the associated courses.',
//                     confirmButtonText: 'OK'
//                 }).then(() => {
//                     window.location.href = 'admin_panel.php'; // Redirect after success
//                 });
//             });
//         </script>";
//     } catch (Exception $e) {
//         $pdo->rollBack();
//         echo "<script>
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error!',
//                 text: 'Failed to create the exam. Please try again.',
//                 confirmButtonText: 'OK'
//             });
//         </script>";
//     }
// }
?>
