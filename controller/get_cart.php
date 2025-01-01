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

    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($cart = $result->fetch_assoc()) {
            echo json_encode(["status" => "success", "cart_id" => $cart['cart_id']]);
        } else {
            // Create a new cart if one doesn't exist
            $stmt = $conn->prepare("INSERT INTO cart (user_id) VALUES (?)");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            echo json_encode(["status" => "success", "cart_id" => $conn->insert_id]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Failed to retrieve or create cart. $e"]);
    }

    $conn->close();
?>
