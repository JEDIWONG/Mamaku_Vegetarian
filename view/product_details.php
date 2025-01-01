<?php
// Include database connection
include '../model/database_model.php';

$db = new Database(); 
$conn = $db->conn;

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // Sanitize input

    // Fetch product details
    $sql_product = "SELECT * FROM product WHERE product_id = $productId";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
        $productName = $product['name'];
        $productPrice = $product['price'];
        $productImage = $product['image'];
        $productDescription = $product['description']; // Assume there's a description column
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($productName); ?></title>

            <link rel="stylesheet" href="../style/index.css">
            <link rel="stylesheet" href="../style/sidebar.css">
            <link rel="stylesheet" href="../style/product_details.css">
        </head>
        <body>

        <?php include "../include/sidebar.php" ?>

        <main>
        
            <section 
                class="product-info-container"
                data-product-id="<?php echo htmlspecialchars($productId); ?>"
                data-product-price="<?php echo htmlspecialchars($productPrice); ?>">
                <img src="../assets/images/<?php echo htmlspecialchars($productImage); ?>">
                <div class="product-info">
                    <h1><?php echo htmlspecialchars($productName); ?></h1>
                    <p class="product-desc"><?php echo htmlspecialchars($productDescription); ?></p>
                    <p class="product-price">RM <?php echo number_format($productPrice, 2); ?></p>
                </div>
            </section>

            <section class="product-details-content">
                <h1>Order Details</h1>

                <!-- Fetch and Display Options -->
                <section class="product-selection-container">
                    <h1>Options</h1>
                    <?php
                    $sql_options = "SELECT * FROM product_option WHERE product_id = $productId";
                    $result_options = $conn->query($sql_options);
                    if ($result_options->num_rows > 0) {
                        while ($option = $result_options->fetch_assoc()) {
                            // Split the comma-delimited string into an array
                            $optionsArray = explode(',', $option['option_name']);
                            foreach ($optionsArray as $value) {
                                ?>
                                <div class="product-selection">
                                    <label><?php echo htmlspecialchars(trim($value)); ?></label>
                                    <input type="radio" name="product_option" value="<?php echo htmlspecialchars(trim($value)); ?>">
                                </div>
                                <?php
                            }
                        }
                    } else {
                        echo "<p>No options available for this product.</p>";
                    }
                    ?>
                </section>

                <!-- Fetch and Display Add-Ons -->
                <section class="product-selection-container">
                    <h1>Add-On</h1>
                    <?php
                    $sql_addons = "SELECT * FROM product_addon WHERE product_id = $productId";
                    $result_addons = $conn->query($sql_addons);
                    if ($result_addons->num_rows > 0) {
                        while ($addon = $result_addons->fetch_assoc()) {
                            ?>
                            <div class="product-selection">
                                <p class="product-addon"><?php echo htmlspecialchars($addon['addon_name']); ?></p>
                                <p class="product-addon-price">RM <?php echo number_format($addon['addon_price'], 2); ?></p>
                                <input 
                                    type="checkbox" 
                                    name="product_addon[]" 
                                    value="<?php echo htmlspecialchars($addon['addon_name']); ?>" 
                                    data-addon-price="<?php echo htmlspecialchars($addon['addon_price']); ?>">
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No add-ons available for this product.</p>";
                    }
                    ?>
                </section>

                <section class="product-selection-container">
                    <h1>Instruction</h1>
                    <input type="text" placeholder="State Your Special Instruction Here" class="order-instruction-field">
                </section>

                <h1>Total</h1>

                <section class="product-order-total">
                    <div class="amt-selector">
                        <label class="amt-add">+</label>
                        <label class="amt-indicator">1</label>
                        <label class="amt-decrease">-</label>
                    </div>

                    <label class="order-price">RM <?php echo number_format($productPrice, 2); ?></label>
                    
                    <button class="add-cart-btn">
                        Add To Cart
                    </button>
                </section>
            </section>
        </main>
            <script src="../script/product_details.js"></script>
        </body>

        
        </html>
        <?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}

// Close the connection
$conn->close();
?>
