<?php

    include '../../model/database_model.php';
    $db = new Database();
    $con = $db->conn;


    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $query = "SELECT product.*, product_category.name AS category_name 
                    FROM product 
                    LEFT JOIN product_category ON product.category_id = product_category.category_id 
                    WHERE product.product_id = '$id'";
        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $menu = $row['name'];
            $desc = $row['description'];
            $price = $row['price'];
            $availabel = $row['availability'];
            $img = $row['image'];
            $cate= $row['category_name'];

        }else{
            echo "<script>alert('Data Error! : No-Data able View!'); location.href ='menu.php';</script>";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../script/function.js"></script>
    <link rel="icon" type="image/svg" href="../../assets/icons/Logo.svg">
    <title>Add Menu</title>
</head>
<body>
    <?php include "../../include/admin/sidebar.php" ?>

    <!--content of dashboard -->
    <div class="dashboard-content">
        <div class="top-dashboard">
            <h5>Edit Menu</h5>
    
        </div>

        <?php
        
        if(isset($_POST['update']))
        {
            $id_up = $_GET['id'];
            $menu_up = mysqli_real_escape_string($con,$_POST['tmenu']);
            $price_up = mysqli_real_escape_string($con,$_POST['price']);
            $desc_up = mysqli_real_escape_string($con,$_POST['desc']);
            $type =$_POST['series'];
            $avai_up = mysqli_real_escape_string($con,$_POST['avai']);
            //declaration for file and image
            $upload = mysqli_real_escape_string($con,$_FILES['upload']['name']);
            $temp_img= $_FILES['upload']['tmp_name'];
            $size_img = $_FILES['upload']['size'];

            $folder = "../../assets/images/". $upload;
            
            

             //validation for image size
             $max_size = 1 * 1024 * 1024;
             if($size_img>$max_size)
             {
                 echo "<script> alert('Image must be larger than 1MB!'); </script>";
             }

            if($upload == NULL)
            {
                $pic = $_POST['img_old'];
            }else{
                if(file_exists($folder))
                {
                    echo "<script> alert('picture already exist'); </script>";
                }else{
                    if($check = "../../assets/images/".$img)
                    {
                        unlink($check);
                        $pic=$upload;
                        move_uploaded_file($temp_img,$folder);
                    }
                    
                }
            }
               
            $update = "UPDATE product SET category_id= '$type',name = '$menu_up', description ='$desc_up', price = '$price_up', availability = '$avai_up' , image ='$pic' WHERE product_id = '$id_up'";
                
                        if(!mysqli_query($con, $update))
                        {
                            echo "<script> alert('Error : Data update not successfully!'); location.href ='menu.php';</script>";
                        }else{
                        
                        echo "<script> alert('Data update successfully!'); location.href ='menu.php';</script>";
                        }
            
        }
        

        if(isset($_POST['delete']))
        {
            $id_up = $_GET['id'];
            if($check = "../../assets/images/". $_POST['img_old'])
            {
                unlink($check); 
                        
            }
            $delete_data = "DELETE FROM `product` WHERE product_id = '$id_up' LIMIT 1";
            if(!mysqli_query($con, $delete_data))
            {
                echo "<script> alert('Error : Data delete not successfully!'); location.href ='menu.php';</script>";
            }else{
            
            echo "<script> alert('Data Deleted successfully!'); location.href ='menu.php';</script>";
            }
        }
        
        ?>
       
        <form method="post" enctype="multipart/form-data">
        <div class="add-menu">
                <div class="txt-add">
                    <label for="tmenu">Title:</label>
                    <input type="text" name="tmenu" id="tmenu" class="inline-form" value="<?php echo $menu; ?>" required>
                </div>
                <div class="btn-delete">
                    <button type="submit" name="delete" onclick="javascript: return confirm('Are you sure you want to delete this item <?php echo $series;?>');"><i class="fa fa-trash"></i></button>
                </div>
                <div class="txt-add">
                    <label for="price">Price(RM):</label>
                    <input type="number" name="price" id="price" class="inline-form" value="<?php echo $price; ?>" required>
                </div>
                <div class="txt-add">
                    <label for="desc">Description:</label>
                    <textarea name="desc" id="desc" class="inline-form"><?php echo $desc; ?></textarea>
                </div>
                <div class="txt-add">
                    <label for="upload">Upload Picture:</label>
                    <input type="file" name="upload" id="upload" class="inline-form" accept=".png, .jpg, .jpeg">
                    <input type="hidden" name="img_old" value="<?php echo $img;?>">
                    <img id="img-view" alt="image" src="../../assets/images/<?php echo $img;?>">
                </div>
                <div class="txt-add">
                    <label for="series">Select Series:</label>
                    <select name="series" id="series" class="inline-form" required>
                    <?php
                        // Fetch product categories
                        $category_query = "SELECT * FROM product_category";
                        $category_result = mysqli_query($con, $category_query);

                        while ($category = mysqli_fetch_assoc($category_result)) {
                            if($cate == $category['name'])
                            {
                                echo "<option value='{$category['category_id']}' selected='selected'>" . htmlspecialchars($category['name']) . "</option>";
                            }
                            if($cate != $category['name'])
                            {
                                echo "<option value='{$category['category_id']}'>" . htmlspecialchars($category['name']) . "</option>";
                            }
                           
                        }
                        ?>
                    </select>
                </div>
                <div class="txt-add">
                    <label for="avai">Price(RM):</label>
                    <input type="number" name="avai" id="avai" class="inline-form" value="<?php echo $availabel; ?>" min="1" required>
                </div>
        </div>
                <div class="btn-add">
                    <button type="submit" name="update" class="btn">Update</button>
                    <a class="btn" href="menu.php">Cancel</a>
                </div>
        </form>
    </div>

    <div class="footer">
        <div class="left-info">
            <p class="title-footer"><img class="logo-footer" src="../../assets/images/Logo.svg" alt="logo">Mamaku Vegetarian</p>
            <h5>Student Pvaillion UNIMAS</h5>
            <p>93400 Kota Samarahan, Sarawak</p>
        </div>
        <div class="contact-info">
            <ul class="ctc">
                <li class="ctc-title"><p>Contact Us</p></li>
                <li><a href><i class="fa fa-instagram"></i></a></li>
                <li><a href><i class="fa fa-whatsapp"></i></a></li>
            </ul>
        </div>
        <div class="btm-footer">
            <p>Copyright &copy; Mamaku Vegetarian All right Reserved.</p>
        </div>  
    </div>
</body>
</html>