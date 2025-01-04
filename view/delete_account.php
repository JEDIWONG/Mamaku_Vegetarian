<?php
session_start();
include '../view/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']); // Replace with dynamic user ID logic

    // Validate user ID
    if (!$user_id) {
        http_response_code(400);
        echo 'Invalid request.';
        exit;
    }

    // Delete user from the database
    $sql = "DELETE FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // If user deleted, optionally delete session and other related data
        session_destroy();
        http_response_code(200);
        echo 'User deleted successfully.';
    } else {
        http_response_code(500);
        echo 'Failed to delete user.';
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo 'Method not allowed.';
}
?>
