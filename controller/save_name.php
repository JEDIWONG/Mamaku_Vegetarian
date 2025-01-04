<?php
$servername = "localhost"; // Replace with your database server
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "profile_db"; // Replace with your database name

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name']) && isset($data['id'])) {
    $name = $data['name'];
    $id = $data['id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
    }

    // Update name in the database
    $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Name updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update name"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}
?>
