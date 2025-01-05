<?php
include "../../model/database_model.php"; // Include the database connection class
$db = new Database();
$con = $db->conn;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="image/svg" rel="icon" href="../../assets/icons/Logo.svg">
    <title>Transaction Record</title>
</head>
<body>
    <?php include "../../include/admin/sidebar.php"; ?>

    <!-- Content of dashboard -->
    <div class="dashboard-content">
        <div class="top-dashboard">
            <h5>Transaction Record</h5>
            <div class="search">
                <form method="post">
                    <input type="search" name="search" class="txt-search" placeholder="Search">
                    <button type="submit" name="search" class="btn-search"><i class="fa fa-search"></i></button>
                </form>
            </div>    
        </div>
 
        <div class="table-record">
            <!-- Content for Transaction Summary -->
            <div class="display-data-record">
                <h5>Transaction Summary</h5>
                
                <div class="display-trans">
                    <table>
                        <tr>
                            <th>Bil</th>
                            <th>Transaction ID</th>
                            <th>Client Name</th>
                            <th>Amount (RM)</th>
                            <th>Date</th>
                        </tr>
                        <?php
                        // Fetch transaction records
                        $query = "SELECT t.transaction_id, 
                                         t.transaction_date, 
                                         t.order_id, 
                                         o.total_amount AS total, 
                                         u.first_name, 
                                         u.last_name 
                                  FROM transaction t
                                  INNER JOIN `order` o ON t.order_id = o.order_id
                                  INNER JOIN user u ON o.user_id = u.user_id";
                        $result = mysqli_query($con, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $sn = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                                    <td><?php echo "RM " . number_format($row['total'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($row['transaction_date']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <div class="error">
                                        No Transaction Records Found.
                                    </div>
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

</body>
</html>
