<?php
include 'connection.php';

$query = $_GET['query'];

// SQL query to search for products
$sql = "SELECT * FROM products WHERE name LIKE '%" . $query . "%'";
$result = mysqli_query($conn, $sql);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Return search results as JSON
echo json_encode($products);