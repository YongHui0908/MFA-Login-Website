<?php
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Exam_Attendance_Record.csv"');

    try {
        // Build the SQL query dynamically based on the filters (course and exam_module)
        $query = "
            SELECT 
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

        // Conditions array for WHERE clause
        $conditions = [];
        $params = [];

        // Add conditions based on course filter
        if (isset($_GET['course']) && $_GET['course'] != '') {
            $conditions[] = "user_details.course = :course";
            $params[':course'] = $_GET['course'];
        }

        // Add conditions based on exam_module filter
        if (isset($_GET['exam_module']) && $_GET['exam_module'] != '') {
            $conditions[] = "user_exam_activity.exam_name = :exam_module";
            $params[':exam_module'] = $_GET['exam_module'];
        }

        // Apply the filters to the query if conditions are set
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Open the output stream for CSV generation
        $output = fopen('php://output', 'w');

        // Add the column headers to the CSV
        fputcsv($output, ['Username', 'Course', 'Exam Module', 'Start Time', 'End Time', 'Remark']);

        // Write the data rows to the CSV file
        foreach ($records as $record) {
            fputcsv($output, $record);
        }

        // Close the output stream
        fclose($output);
        exit;
        
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

//     $stmt = $pdo->prepare("
//         SELECT 
//             user_exam_activity.username, 
//             user_details.course,
//             user_exam_activity.exam_name, 
//             user_exam_activity.start_time, 
//             user_exam_activity.end_time, 
//             user_exam_activity.remark 
//         FROM 
//             user_exam_activity
//         JOIN
//             user_details 
//         ON 
//             user_exam_activity.user_id = user_details.user_id
//     ");
//     $stmt->execute();
//     $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     $output = fopen('php://output', 'w');
//     fputcsv($output, ['Username', 'Course', 'Exam Module', 'Start Time', 'End Time', 'Remark']);

//     foreach ($records as $record) {
//         fputcsv($output, $record);
//     }

//     fclose($output);
//     exit;
// }

?>