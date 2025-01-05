<?php
    include '../model/database_model.php';

    // Get the search query from the GET parameter
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';

    // Get the sorting option from the GET parameter (default to 'default')
    $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'default';

    // Get the selected category filter from the GET parameter
    $selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : 0;

    // Initialize the database connection
    $db = new Database();
    $conn = $db->conn; // Use the `conn` property directly for executing prepared statements

    // Fetch all categories for the dropdown filter
    $categoryQuery = "SELECT category_id, name FROM product_category";
    $categoriesResult = $conn->query($categoryQuery);
    $categories = [];
    while ($category = $categoriesResult->fetch_assoc()) {
        $categories[] = $category;
    }

    // Prepare the base SQL query to search products
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
            WHERE p.name LIKE ? OR p.description LIKE ?";

    // Add category filter if a category is selected
    if ($selectedCategory > 0) {
        $sql .= " AND p.category_id = ?";
    }

    // Add sorting conditions based on the `sort_by` parameter
    if ($sortBy == 'price_asc') {
        $sql .= " ORDER BY p.price ASC";
    } elseif ($sortBy == 'price_desc') {
        $sql .= " ORDER BY p.price DESC";
    } else {
        $sql .= " ORDER BY p.product_id ASC"; // Default sorting by product ID
    }

    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        $searchTerm = '%' . $query . '%'; // Using raw input here since it is parameterized
        if ($selectedCategory > 0) {
            $stmt->bind_param("ssi", $searchTerm, $searchTerm, $selectedCategory);
        } else {
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
        }
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
        
        <h3>Product Matching "<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"</h3>
        
        <!-- Sorting and Category Filter Form -->
        <form method="GET" action="search_results.php" id="sortForm">
            <input type="hidden" name="query" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"> <!-- Retain search query -->
            <div>
                <label for="sort_by">Sort by:</label>
                <select name="sort_by" id="sort_by" onchange="this.form.submit()">
                    <option value="default" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'default' ? 'selected' : ''; ?>>Default</option>
                    <option value="price_asc" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                </select>
            </div>
            
            <br>
            <div>
                <label for="category">Category:</label>
                <select name="category" id="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['category_id'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?php echo ($selectedCategory == $category['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
        
        <div class="product-card-container">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <a class="product-card" href="product_details.php?id=<?php echo htmlspecialchars($product['product_id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <img src="../assets/images/products/<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>">
                        <h3><?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p>RM <?php echo number_format($product['price'], 2); ?></p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found for "<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>



