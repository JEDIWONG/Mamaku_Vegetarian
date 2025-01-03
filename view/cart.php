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
                $total_price += $item['price']; // Accumulate total price
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
        <title>Cart | Mamaku Vegetarian</title>

        <link rel="stylesheet" href="../style/index.css">
        <link rel="stylesheet" href="../style/sidebar.css">
        <link rel="stylesheet" href="../style/searchpanel.css">
        <link rel="stylesheet" href="../style/cart.css"> 
    </head>

    <body>
        <?php include "../include/sidebar.php"; ?>
        <main>
            <?php include "../include/searchpanel.php"; ?>
            <section class="cart-list-container">
                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item-container">
                            <img src="../assets/images/placeholder.png">
                            <div class="cart-item-info">
                                <h1><?php echo htmlspecialchars($item['product_name']); ?></h1> <!-- Display product name -->
                                <p class="cart-item-desc"><?php echo htmlspecialchars($item['option_name'] ?? "None"); ?></p>
                                <p class="cart-item-desc"><?php echo htmlspecialchars($item['addon_name'] ?? "No Addons"); ?></p>
                                <p class="cart-item-quantity">x <?php echo htmlspecialchars($item['quantity']); ?></p>
                                <p class="cart-item-price">RM <?php echo number_format($item['price'], 2); ?></p>
                            </div>
                            <button class="delete-btn" data-id="<?php echo $item['cart_item_id']; ?>">Delete</button>
                            
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-cart-message">Cart is empty</p>
                <?php endif; ?>
            </section>
        </main>

        <section class="cart-price-bar">
            <h1>Total</h1>
            <p>RM <?php echo number_format($total_price, 2); ?></p>
        </section>

        <button class="checkout-btn" onclick="location.href ='checkout.php'">
            Checkout
        </button>

        <script src="../script/cart.js"></script>
    </body>
</html>
