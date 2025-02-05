<?php
require 'config.php'; // Include the database connection

try {
    // Prepare the base query
    $query = "
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
    ";

    // Add filters to the query if provided
    $conditions = [];
    $params = [];

    if (isset($_GET['course']) && $_GET['course'] != '') {
        $conditions[] = "user_details.course = :course";
        $params[':course'] = $_GET['course'];
    }

    if (isset($_GET['exam_module']) && $_GET['exam_module'] != '') {
        $conditions[] = "user_exam_activity.exam_name = :exam_module";
        $params[':exam_module'] = $_GET['exam_module'];
    }

    // If any conditions are set, append them to the query
    if ($conditions) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Now prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params); // Execute with the parameters
    $userExams = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
