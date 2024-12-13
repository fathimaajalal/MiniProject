<?php
session_start();

// Check if the user is logged in and the regno exists in the session
if (isset($_SESSION['regno'])) {
    echo json_encode(['regno' => $_SESSION['regno']]);
} else {
    echo json_encode(['error' => 'User not logged in']);
}
?>
