// get_updated_name.php
<?php
// Assume you're using a database connection, and that $conn is your connection object
session_start();
// Get the updated first name and last name from the database
$sql = "SELECT first_name, last_name FROM users WHERE user_id = :user_id"; // Assuming you have a user_id session or variable
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id']); // Example user_id session
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  echo json_encode(['success' => true, 'firstName' => $user['first_name'], 'lastName' => $user['last_name']]);
} else {
  echo json_encode(['success' => false]);
}
?>
