<?php
include 'connection.php';

// SQL query to count sales orders
$sql = "SELECT COUNT(*) as product_request_count FROM request";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $productRequestCount = $row['product_request_count'];

    // Return the sales order count as JSON
    echo json_encode(['product_request_count' => $productRequestCount]);
} else {
    echo json_encode(['error' => 'Error fetching product request count']);
}

mysqli_close($conn);
?>