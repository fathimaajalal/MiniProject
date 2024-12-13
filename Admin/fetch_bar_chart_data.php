<?php
// fetch_bar_chart_data.php
require 'connection.php'; // Include your database connection

$query = "SELECT category, COUNT(*) as count FROM products GROUP BY category";
$result = $conn->query($query);

$categories = [];
$counts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
        $counts[] = (int)$row['count'];
    }
}

// Check if categories and counts are populated
if (empty($categories) || empty($counts)) {
    echo json_encode(['categories' => [], 'counts' => []]); // Return empty data if no results
    exit;
}

echo json_encode(['categories' => $categories, 'counts' => $counts]);
?>
