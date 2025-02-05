<?php
require 'config.php'; // Include the database connection

try {
    // Fetch user account data
    $stmt = $pdo->prepare("
        SELECT 
            user_exam_activity.id, 
            user_exam_activity.username, 
            user_details.course,
            user_exam_activity.exam_name, 
            user_exam_activity.start_time, 
            user_exam_activity.end_time, 
            user_exam_activity.remark 
        FROM 
            user_exam_activity
        JOIN
            user_details 
        ON 
            user_exam_activity.user_id = user_details.user_id
    ");
    $stmt->execute();
    $userExams = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
