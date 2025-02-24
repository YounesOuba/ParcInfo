<?php
include 'db.php';

function log_action($user_id, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $action);
    $stmt->execute();
    $stmt->close();
}

// مثال على الاستعمال
// log_action(1, "User logged in"); // كتسجل دخول المستخدم رقم 1
?>
