<?php
    session_start(); // Start the session

    // Include the database connection
    require_once '../model/database_model.php';

    $db = new Database();
    $conn = $db->conn;

    // Get the order ID from the query parameter
    $order_id = $_SESSION['order_id'];

    try {
        // Fetch the order details from the database
        $stmt = $conn->prepare("
            SELECT order_id, daily_order_no, created_at 
            FROM `order` 
            WHERE order_id = ?
        ");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
        } else {
            echo "Order not found.";
            exit;
        }

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
    <title>Checkout | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/result.css"> 
</head>
<body>
    
    <?php include "../include/sidebar.php" ?>

    <main>
        <section class="result-container">
            <img src="../assets/icons/tick-circle-svgrepo-com.svg">
            <h3>Order Received</h3>

            <h1>Your Order Number : <?php echo htmlspecialchars($order['daily_order_no']); ?></h1>
            <p>Please wait while we prepare your dishes.</p>
            
            <button class="checkout-download-btn" onclick="location.href='receipt.php'">View Receipt</button>
            <button class="checkout-back-btn" onclick="location.href = 'menu.php'">Return To Menu</button>
        </section>

        
    </main>
</body>
</html>