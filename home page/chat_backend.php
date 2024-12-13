<?php
session_start();
include('connection.php'); // Replace with your database connection file

$sender_regno = $_SESSION['regno']; // The logged-in user
$receiver_regno = $_POST['receiver_regno']; // The recipient's regno
$action = $_POST['action'];

if ($action == 'send') {
    $message_text = $_POST['message_text'];
    $sql = "INSERT INTO Messages (sender_regno, receiver_regno, message_text) VALUES ('$sender_regno', '$receiver_regno', '$message_text')";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
    }
} elseif ($action == 'retrieve') {
    $sql = "SELECT * FROM Messages 
            WHERE (sender_regno='$sender_regno' AND receiver_regno='$receiver_regno') 
               OR (sender_regno='$receiver_regno' AND receiver_regno='$sender_regno')
            ORDER BY timestamp";
    $result = mysqli_query($conn, $sql);

    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    echo json_encode($messages);
}
?>
