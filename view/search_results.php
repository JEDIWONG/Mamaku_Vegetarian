<?php
include '../model/database_model.php';

// Get the search query from the GET parameter
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Initialize the database connection
$db = new Database();
$conn = $db->conn; // Use the `conn` property directly for executing prepared statements

// Check if a search query is provided
if ($query) {
    // Sanitize the input using escape_string
    $escapedQuery = $db->escape_string($query);

    // Prepare the SQL query to search products
    $sql = "SELECT 
                p.product_id, 
                p.name AS product_name, 
                p.description, 
                p.price, 
                p.availability, 
                p.image, 
                pc.name AS category_name 
            FROM product p
            LEFT JOIN product_category pc ON p.category_id = pc.category_id
            WHERE p.name LIKE ? OR p.description LIKE ? OR pc.name LIKE ?";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        $searchTerm = '%' . $escapedQuery . '%';
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch results
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
    } else {
        // Handle preparation errors
        die("Query preparation failed: " . $conn->error);
    }
} else {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/searchpanel.css">
    <link rel="stylesheet" href="../style/product_card.css">
</head>
<body>
    <?php include "../include/sidebar.php" ?>
    <main>
        <?php include "../include/searchpanel.php" ?>
        <h3>Product Matching <?php echo "'$query'" ?></h3>
        <div class="product-card-container">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <a class="product-card" href="product_details.php?id=<?php echo $product['product_id']; ?>">
                        <img src="../assets/images/<?php echo htmlspecialchars($product["image"]); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p>RM <?php echo number_format($product['price'], 2); ?></p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found for "<?= htmlspecialchars($query) ?>"</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
