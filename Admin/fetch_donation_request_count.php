<?php
include 'connection.php';

// SQL query to count sales orders
$sql = "SELECT COUNT(*) as donation_request_count FROM donation_requests";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $donationRequestCount = $row['donationt_request_count'];

    // Return the sales order count as JSON
    echo json_encode(['donation_request_count' => $donationRequestCount]);
} else {
    echo json_encode(['error' => 'Error fetching donation request count']);
}

mysqli_close($conn);
?>
