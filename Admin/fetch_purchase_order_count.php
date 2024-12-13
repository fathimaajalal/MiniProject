<?php
include 'connection.php';

// SQL query to count purchase orders
$sql = "SELECT COUNT(*) as purchase_order_count FROM purchase_orders";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $purchaseOrderCount = $row['purchase_order_count'];

    // Return the purchase order count as JSON
    echo json_encode(['purchase_order_count' => $purchaseOrderCount]);
} else {
    echo json_encode(['error' => 'Error fetching purchase order count']);
}

mysqli_close($conn);
?>