<?php
// fetch_area_chart_data.php
require 'connection.php'; // Include your database connection

// Query to get the order counts grouped by month
$queryOrders = "SELECT MONTH(order_date) as month, COUNT(*) as order_count FROM orders GROUP BY MONTH(order_date)";

$orderResult = $conn->query($queryOrders);

$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$orderCounts = array_fill(0, 12, 0); // Initialize an array for the counts

// Populate order counts based on the fetched data
while ($row = $orderResult->fetch_assoc()) {
    $orderCounts[$row['month'] - 1] = (int)$row['order_count'];
}

echo json_encode([
    'order_counts' => $orderCounts,
    'labels' => $months,
]);
?>
