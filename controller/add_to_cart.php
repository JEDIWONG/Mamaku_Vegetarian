<?php
    session_start();
    header("Content-Type: application/json");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in."]);
        exit;
    }

    require_once '../model/database_model.php';
    $db = new Database();
    $conn = $db->conn;

    // Parse JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    $product_id = intval($input['product_id']);
    $quantity = intval($input['quantity']);
    $option = $input['option'];
    $addons = $input['addons']; // Comma-separated string
    $instruction = $input['instruction'];
    $totalPrice = floatval($input['price']);

    try {
        // Get or create cart ID for the user
        $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "SQL Error (cart check): " . $conn->error]);
            exit;
        }

        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = $result->fetch_assoc();

        if (!$cart) {
            $stmt = $conn->prepare("INSERT INTO cart (user_id) VALUES (?)");
            if (!$stmt) {
                echo json_encode(["status" => "error", "message" => "SQL Error (create cart): " . $conn->error]);
                exit;
            }
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $cart_id = $conn->insert_id;
        } else {
            $cart_id = $cart['cart_id'];
        }

        // Insert cart item
        $stmt = $conn->prepare("
            INSERT INTO cart_item (cart_id, product_id, quantity, remarks, option_name, addon_name, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "SQL Error (insert cart item): " . $conn->error]);
            exit;
        }

        // Log data before execution
        error_log("Cart ID: $cart_id, Product ID: $product_id, Quantity: $quantity, Remarks: $instruction, Option: $option, Addons: $addons, Total Price: $totalPrice");

        $stmt->bind_param("iiisssd", $cart_id, $product_id, $quantity, $instruction, $option, $addons, $totalPrice);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Cart item added successfully!"]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to add cart item: " . $e->getMessage(),
            "trace" => $e->getTraceAsString()
        ]);
    }

    $conn->close();
?>
