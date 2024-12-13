<?php
include 'connection.php';

// SQL query to count orders
$sql = "SELECT COUNT(*) as order_count FROM orders";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $orderCount = $row['order_count'];

    // Return the order count as JSON
    echo json_encode(['order_count' => $orderCount]);
} else {
    echo json_encode(['error' => 'Error fetching order count']);
}

mysqli_close($conn);
?>
