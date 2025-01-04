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

    // Get sorting options from the dropdown
    $orderColumn = $_GET['order'] ?? 'transaction_date'; // Default sorting column
    $orderDirection = strtoupper($_GET['direction'] ?? 'DESC'); // Default sorting direction

    // Validate order column and direction
    $validColumns = ['transaction_id', 'transaction_date', 'transaction_time', 'payment_method', 'total_amount'];
    if (!in_array($orderColumn, $validColumns)) {
        $orderColumn = 'transaction_date';
    }
    if (!in_array($orderDirection, ['ASC', 'DESC'])) {
        $orderDirection = 'DESC';
    }

    try {
        
        $stmt = $conn->prepare("
            SELECT 
                t.transaction_id, 
                t.order_id,
                t.payment_method, 
                o.total_amount, 
                DATE(t.transaction_date) AS transaction_date, 
                TIME(t.transaction_date) AS transaction_time 
            FROM transaction t
            JOIN `order` o ON t.order_id = o.order_id
            WHERE o.user_id = ?
            ORDER BY $orderColumn $orderDirection
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

            <!-- Sorting Dropdown -->
            <form method="GET" class="sorting-form">
                <label for="order">Sort by:</label>
                <select name="order" id="order">
                    <option value="transaction_date" <?php echo ($orderColumn === 'transaction_date') ? 'selected' : ''; ?>>Date</option>
                    <option value="transaction_time" <?php echo ($orderColumn === 'transaction_time') ? 'selected' : ''; ?>>Time</option>
                    <option value="payment_method" <?php echo ($orderColumn === 'payment_method') ? 'selected' : ''; ?>>Payment Method</option>
                    <option value="total_amount" <?php echo ($orderColumn === 'total_amount') ? 'selected' : ''; ?>>Total Amount</option>
                </select>

                <label for="direction">Order:</label>
                <select name="direction" id="direction">
                    <option value="ASC" <?php echo ($orderDirection === 'ASC') ? 'selected' : ''; ?>>Ascending</option>
                    <option value="DESC" <?php echo ($orderDirection === 'DESC') ? 'selected' : ''; ?>>Descending</option>
                </select>

                <button type="submit">Sort</button>
            </form>

            <table class="transaction-table">
                <thead>
                    <tr class="transaction-header">
                        <th>No</th>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Payment Method</th>
                        <th>Total Amount (RM)</th>
                    </tr>
                </thead>
                <tbody class="transaction-row">
                    <?php if (!empty($transactions)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr data-transaction-id="<?php echo htmlspecialchars($transaction['order_id']); ?>">
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['transaction_time']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['payment_method']); ?></td>
                                <td><?php echo number_format($transaction['total_amount'], 2); ?></td>
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
        <script src="../script/transaction.js"></script>
    </body>
</html>