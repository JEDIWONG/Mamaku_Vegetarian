    <?php
    include "../../model/database_model.php"; // Include database connection class
    $db = new Database();
    $con = $db->conn;

    // Handle adding a new category
    if (isset($_POST['add_category'])) {
        $new_category = mysqli_real_escape_string($con, $_POST['new_category']);
        $category_desc = mysqli_real_escape_string($con, $_POST['category_desc']);

        if (!empty($new_category)) {
            // Check if the category already exists
            $check_category = mysqli_query($con, "SELECT * FROM product_category WHERE name = '$new_category'");
            if (mysqli_num_rows($check_category) > 0) {
                echo "<script> alert('Category already exists!'); </script>";
            } else {
                $add_category_query = "INSERT INTO product_category (name, description) VALUES ('$new_category', '$category_desc')";
                if (mysqli_query($con, $add_category_query)) {
                    echo "<script> alert('Category added successfully!'); </script>";
                } else {
                    echo "<script> alert('Failed to add category. Please try again.'); </script>";
                }
            }
        } else {
            echo "<script> alert('Category name cannot be empty!'); </script>";
        }
    }

    // Handle adding a new menu item
    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($con, $_POST['tmenu']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $category_id = mysqli_real_escape_string($con, $_POST['series']); // Store category_id directly

        // File upload logic
        $img = $_FILES['upload']['name'];
        $temp_img = $_FILES['upload']['tmp_name'];
        $size_img = $_FILES['upload']['size'];
        $max_size = 1 * 1024 * 1024; // 1MB
        $upload_dir = "../../assets/images/";

        // Generate a unique file name to avoid overwriting
        $img_basename = time() . "_" . basename($img);
        $target_file = $upload_dir . $img_basename;

        if ($size_img > $max_size) {
            echo "<script> alert('Image must be smaller than 1MB!'); </script>";
        } else {
            // Check if menu already exists
            $select_menu = mysqli_query($con, "SELECT * FROM product WHERE name = '$title'");
            if (mysqli_num_rows($select_menu) > 0) {
                echo "<script> alert('Menu already exists!'); </script>";
            } else {
                if (move_uploaded_file($temp_img, $target_file)) {
                    $query = "INSERT INTO product (name, description, price, image, category_id) 
                            VALUES ('$title', '$desc', '$price', '$img_basename', '$category_id')";

                    if (mysqli_query($con, $query)) {
                        echo "<script> alert('Menu added successfully!'); window.location.href='menu.php'; </script>";
                    } else {
                        echo "<script> alert('Failed to add menu. Please try again.'); </script>";
                    }
                } else {
                    echo "<script> alert('Failed to upload the image. Please try again.'); </script>";
                }
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Menu</title>
        <style>
            .add-category-form {
                display: none; /* Initially hidden */
                margin-top: 20px;
            }
        </style>
        <script>
            function toggleAddCategory() {
                const form = document.getElementById("add-category-form");
                if (form.style.display === "none" || form.style.display === "") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }
        </script>
    </head>
    <body>
        <?php include "../../include/admin/sidebar.php"; ?>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="top-dashboard">
                <h5>Edit Menu > <p class="highlight">Create Menu</p></h5>
            </div>

            <!-- Form to Add New Menu Item -->
            <form method="post" enctype="multipart/form-data">
                <div class="add-menu">
                    <div class="txt-add">
                        <label for="tmenu">Title:</label>
                        <input type="text" name="tmenu" id="tmenu" class="inline-form" required>
                    </div>
                    <div class="txt-add">
                        <label for="price">Price (RM):</label>
                        <input type="number" name="price" id="price" class="inline-form" step="0.50" required>
                    </div>
                    <div class="txt-add">
                        <label for="desc">Description:</label>
                        <textarea name="desc" id="desc" class="inline-form"></textarea>
                    </div>
                    <div class="txt-add">
                        <label for="upload">Upload Picture:</label>
                        <input type="file" name="upload" id="upload" class="inline-form" accept=".png, .jpg, .jpeg" required>
                    </div>
                    <div class="txt-add">
                        <label for="series">Select Category:</label>
                        <select name="series" id="series" class="inline-form" required>
                            <?php
                            $category_query = "SELECT * FROM product_category";
                            $categories = mysqli_query($con, $category_query);
                            while ($category = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$category['category_id']}'>" . htmlspecialchars($category['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="btn-add">
                        <button type="button" onclick="toggleAddCategory()" class="btn">Add Category</button>
                    </div>
                </div>
                <div class="btn-add">
                    <button type="submit" name="submit" class="btn">Save</button>
                    <a class="btn" href="menu.php">Cancel</a>
                </div>
            </form>

            <!-- Form to Add New Category (Initially Hidden) -->
            <form method="post" id="add-category-form" class="add-category-form">
                <h5>Add New Category</h5>
                <div class="txt-add">
                    <label for="new_category">Category Name:</label>
                    <input type="text" name="new_category" id="new_category" class="inline-form" required>
                </div>
                <div class="txt-add">
                    <label for="category_desc">Description:</label>
                    <textarea name="category_desc" id="category_desc" class="inline-form"></textarea>
                </div>
                <div class="txt-add">
                    <button type="submit" name="add_category">Add Category</button>
                </div>
            </form>
        </div>
    </body>
    </html>
