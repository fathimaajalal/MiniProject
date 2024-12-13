<?php
// fetch_buyer_regno.php
require 'connection.php'; // Include your database connection

if (isset($_GET['buyer_name'])) {
    $buyer_name = $_GET['buyer_name'];

    // Query to fetch the regno based on the buyer's name
    $stmt = $conn->prepare("SELECT regno FROM Users WHERE name = ?");
    $stmt->bind_param("s", $buyer_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['regno' => $row['regno']]);
    } else {
        echo json_encode(['regno' => null]);
    }
} else {
    echo json_encode(['regno' => null]);
}
?>
