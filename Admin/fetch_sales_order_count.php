<?php
include 'connection.php';

// SQL query to count sales orders
$sql = "SELECT COUNT(*) as sales_order_count FROM sales_order";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $salesOrderCount = $row['sales_order_count'];

    // Return the sales order count as JSON
    echo json_encode(['sales_order_count' => $salesOrderCount]);
} else {
    echo json_encode(['error' => 'Error fetching sales order count']);
}

mysqli_close($conn);
?>