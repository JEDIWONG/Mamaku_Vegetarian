<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="image/png" rel="icon" href="../../assets/logo/Logo.png">
    <link rel="stylesheet" href="../../style/admin/header.css">
    <link rel="stylesheet" href="../../style/admin/footer.css">
    <link rel="stylesheet" type="text/css" href="../../style/admin/dashboard.css">
    <script src="../../script/function.js"></script>
    <title>Admin Dashboard</title>
</head>
<body>

   <?php include "../../include/admin/sidebar.php" ?>

    <!--content of dashboard -->
    <div class="dashboard-content">
        <div class="top-dashboard">
            <h5>Dashboard</h5>
            <div class="search">
                <form method="post">
                <input type="search" name="search" class="txt-search" placeholder="Search" disabled>
                <button type="submit" name="search" class="btn-search" disabled><i class="fa fa-search" ></i></button>
                </form>
            </div>    
            <div class="right-side">
                <button class="btn-icon"><i class="fa fa-bell"></i></button>
                <div class="wrap-menu-bell">
                    <div class="menu-bell">
                    <div class="menu-user">
                       
                    </div>
                    </div>
                </div>
            </div>
            <div class="right-side-2">
            <button data-target="#subMenuUser" onclick="toggleMenu()"><i class="fa fa-user"></i></button>
                <div class="wrap-menu-user" id="subMenuUser">
                    <div class="menu-user">
                        <div class="user-i">
                            <h4>Hi,<?php echo $admin_fname ;?></h4>
                        </div>
                        <hr>
                        <a href="../../public/auth/logout.php" class="btn-logout-user"><i class="fa fa-sign-out"></i>Logout</a>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="display-menu">
          
        </div>
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