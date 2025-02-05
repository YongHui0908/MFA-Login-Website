<?php
require 'config.php';

// count the number of users account in the table
try {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS total_users
        FROM 
            users
        WHERE
            users.role !='admin';
    
    ");
    $stmt->execute();
    $totalUserAccount = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

// count the number of exam module in the table
try {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS total_exams
        FROM 
            exams
    
    ");
    $stmt->execute();
    $totalExamModule = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

// count the number of users taken the exam in the table
try {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS total_exam_users
        FROM 
            user_exam_activity
    
    ");
    $stmt->execute();
    $totalExamUser = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>