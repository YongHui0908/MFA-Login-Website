<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $exam_id = $data['examId'];
    $exam_name = $data['examName']; // Passed from the button
    $action = $data['action'];
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    try {
        if ($action === 'start') {
            // Insert or update start time
            $stmt = $pdo->prepare("
                INSERT INTO user_exam_activity (user_id, username, exam_id, exam_name, start_time)
                VALUES (:user_id, :username, :exam_id, :exam_name, NOW())
                ON DUPLICATE KEY UPDATE start_time = NOW()
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':username' => $username,
                ':exam_id' => $exam_id,
                ':exam_name' => $exam_name
            ]);
        } elseif ($action === 'complete') {
            // Update end time
            $stmt = $pdo->prepare("
                UPDATE user_exam_activity
                SET end_time = NOW()
                WHERE user_id = :user_id AND exam_id = :exam_id AND end_time IS NULL
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':exam_id' => $exam_id
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            exit;
        }

        echo json_encode(['success' => true, 'message' => ucfirst($action) . ' successful!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
