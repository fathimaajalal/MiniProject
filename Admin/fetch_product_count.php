<?php
include 'connection.php';

// SQL query to count products
// $sql = "SELECT COUNT(*) as product_count FROM products";

$sql = "SELECT COUNT(*) as product_count FROM products";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $productCount = $row['product_count'];

    // Return the product count as JSON
    echo json_encode(['product_count' => $productCount]);
} else {
    echo json_encode(['error' => 'Error fetching product count']);
}

mysqli_close($conn);
?>