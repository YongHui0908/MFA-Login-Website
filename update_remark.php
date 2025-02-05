<?php
require 'config.php'; // Include the database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $remark = $data['remark'];

    try {
        $stmt = $pdo->prepare("UPDATE user_exam_activity SET remark = :remark WHERE id = :id");
        $stmt->execute([':remark' => $remark, ':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Remark updated successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
