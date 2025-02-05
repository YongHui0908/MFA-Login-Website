<?php
require 'config.php'; // Include the database connection

try {
    // Fetch user account data
    $stmt = $pdo->prepare("
        SELECT 
            exams.id AS exam_id,
            exams.exam_name,
            GROUP_CONCAT(exam_courses.course_name SEPARATOR ', ') AS associated_courses,
            exams.exam_link
        FROM 
            exams
        LEFT JOIN 
            exam_courses ON exams.id = exam_courses.exam_id
        GROUP BY 
            exams.id;
    ");
    $stmt->execute();
    $examOverview = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
