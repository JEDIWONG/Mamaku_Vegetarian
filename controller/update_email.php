<?php
    // Start the session and include database connection
    session_start();
    file_put_contents("log.txt", "User ID: " . $_SESSION['user_id']);
    require_once 'db_connect.php'; // Include your database connection file

    // Get the email from the request body (POST method)
    $data = json_decode(file_get_contents('php://input'), true);
    file_put_contents("log.txt", print_r($data, true));
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    // Check if the user is logged in (assuming user ID is stored in session)
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Prepare the SQL query to update the email
    $sql = "UPDATE user SET email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    // Check if the query preparation failed
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare query', 'error' => $conn->error]);
        exit;
    }

    // Bind the parameters to the query (email and user ID)
    $stmt->bind_param('si', $email, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update email', 'error' => $stmt->error]);
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
?>
