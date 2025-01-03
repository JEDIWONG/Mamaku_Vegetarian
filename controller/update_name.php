<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mamaku_vegetarian";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents("log.txt", print_r($data, true)); 
$firstName = $data['firstName'];
$lastName = $data['lastName'];

// Replace 'user_id' with the actual user identifier
$userId = 1; // Example user ID

// Update query
$sql = "UPDATE user SET first_name = ?, last_name = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $firstName, $lastName, $userId);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
