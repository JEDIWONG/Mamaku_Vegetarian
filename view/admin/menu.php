<?php
include "../../model/database_model.php"; // Include database connection class
$db = new Database();
$con = $db->conn;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/admin/menu_edit.css">
    <link rel="stylesheet" href="../../style/admin/display_data.css">
    <title>Edit Menu</title>

</head>
<body>
    <?php include "../../include/admin/sidebar.php"; ?>

    <!-- Content of dashboard -->
    <div class="dashboard-content">
        <div class="top-dashboard">
            <h5>Edit Menu</h5>
            <div class="search">
                <form method="post">
                    <input type="search" name="search" class="txt-search" placeholder="Search">
                    <select name="category" class="cate-search">
                        <option value="">Category</option>
                        <?php
                        // Fetch product categories
                        $category_query = "SELECT * FROM product_category";
                        $category_result = mysqli_query($con, $category_query);

                        while ($category = mysqli_fetch_assoc($category_result)) {
                            echo "<option value='{$category['category_id']}'>" . htmlspecialchars($category['name']) . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" name="search" class="btn-search"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="right-side">
                <a href=""><i class="fa fa-bell"></i></a>
                <a href=""><i class="fa fa-user"></i></a>
            </div>
        </div>
        <div class="btn-arrange">
            <a href="add_menu.php" class="btn-create">Add a Menu</a>
        </div>

        <div class="display-menu">
            <div class="displayData">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Price (RM)</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // Query to fetch products
                    $query = "SELECT product.*, product_category.name AS category_name 
                              FROM product 
                              LEFT JOIN product_category ON product.category_id = product_category.category_id";
                    $result = mysqli_query($con, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $sn = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
                                <td>
                                    <?php if (!empty($row['image'])) { ?>
                                        <img src="../../assets/upload/<?php echo htmlspecialchars($row['image']); ?>" alt="Menu Image" class="display-img">
                                    <?php } else { ?>
                                        <img src="../../assets/default-placeholder.png" alt="No Image" class="display-img">
                                    <?php } ?>
                                </td>
                                <td><?php echo "RM " . number_format($row['price'], 2); ?></td>
                                <td><?php echo $row['availability'] ? "Available" : "Unavailable"; ?></td>
                                <td>
                                    <a href="edit_menu.php?id=<?php echo $row['product_id']; ?>" class="btn-view">Edit</a>
                                    <a href="delete_menu.php?id=<?php echo $row['product_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this menu item?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7">
                                <div class="error">No Menu Items Found.</div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="left-info">
            <p class="title-footer"><img class="logo-footer" src="../../assets/logo/Logo.png" alt="logo">Mamaku Vegetarian</p>
            <h5>Student Pavilion UNIMAS</h5>
            <p>93400 Kota Samarahan, Sarawak</p>
        </div>
        <div class="contact-info">
            <ul class="ctc">
                <li class="ctc-title"><p>Contact Us</p></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
            </ul>
        </div>
        <div class="btm-footer">
            <p>Copyright &copy; Mamaku Vegetarian All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
