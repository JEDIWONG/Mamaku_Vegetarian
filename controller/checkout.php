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

    // Parse JSON input from the frontend
    $input = json_decode(file_get_contents("php://input"), true);

    // Variables from frontend
    $payment_method = $input['payment_method'] ?? null;
    $cashless_method = $input['cashless_method'] ?? null; // Optional, depends on payment method

    if (!$payment_method) {
        echo json_encode(["status" => "error", "message" => "Payment method is required."]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    try {
        // Get the cart ID for the logged-in user
        $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($cart = $result->fetch_assoc()) {
            $cart_id = $cart['cart_id'];

            // Fetch all cart items
            $stmt = $conn->prepare("
                SELECT ci.*, p.name AS product_name 
                FROM cart_item ci 
                JOIN product p ON ci.product_id = p.product_id 
                WHERE ci.cart_id = ?
            ");
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            $cart_items = $stmt->get_result();

            if ($cart_items->num_rows === 0) {
                echo json_encode(["status" => "error", "message" => "Cart is empty."]);
                exit;
            }

            // Calculate total amount
            $total_amount = 0;
            $items = [];
            while ($item = $cart_items->fetch_assoc()) {
                $total_amount += $item['price'];
                $items[] = $item;
            }

            // Insert into `order` table
            $stmt = $conn->prepare("INSERT INTO `order` (user_id, total_amount, status) VALUES (?, ?, 'Pending')");
            $stmt->bind_param("id", $user_id, $total_amount);
            $stmt->execute();
            $order_id = $conn->insert_id;

            // Insert into `order_item` table
            $stmt = $conn->prepare("
                INSERT INTO order_item (order_id, item_name, option_name, addon_name, remarks, quantity, price) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($items as $item) {
                $stmt->bind_param(
                    "issssid",
                    $order_id,
                    $item['product_name'],
                    $item['option_name'],
                    $item['addon_name'],
                    $item['remarks'],
                    $item['quantity'],
                    $item['price']
                );
                $stmt->execute();
            }

            // Clear cart after successful order placement
            $stmt = $conn->prepare("DELETE FROM cart_item WHERE cart_id = ?");
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();

            echo json_encode(["status" => "success", "message" => "Order placed successfully.", "order_id" => $order_id]);
        } else {
            echo json_encode(["status" => "error", "message" => "Cart not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Failed to process checkout: " . $e->getMessage()]);
    }

    $conn->close();
?>
