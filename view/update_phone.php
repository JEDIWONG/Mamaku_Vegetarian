<?php
// Start the session and include database connection
session_start();
require_once 'db_connect.php'; // Include your database connection file

// Get the phone number from the request body (POST method)
$data = json_decode(file_get_contents('php://input'), true);
$phone_number = filter_var($data['phone_number'], FILTER_SANITIZE_STRING);

// Validate the phone number (basic validation, adjust as necessary)
if (empty($phone_number)) {
    echo json_encode(['success' => false, 'message' => 'Phone number cannot be empty']);
    exit;
}

// Check if the user is logged in (assuming user ID is stored in session)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Prepare the SQL query to update the phone number
$sql = "UPDATE user SET phone_number = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);

// Check if the query preparation failed
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare query', 'error' => $conn->error]);
    exit;
}

// Bind the parameters to the query (phone number and user ID)
$stmt->bind_param('si', $phone_number, $user_id);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update phone number', 'error' => $stmt->error]);
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
