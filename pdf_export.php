<?php
require('fpdf/fpdf.php');
require 'config.php';

// Start the export only if 'export' parameter is set
if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    try {
        // Build the SQL query dynamically based on the filters
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

        // Add conditions based on the filters passed via GET
        $conditions = [];
        $params = [];

        // If a course is selected, add it as a filter
        if (isset($_GET['course']) && $_GET['course'] != '') {
            $conditions[] = "user_details.course = :course";
            $params[':course'] = $_GET['course'];
        }

        // If an exam module is selected, add it as a filter
        if (isset($_GET['exam_module']) && $_GET['exam_module'] != '') {
            $conditions[] = "user_exam_activity.exam_name = :exam_module";
            $params[':exam_module'] = $_GET['exam_module'];
        }

        // Apply the filters to the query if there are any
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Create PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(180, 10, 'Online University Examination Website', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 16);

        // Add header
        $pdf->Image('assets/img/education_favicon.png', 10, 10, 20);
        $pdf->Cell(40);
        $pdf->Cell(100, 10, 'User Examination Attendance Record', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, 'Generated on: ' . date('Y-m-d H:i'), 0, 1, 'R');
        $pdf->Ln(5);
        // Add selected filters to the PDF header
        if (isset($_GET['course']) && $_GET['course'] != '') {
            $pdf->Cell(190, 5, 'Course: ' . htmlspecialchars($_GET['course']), 0, 1, 'L');
        }
        if (isset($_GET['exam_module']) && $_GET['exam_module'] != '') {
            $pdf->Cell(190, 5, 'Exam Module: ' . htmlspecialchars($_GET['exam_module']), 0, 1, 'L');
        }
        $pdf->Ln(5);

        // Table Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(22, 10, 'Username', 1, 0, 'C');
        $pdf->Cell(32, 10, 'Course', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Exam Module', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Start Time', 1, 0, 'C');
        $pdf->Cell(25, 10, 'End Time', 1, 0, 'C');
        $pdf->Cell(46, 10, 'Remark', 1, 0, 'C');
        $pdf->Ln();

        // Table Data
        $pdf->SetFont('Arial', '', 8);
        foreach ($records as $record) {
            $start_time = date('Y/m/d H:i', strtotime($record['start_time']));
            $end_time = date('Y/m/d H:i', strtotime($record['end_time']));

            $username = $record['username'];
            $course = $record['course'];
            $exam_name = $record['exam_name'];
            $remark = $record['remark'];

            $colWidths = [22, 32, 40, 25, 25, 46];
            $cellTexts = [$username, $course, $exam_name, $start_time, $end_time, $remark];

            $rowHeight = 6; // Base height
            foreach ($cellTexts as $i => $text) {
                $numLines = $pdf->GetStringWidth($text) / $colWidths[$i] > 1 ? ceil($pdf->GetStringWidth($text) / $colWidths[$i]) : 1;
                $rowHeight = max($rowHeight, $numLines * 6); // Adjust line height as needed
            }

            // Add cells to the row
            foreach ($cellTexts as $i => $text) {
                if ($i == 5) { // Last column with MultiCell (Remark)
                    $xPos = $pdf->GetX();
                    $yPos = $pdf->GetY();
                    $pdf->MultiCell($colWidths[$i], 6, $text, 1);
                    $pdf->SetXY($xPos + $colWidths[$i], $yPos);
                } else {
                    $pdf->Cell($colWidths[$i], $rowHeight, $text, 1);
                }
            }

            // Move to the next line
            $pdf->Ln($rowHeight);
        }

        // Output the PDF
        $pdf->Output('D', 'Exam_Attendance_Record.pdf');
        exit;

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
