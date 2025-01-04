<?php
    session_start(); // Start or resume the session

    // Get the JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if 'order_id' is provided and valid
    if (isset($data['order_id']) && is_numeric($data['order_id'])) {
        $_SESSION['order_id'] = $data['order_id']; // Set the session variable
        http_response_code(200); // Success response
        echo json_encode(["message" => "Session ID set successfully"]);
    } else {
        http_response_code(400); // Bad request response
        echo json_encode(["message" => "Invalid transaction ID"]);
    }
?>
