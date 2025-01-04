<?php

    include '../../model/database_model.php';
    session_start();

    $adminId = $_SESSION['user_id'];

    if(!isset($adminId))
    {
        header("Location: ../login.php");
        exit;
    }

    if(isset($_POST['id']))
    {
        $id = $_POST['id'];
        $query = "SELECT * FROM `menu_items` WHERE menu_id = '$id'";
        $menu_selected = mysqli_query($con,$query);
        if(mysqli_num_rows($menu_selected )>0)
        {
            $row = mysqli_fetch_assoc($menu_selected );
            $menu_id = $row['menu_id'];
            $menu = $row['menu_name'];
            $price = $row['menu_price'];
            $desc = $row['menu_desc'];
            $img = $row['menu_image'];
            $series = $row['series_type'];

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="image/png" rel="icon" href="../../assets/logo/Logo.png">
    <link rel="stylesheet" href="../../style/dashboard.css">
    <link rel="stylesheet" href="../../style/header.css">
    <link rel="stylesheet" href="../../style/footer.css">
    <link rel="stylesheet" href="../../style/menu_edit.css">
    <script src="../../script/function.js"></script>
    <title>Add Menu</title>
</head>
<body>
    <?php include "../../include/admin/sidebar.php" ?>

    <!--content of dashboard -->
    <div class="dashboard-content">
        <div class="top-dashboard">
            <h5>Edit Menu</h5>
            <div class="search">
                <form method="post">
                <input type="search" name="search" class="txt-search" placeholder="Search" disabled>
                <button type="submit" name="search" class="btn-search" disabled><i class="fa fa-search"></i></button>
                </form>
            </div>    
            <div class="right-side">
                <a href=""><i class="fa fa-bell"></i></a>
                <a href=""><i class="fa fa-user"></i></a>
            </div>
        </div>

        <?php
        
        if(isset($_POST['update']))
        {
            $id_up = $_POST['ID'];
            $menu_up = mysqli_real_escape_string($con,$_POST['tmenu']);
            $price_up = mysqli_real_escape_string($con,$_POST['price']);
            $desc_up = mysqli_real_escape_string($con,$_POST['desc']);
            $type =$_POST['series'];
            //declaration for file and image
            $upload = mysqli_real_escape_string($con,$_FILES['upload']['name']);
            $temp_img= $_FILES['upload']['tmp_name'];
            $size_img = $_FILES['upload']['size'];

            $folder = "../../assets/upload/". $upload;
            
            

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
                    if($check = "../../assets/upload/".$img)
                    {
                        unlink($check);
                        $pic=$upload;
                        move_uploaded_file($temp_img,$folder);
                    }
                    
                }
            }
               
            $update = "UPDATE menu_items SET menu_name = '$menu_up',menu_price = '$price_up', menu_desc ='$desc_up ', menu_image ='$pic',series_type='$type' WHERE menu_id = '$id_up'";
                
                        if(!mysqli_query($con, $update))
                        {
                            echo "<script> alert('Error : Data update not successfully!'); location.href ='menu.php';</script>";
                        }else{
                        
                        echo "<script> alert('Data update successfully!'); location.href ='menu.php';</script>";
                        }
            
        }
        

        if(isset($_POST['delete']))
        {
            $id_up = $_POST['ID'];
            if($check = "../../assets/upload/". $_POST['img_old'])
            {
                unlink($check); 
                        
            }
            $delete_data = "DELETE FROM `menu_items` WHERE menu_id = '$id_up' LIMIT 1";
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
                    <input type="hidden" name="ID" value="<?php echo $menu_id?>">
                    <label for="tmenu">Title:</label>
                    <input type="text" name="tmenu" id="tmenu" class="inline-form" value="<?php echo $menu; ?>" required>
                </div>
                <div class="btn-delete">
                    <button type="submit" name="delete" onclick="javascript: return confirm('Are you sure you want to delete this item <?php echo $series;?>');"><i class="fa fa-trash"></i></button>
                </div>
                <div class="txt-add">
                    <label for="price">Price(RM):</label>
                    <input type="number" name="price" id="price" class="inline-form" value="<?php echo $price; ?>" min="0.5" step="0.5" required>
                </div>
                <div class="txt-add">
                    <label for="desc">Description:</label>
                    <textarea name="desc" id="desc" class="inline-form"><?php echo $desc; ?></textarea>
                </div>
                <div class="txt-add">
                    <label for="upload">Upload Picture:</label>
                    <input type="file" name="upload" id="upload" class="inline-form" accept=".png, .jpg, .jpeg">
                    <input type="hidden" name="img_old" value="<?php echo $img;?>">
                    <img id="img-view" alt="image" src="../../assets/upload/<?php echo $img;?>" width="100cqi" height="100cqi" style="margin-left:20cqi;margin-top: -18cqi;">
                </div>
                <div class="txt-add">
                    <label for="series">Select Series:</label>
                    <select name="series" id="series" class="inline-form" required>
                        <option value="Fried Series" <?php if($series == "Fried Series")echo "selected='selected'";?>>Fried Series</option>
                        <option value="Green Vegetables Series" <?php if($series == "Green Vegetables Series") echo "selected='selected'";?>>Green Vegetables Series</option>
                    </select>
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
            <p class="title-footer"><img class="logo-footer" src="../../assets/logo/Logo.png" alt="logo">Mamaku Vegetarian</p>
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