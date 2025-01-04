<?php
    // Get the current page name from the URL
    $currentPage = basename($_SERVER['PHP_SELF'], ".php");

    session_start();

    $adminId = $_SESSION['user_id'];

    if(!isset($adminId))
    {
        header("Location: ../login.php");
        exit;
    }

    $fname = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "Admin";
    $lname = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : "";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="image/png" rel="icon" href="../../assets/logo/Logo.png">
<link rel="stylesheet" href="../../style/admin/header.css">
<link rel="stylesheet" href="../../style/admin/footer.css">
<link rel="stylesheet" href="../../style/admin/dashboard.css">
<link rel="stylesheet" href="../../style/admin/display_data.css">
<link rel="stylesheet" href="../../style/admin/menu_edit.css">

<div class="header-left">
    <div class="side-nav">
        <b class="title">
            <img class="logo" src="../../assets/icons/Logo.svg" alt="logo"> Mamaku Vegetarian
        </b>
        <ul class="nav-links">
            <li>
                <p class="dear">Dear</p>
                <h6 class="name"><?php echo $fname . " " . $lname; ?></h6>
            </li>
            <li class="<?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>">
                <a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="<?php echo ($currentPage == 'menu') ? 'active' : ''; ?>">
                <a href="menu.php"><i class="fa fa-edit"></i> Edit Menu</a>
            </li>
            <li class="<?php echo ($currentPage == 'record') ? 'active' : ''; ?>">
                <a href="record.php"><i class="fa fa-exchange"></i> Transaction Record</a>
            </li>
            <li class="<?php echo ($currentPage == 'users') ? 'active' : ''; ?>">
                <a href="users.php"><i class="fa fa-id-card-o"></i> Member Account</a>
            </li>
        </ul>
        <a href="../../controller/logout.php" class="btn-logout"><i class="fa fa-sign-out"></i> Logout</a>
    </div>
</div>
