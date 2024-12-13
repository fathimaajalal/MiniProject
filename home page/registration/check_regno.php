<?php
include 'connection.php'; // Replace with your database connection file

$regno = $_POST['regno'];

$sql = "SELECT * FROM Users WHERE regno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo 'exists';
} else {
  echo 'available';
}

$stmt->close();
$conn->close();
?>
