<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "c_a_m";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user ID is passed via session or URL
$userId = 1; // Replace with actual user ID

// Get the updated values from the form
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$regno = $_POST['regno'];
$phoneNumber = $_POST['phoneNumber'];

// Update the user's profile in the database
$sql = "UPDATE users SET firstName='$firstName', lastName='$lastName', regno='$regno', phoneNumber='$phoneNumber' WHERE id=$userId";

if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully";
} else {
    echo "Error updating profile: " . $conn->error;
}

$conn->close();
?>
