<?php
    session_start();
    header("Content-Type: application/json");

    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in."]);
        exit;
    }

    require_once '../model/database_model.php';
    $db = new Database();
    $conn = $db->conn;

    // Parse JSON input from the frontend
    $input = json_decode(file_get_contents("php://input"), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON input."]);
        exit;
    }

    // Variables from frontend
    $payment_method = $input['payment_method'] ?? null;
    $cashless_method = $input['cashless_method'] ?? null;

    if (!$payment_method) {
        echo json_encode(["status" => "error", "message" => "Payment method is required."]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    try {
        // Get the cart ID for the logged-in user
        $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
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
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            $cart_items = $stmt->get_result();

            if ($cart_items->num_rows === 0) {
                echo json_encode(["status" => "error", "message" => "Cart is empty."]);
                exit;
            }

            // Calculate total amount and prepare items
            $total_amount = 0;
            $items = [];
            while ($item = $cart_items->fetch_assoc()) {
                $total_amount += $item['price'];
                $items[] = $item;
            }

            // Get today's daily order number
            $today = date("Y-m-d");
            $stmt = $conn->prepare("
                SELECT COUNT(*) AS daily_count 
                FROM `order` 
                WHERE DATE(created_at) = ?
            ");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $today);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $daily_order_no = $row['daily_count'] + 1;

            // Insert into `order` table
            $stmt = $conn->prepare("
                INSERT INTO `order` (user_id, total_amount, daily_order_no, status) 
                VALUES (?, ?, ?, 'Pending')
            ");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("idi", $user_id, $total_amount, $daily_order_no);
            $stmt->execute();
            $order_id = $conn->insert_id;

            // Insert into `order_item` table
            $stmt = $conn->prepare("
                INSERT INTO order_item (order_id, item_name, option_name, addon_name, remarks, quantity, price) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

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

                    // Check required fields
            if (!$payment_method) {
                echo json_encode(["status" => "error", "message" => "Payment method is required."]);
                exit;
            }
            if ($payment_method === "Cashless" && !$cashless_method) {
                echo json_encode(["status" => "error", "message" => "Cashless payment method is required."]);
                exit;
            }

            // Create a transaction
            $stmt = $conn->prepare("
                INSERT INTO transaction (order_id, payment_method, payment_status) 
                VALUES (?, ?, 'Pending')
            ");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $transaction_payment_method = $cashless_method ? "$payment_method ($cashless_method)" : $payment_method;
            $stmt->bind_param("is", $order_id, $transaction_payment_method);
            $stmt->execute();
            $transaction_id = $stmt->insert_id;

            // Clear the user's cart after checkout
            $stmt = $conn->prepare("DELETE FROM cart_item WHERE cart_id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();

            // Respond with success
            echo json_encode([
                "status" => "success",
                "message" => "Order and transaction created successfully.",
                "order_id" => $order_id,
                "transaction_id" => $transaction_id,
                "daily_order_no" => $daily_order_no,
            ]);

        } else {
            echo json_encode(["status" => "error", "message" => "Cart not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Failed to process checkout: " . $e->getMessage()]);
    }

    $conn->close();
?>
