<?php
    session_start();

    header("Content-Type: application/json");

    // Include database connection
    require_once '../model/database_model.php';

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['userId'], $input['fullName'])) {
        echo json_encode(["success" => false, "message" => "Invalid input."]);
        exit;
    }

    $userId = intval($input['userId']);
    $fullName = trim($input['fullName']);
    list($firstName, $lastName) = explode(' ', $fullName, 2) + ["", ""];

    try {
        $db = new Database();
        $conn = $db->conn;

        // Update the user's name in the database
        $stmt = $conn->prepare("UPDATE user SET first_name = ?, last_name = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $firstName, $lastName, $userId);

        if ($stmt->execute()) {
            // Update session variables
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;

            echo json_encode(["success" => true, "message" => "Name updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update name in database."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
    }

?>