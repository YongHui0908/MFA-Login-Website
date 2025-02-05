<?php
function promoteToAdmin($userIdToPromote, $currentUserId) {
    $pdo = new PDO('mysql:host=localhost;dbname=fyp_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the current user is a master admin
    $stmt = $pdo->prepare("SELECT is_master_admin FROM users WHERE id = :currentUserId AND role = 'admin'");
    $stmt->execute([':currentUserId' => $currentUserId]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentUser || !$currentUser['is_master_admin']) {
        echo "You do not have permission to promote users.";
        return;
    }

    // Promote the user to admin
    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = :userIdToPromote");
    $stmt->execute([':userIdToPromote' => $userIdToPromote]);

    echo "User promoted to admin successfully.";
}
?>