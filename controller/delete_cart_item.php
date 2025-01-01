<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

require_once '../model/database_model.php';
$db = new Database();
$conn = $db->conn;

// Parse JSON input
$input = json_decode(file_get_contents("php://input"), true);
$cart_item_id = intval($input['cart_item_id']); // Get cart_item_id from request

try {
    // Delete the cart item
    $stmt = $conn->prepare("DELETE FROM cart_item WHERE cart_item_id = ?");
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Cart item deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Cart item not found."]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete cart item: " . $e->getMessage()
    ]);
}

$conn->close();
?>
