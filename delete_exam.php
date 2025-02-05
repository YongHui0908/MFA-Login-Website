<?php
require 'config.php'; // Database connection

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['exam_id'])) {
    echo json_encode(['success' => false, 'message' => 'Exam ID not provided.']);
    exit;
}

$examId = intval($data['exam_id']);

try {
    $pdo->beginTransaction();

    // Delete associated courses for the exam
    $stmt = $pdo->prepare("DELETE FROM exam_courses WHERE exam_id = :exam_id");
    $stmt->execute([':exam_id' => $examId]);

    // Delete the exam itself
    $stmt = $pdo->prepare("DELETE FROM exams WHERE id = :exam_id");
    $stmt->execute([':exam_id' => $examId]);

    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
