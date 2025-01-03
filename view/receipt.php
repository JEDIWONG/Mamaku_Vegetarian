<?php
session_start(); // Start the session

// Redirect if order ID is not set in the session
if (!isset($_SESSION['order_id'])) {
    header("Location: menu.php"); // Redirect to the menu page or another appropriate page
    exit;
}

$order_id = $_SESSION['order_id']; // Get the order ID from the session

// Include the database connection
require_once '../model/database_model.php';

$db = new Database();
$conn = $db->conn;

try {
    // Fetch order and transaction details
    $stmt = $conn->prepare("
        SELECT o.order_id, o.user_id, o.total_amount, o.daily_order_no, o.created_at, 
               t.payment_method, t.payment_status 
        FROM `order` o 
        JOIN transaction t ON o.order_id = t.order_id 
        WHERE o.order_id = ?
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found.");
    }

    $order = $result->fetch_assoc();

    // Fetch client details
    $stmt = $conn->prepare("
        SELECT first_name, last_name, email, phone_number 
        FROM user 
        WHERE user_id = ?
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $order['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("User not found.");
    }

    $user = $result->fetch_assoc();

    // Fetch order items
    $stmt = $conn->prepare("
        SELECT item_name, quantity, price 
        FROM order_item 
        WHERE order_id = ?
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_items = $stmt->get_result();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    echo "Failed to fetch order details: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Receipt | Mamaku Vegetarian</title>

        <link rel="stylesheet" href="../style/index.css">
        <link rel="stylesheet" href="../style/sidebar.css">
        <link rel="stylesheet" href="../style/footer.css">
        <link rel="stylesheet" href="../style/searchpanel.css">
        <link rel="stylesheet" href="../style/receipt.css">
    </head>
    <body>

        <?php include "../include/sidebar.php" ?>
        <main class="receipt-page-container">
            <section class="receipt-logo">
                <img src="../assets/images/logo.png">
                <h1>Mamaku Vegetarian</h1>
            </section>
            
            <section class="receipt-recipient">
                <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                <h3><?php echo htmlspecialchars($user['email']); ?></h3>
                <h3><?php echo htmlspecialchars($user['phone_number']); ?></h3>
            </section>
            
            <section class="receipt-container">
                <h1>Order Receipt</h1>

                <div class="receipt-attribute">
                    <h3>Order ID</h3>
                    <p><?php echo htmlspecialchars($order['order_id']); ?></p>
                </div>

                <div class="receipt-order-details">
                    <h3>Order Details</h3>
                    <div class="receipt-order-list">
                        <?php while ($item = $order_items->fetch_assoc()): ?>
                            <div class="receipt-order-item">
                                <p>x <?php echo htmlspecialchars($item['quantity']); ?></p>
                                <h5><?php echo htmlspecialchars($item['item_name']); ?></h5>
                                <p>RM <?php echo number_format($item['price'], 2); ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="receipt-attribute">
                    <h3>Payment Method</h3>
                    <p><?php echo htmlspecialchars($order['payment_method']); ?></p>
                </div>  

                <div class="receipt-attribute">
                    <h3>Transaction Date</h3>
                    <p><?php echo date('d-m-Y', strtotime($order['created_at'])); ?></p>
                </div>

                <div class="receipt-attribute">
                    <h3>Transaction Time</h3>
                    <p><?php echo date('h:i A', strtotime($order['created_at'])); ?></p>
                </div>

                <div class="receipt-attribute">
                    <h3>Transaction Status</h3>
                    <p><?php echo htmlspecialchars($order['payment_status']); ?></p>
                </div>

                <div class="receipt-attribute">
                    <h3>Total Paid (RM)</h3>
                    <p class="receipt-price">RM <?php echo number_format($order['total_amount'], 2); ?></p>
                </div>
                    
            </section>

            <button>Download As .PDF</button>
        </main>
    </body>
</html>