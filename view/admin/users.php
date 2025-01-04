<?php

    require_once "../../model/database_model.php";
    // Initialize the Database class
    $conn = new Database();

    $num = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/admin/menu_edit.css">
    <link rel="stylesheet" href="../../style/admin/display_data.css">
    <title>Member Account</title>
</head>
<body>
    <?php include "../../include/admin/sidebar.php" ?>

    <!-- Content of dashboard -->
    <div class="dashboard-content">
        <div class="top-dashboard">
            <h5>Member Account</h5>
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

        <div class="info-register">
            <div class="icon-users">
                <i class="fa fa-id-card-o"></i>
            </div>
            <h4>Registered Member</h4>
            <p>
                <?php 
                $number_user_query = "SELECT COUNT(*) AS total FROM `user` WHERE role = 'Member'";
                $res = $conn->query($number_user_query);

                if ($res) {
                    $row = $res->fetch_assoc();
                    echo $row['total'] ?? 0;
                } else {
                    echo "0";
                }
                ?>
            </p>
        </div>

        <div class="table-user">
            <h4>Registered Member Account</h4>
            <div class="right-search-user">
                <form method="post">
                    <input type="search" name="search" class="user-search" placeholder="Search">
                    <button type="submit" name="search" class="btn-search-user"><i class="fa fa-search"></i></button>
                    <select name="search-user-list">
                        <option value="">Default</option>
                        <option value="recent">Recently Updated</option>
                        <option value="az">Name (A-Z)</option>
                        <option value="za">Name (Z-A)</option>
                    </select>
                </form>
            </div>
            <div class="display-data-users">
                <div class="display-users">
                    <table>
                        <tr>
                            <th>Bil</th>
                            <th>MemberID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>                          
                            <th>Registration Date</th>
                        </tr>
                        <?php
                        $select_user_query = "SELECT * FROM `user` WHERE role = 'Member'";
                        $result = $conn->query($select_user_query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $num++; ?></td>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone_number']; ?></td>                                   
                                    <td><?php echo $row['created_at']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7">
                                    <div class="error">No Members Registered.</div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="left-info">
            <p class="title-footer"><img class="logo-footer" src="../../assets/logo/Logo.png" alt="logo"> Mamaku Vegetarian</p>
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
