<?php
include 'connection.php';

// SQL query to count donations
$sql = "SELECT COUNT(*) as donation_count FROM donations";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $donationCount = $row['donation_count'];

    // Return the donation count as JSON
    echo json_encode(['donation_count' => $donationCount]);
} else {
    echo json_encode(['error' => 'Error fetching donation count']);
}

mysqli_close($conn);
?>
