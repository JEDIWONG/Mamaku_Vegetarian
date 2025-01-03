<?php
// Simulating data fetch from a database
$orderCount = 6; 
$favoriteMenu = [
    'name' => 'Fried Enoki Mushroom',
    'image' => '../assets/images/fried_enoki_mushroom.png',
    'lastUpdated' => '4 minutes ago'
];
$topSellingMenu = [
    'name' => 'Fried Enoki Mushroom',
    'image' => '../assets/images/fried_enoki_mushroom.png',
    'lastUpdated' => '4 minutes ago'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/dashboard.css"> 
</head>
<body>

    <!-- Sidebar inclusion -->
    <?php include "../include/sidebar.php"; ?>

    <!-- Main Dashboard Content -->
    <main class="dashboard-container">
        
        <!-- Order Summary Card -->
        <div class="order-card">
            <div class="order-icon">
                <img src="../assets/icons/order_box.svg" alt="Order Icon">
            </div>
            <div class="order-info">
            <span class ="order-name">Order</span>
                <span class="order-count"><?php echo $orderCount; ?></span>
                <span class="order-period">Last 7 Days</span>
            </div>
        </div>

        <!-- Menu Cards Container -->
        <div class="menu-cards-container">

            <!-- Favorite Menu Card -->
            <div class="menu-card">
                <img src="<?php echo $favoriteMenu['image']; ?>" alt="<?php echo $favoriteMenu['name']; ?>">
                <h2>Your Favourite Menu</h2>
                <div class="menu-info">
                    <span class="menu-name"><?php echo $favoriteMenu['name']; ?></span>
                    <hr> <!-- Gray line separating name from time -->
                    <div class="update-info">
                        <img src="../assets/icons/clock.svg" alt="Clock">
                        <span>updated <?php echo $favoriteMenu['lastUpdated']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Top Selling Menu Card -->
            <div class="menu-card">
                <img src="<?php echo $topSellingMenu['image']; ?>" alt="<?php echo $topSellingMenu['name']; ?>">
                <h2>Top Selling Menu</h2>
                <div class="menu-info">
                    <span class="menu-name"><?php echo $topSellingMenu['name']; ?></span>
                    <hr> <!-- Gray line separating name from time -->
                    <div class="update-info">
                        <img src="../assets/icons/clock.svg" alt="Clock">
                        <span>updated <?php echo $topSellingMenu['lastUpdated']; ?></span>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
