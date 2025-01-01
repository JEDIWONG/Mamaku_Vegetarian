<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once '../model/database_model.php';

    $db = new Database();
    $conn = $db->conn;

    $user_id = $_SESSION['user_id'];

    // Initialize variables
    $cart_items = [];
    $total_price = 0;

    try {
        // Get the cart ID for the logged-in user
        $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($cart = $result->fetch_assoc()) {
            $cart_id = $cart['cart_id'];

            // Fetch cart items along with product names
            $stmt = $conn->prepare("
                SELECT ci.*, p.name AS product_name 
                FROM cart_item ci 
                JOIN product p ON ci.product_id = p.product_id 
                WHERE ci.cart_id = ?
            ");
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($item = $result->fetch_assoc()) {
                $cart_items[] = $item;
                $total_price += $item['price']; 
            }
        } else {
            echo "No cart found for the user.";
            exit;
        }
    } catch (Exception $e) {
        echo "Failed to fetch cart data: " . $e->getMessage();
        exit;
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/checkout.css"> 
</head>
<body>
    
    <?php include "../include/sidebar.php" ?>
    <main>


        <h1>
            Step 1 : Payment Method
        </h1>

        <section class="checkout-method">
            
            <div class="method">
                <img src="../assets/images/placeholder.png">
                <p>Cashless</p>
            </div>
            
            <div class="method">
                <img src="../assets/images/placeholder.png">
                <p>Cash</p>
            </div>

        </section>

        <section class="checkout-cashless-container">
            <h1>Step 2 : Select One of the Cashless Payment Method</h1>
            <section class="checkout-cashless-list">

                <div class="method">
                    <img src="../assets/images/placeholder.png">
                    <p>Duitnow QR</p>
                </div>

                <div class="method">
                    <img src="../assets/images/placeholder.png">
                    <p>FPX</p>
                </div>

                <div class="method">
                    <img src="../assets/images/placeholder.png">
                    <p>SPAY</p>
                </div>
                
            </section>
            
        </section>

    </main>

    <section class="checkout-price-bar">
        <h1>Total</h1>
        <p>RM <?php echo number_format($total_price, 2); ?></p>
        <button>Next</button>
    </section>

    <script src="../script/checkout.js"></script>
</body>
</html>