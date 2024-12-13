<?php
// Include database connection
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete from request table
    $sql = "DELETE FROM donation_requests WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dash.php?status=rejected");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No donation ID provided.";
}

$conn->close();
?>
