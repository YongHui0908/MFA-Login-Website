<?php
require 'config.php';

$user_id = $_SESSION['user_id'];

try {
    // Fetch user's course
    $stmt = $pdo->prepare("SELECT course FROM user_details WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user_course = $stmt->fetchColumn();

    // Fetch exams and their statuses
    $query = "
        SELECT e.id, e.exam_name, e.exam_link, uea.start_time, uea.end_time
        FROM exams e
        JOIN exam_courses ec ON e.id = ec.exam_id
        LEFT JOIN user_exam_activity uea ON e.id = uea.exam_id AND uea.user_id = :user_id
        WHERE ec.course_name = :course_name
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':course_name' => $user_course, ':user_id' => $user_id]);
    $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching exams: " . $e->getMessage());
}

?>
