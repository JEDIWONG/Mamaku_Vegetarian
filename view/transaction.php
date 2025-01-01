<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../model/database_model.php';
$db = new Database();
$conn = $db->conn;

$transactions = [];

try {
    // Query all transactions for the logged-in user
    $stmt = $conn->prepare("
        SELECT 
            t.transaction_id, 
            t.order_id, 
            t.payment_method, 
            DATE(t.transaction_date) AS transaction_date, 
            TIME(t.transaction_date) AS transaction_time 
        FROM transaction t
        JOIN `order` o ON t.order_id = o.order_id
        WHERE o.user_id = ?
        ORDER BY t.transaction_date DESC
    ");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
} catch (Exception $e) {
    echo "Error fetching transactions: " . $e->getMessage();
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/transaction.css">

</head>
<body>

    <?php include "../include/sidebar.php" ?>

    <main>
        <h1>Transaction History</h1>
        <table class="transaction-table">
            <thead>
                <tr class="transaction-header">
                    <th>Transaction ID</th>
                    <th>Order ID</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_time']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    
</body>
</html>
