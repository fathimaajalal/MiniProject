<?php
session_start();
include 'connection.php';

// Enable error reporting to see the exact issue
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Capture the POST data from AJAX request
$sender_regno = $_POST['sender_regno'] ?? '';
$receiver_regno = $_POST['receiver_regno'] ?? '';
$message = $_POST['message'] ?? '';

// Print the sender and receiver regno for debugging
echo "Sender: $sender_regno, Receiver: $receiver_regno, Message: $message";

// Validate the received data
if (empty($sender_regno) || empty($receiver_regno) || empty($message)) {
    echo "Invalid input.";
    exit;
}

// Prepare the SQL statement to insert the message into the database
$sql = "INSERT INTO messages (sender_regno, receiver_regno, message, timestamp) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

// Check for any errors in the statement preparation
if (!$stmt) {
    die("Database error (Prepare): " . $conn->error);
}

// Bind parameters and execute statement
$stmt->bind_param("sss", $sender_regno, $receiver_regno, $message);

// Check if the statement execution was successful
if ($stmt->execute()) {
    echo "Message sent successfully.";
} else {
    die("Database error (Execute): " . $stmt->error);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
