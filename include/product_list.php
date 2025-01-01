<?php

    include '../model/database_model.php';

    $db = new Database(); 
    $conn = $db->conn;

    // Fetch categories with their products
    $sql_categories = "SELECT * FROM product_category";
    $result_categories = $conn->query($sql_categories);

    if ($result_categories->num_rows > 0) {
        while ($category = $result_categories->fetch_assoc()) {
            $categoryId = $category['category_id'];
            $categoryName = $category['name'];
            ?>
        
        <section class="series-container">
            <button class="series-header">
                <h1><?php echo htmlspecialchars($categoryName); ?></h1>
                
            </button>
        
            <section class="product-card-container">
                <?php
                // Fetch products for this category
                $sql_products = "SELECT * FROM product WHERE category_id = $categoryId";
                $result_products = $conn->query($sql_products);

                if ($result_products->num_rows > 0) {
                    while ($product = $result_products->fetch_assoc()) {
                        $productName = $product['name'];
                        $productPrice = $product['price'];
                        $productImage = $product['image'];
                        ?>
                        
                            <a class="product-card" href="product_details.php?id=<?php echo $product['product_id']; ?>">
                                <img src="../assets/images/<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                                <h3><?php echo htmlspecialchars($productName); ?></h3>
                                <p>RM <?php echo number_format($productPrice, 2); ?></p>
                            </a>
                        

                        <?php
                    }
                } else {
                    echo "<p>No products available in this category.</p>";
                }
                ?>
            </section>
        </section>

        <?php
    }
} else {
    echo "<p>No categories available.</p>";
}

    // Close the connection
    $conn->close();
?>
