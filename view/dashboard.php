<?php

    include "../model/database_model.php";

    session_start(); // Start the session

    if (!isset($_SESSION['user_id'])) {
        // Redirect guest users to the login page
        header("Location: login.php");
        exit;
    }

    $conn = new Database();

    // Fetch data based on the logged-in user's ID
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Query to get the order count for the last 7 days
        $orderCountQuery = "
            SELECT COUNT(*) AS order_count 
            FROM `order` 
            WHERE user_id = $user_id 
            AND created_at >= NOW() - INTERVAL 7 DAY
        ";

        $orderCountResult = $conn->query($orderCountQuery);
        $orderCount = ($orderCountResult && $orderCountResult->num_rows > 0)
            ? $orderCountResult->fetch_assoc()['order_count']
            : 0;

        // Query to get the favorite menu for the user
        $favoriteMenuQuery = "
            SELECT 
                p.name AS item_name, 
                p.image, 
                MAX(oi.created_at) AS last_updated 
            FROM 
                order_item oi
            JOIN 
                `order` o ON oi.order_id = o.order_id
            JOIN 
                product p ON oi.item_name = p.name
            WHERE 
                o.user_id = $user_id 
            GROUP BY 
                p.name 
            ORDER BY 
                COUNT(*) DESC 
            LIMIT 1;
        ";

        $favoriteMenuResult = $conn->query($favoriteMenuQuery);
        $favoriteMenu = ($favoriteMenuResult && $favoriteMenuResult->num_rows > 0)
            ? $favoriteMenuResult->fetch_assoc()
            : [
                'item_name' => 'No favorite menu yet',
                'image' => 'prod_1.jpg',
                'last_updated' => 'N/A'
            ];

        // Query to get the top-selling menu for the user
        $topSellingMenuQuery = "
            SELECT 
                p.name AS item_name, 
                p.image, 
                MAX(oi.created_at) AS last_updated 
            FROM 
                order_item oi
            JOIN 
                `order` o ON oi.order_id = o.order_id
            JOIN 
                product p ON oi.item_name = p.name
            GROUP BY 
                p.name 
            ORDER BY 
                SUM(oi.quantity) DESC 
            LIMIT 1;
        ";

        $topSellingMenuResult = $conn->query($topSellingMenuQuery);
        $topSellingMenu = ($topSellingMenuResult && $topSellingMenuResult->num_rows > 0)
            ? $topSellingMenuResult->fetch_assoc()
            : [
                'item_name' => 'No top-selling menu yet',
                'image' => 'prod_1.jpg',
                'last_updated' => 'N/A'
            ];
    } else {
        // Default values if the user is not logged in
        $orderCount = 0;
        $favoriteMenu = [
            'item_name' => 'No favorite menu yet',
            'image' => 'prod_1.jpg',
            'last_updated' => 'N/A'
        ];
        $topSellingMenu = [
            'item_name' => 'No top-selling menu yet',
            'image' => 'prod_1.jpg',
            'last_updated' => 'N/A'
        ];
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/searchpanel.css">
    <link rel="stylesheet" href="../style/dashboard.css"> 
    <link rel="stylesheet" href="../style/footer.css"> 
</head>
<body>

    <!-- Sidebar inclusion -->
    <?php include "../include/sidebar.php"; ?>

    <!-- Main Dashboard Content -->
    <main class="dashboard-container">
        
        <?php include "../include/searchpanel.php" ?>

        <!-- Order Summary Card -->
        <section class="order-card">
            <div class="order-icon">
                <img src="../assets/icons/order_box.svg" alt="Order Icon">
            </div>
            <div class="order-info">
                <span class="order-name">Order</span>
                <span class="order-count"><?php echo $orderCount; ?></span>
                <span class="order-period">Last 7 Days</span>
            </div>
        </section>

        <!-- Menu Cards Container -->
        <section class="menu-cards-container">

            <!-- Favorite Menu Card -->
            <div class="menu-card">
                <img src="<?php echo "../assets/images/products/".$favoriteMenu['image']; ?>" alt="<?php echo $favoriteMenu['item_name']; ?>">
                <h2>Your Favourite Menu</h2>
                <div class="menu-info">
                    <span class="menu-name"><?php echo $favoriteMenu['item_name']; ?></span>
                    <hr> <!-- Gray line separating name from time -->
                    <div class="update-info">
                        <img src="../assets/icons/clock.svg" alt="Clock">
                        <span>updated <?php echo $favoriteMenu['last_updated']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Top Selling Menu Card -->
            <div class="menu-card">
                <img src="<?php echo "../assets/images/products/".$topSellingMenu['image']; ?>" alt="<?php echo $topSellingMenu['item_name']; ?>">
                <h2>Top Selling Menu</h2>
                <div class="menu-info">
                    <span class="menu-name"><?php echo $topSellingMenu['item_name']; ?></span>
                    <hr> <!-- Gray line separating name from time -->
                    <div class="update-info">
                        <img src="../assets/icons/clock.svg" alt="Clock">
                        <span>updated <?php echo $topSellingMenu['last_updated']; ?></span>
                    </div>
                </div>
            </div>

        </section>

        
    </main>
    <?php include "../include/footer.php" ?>
</body>
</html>