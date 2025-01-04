<?php
header("Content-Type: application/json");
require_once '../model/database_model.php';

$db = new Database();
$conn = $db->conn;

try {
    // Query to fetch monthly sales trends
    $query = "
        SELECT 
            MONTH(transaction_date) AS month, 
            DATE_FORMAT(transaction_date, '%M') AS month_name, 
            SUM(o.total_amount) AS total_sales 
        FROM transaction t
        JOIN `order` o ON t.order_id = o.order_id
        WHERE t.payment_status = 'Completed' 
        GROUP BY MONTH(transaction_date) 
        ORDER BY MONTH(transaction_date)
    ";

    $result = $conn->query($query);

    $salesTrends = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $salesTrends[] = [
                'month' => $row['month'],           // Numeric month
                'month_name' => $row['month_name'], // Full month name
                'total_sales' => (float) $row['total_sales'] // Total sales as float
            ];
        }

        // Return success response with data
        echo json_encode([
            'success' => true,
            'data' => $salesTrends
        ]);
    } else {
        // Return failure response
        echo json_encode([
            'success' => false,
            'error' => $conn->error
        ]);
    }
} catch (Exception $e) {
    // Return error response
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    $conn->close();
}



