<?php
session_start(); // Start the session
include 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>
            alert('You need to log in to upload lost and found products.');
            if (confirm('Would you like to log in now?')) {
                window.location.href = 'login/login.php';
            } else {
                window.location.href = 'home_page.php';
            }
        </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $itemName = $conn->real_escape_string($_POST['itemName']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $dateFound = $conn->real_escape_string($_POST['dateFound']);
    $contact = $conn->real_escape_string($_POST['contact']);

    // Get user registration number from session
    $regno = $_SESSION['user'];
    // $name = "SELECT name from Users  WHERE regno = '$regno'";

    // Image upload handling
    $targetDir = "uploads/";
    $fileName = basename($_FILES["itemImage"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;

    // Move the uploaded file to the target directory
    move_uploaded_file($_FILES["itemImage"]["tmp_name"], $targetFilePath);

    // Store only the image file name (not the full path) in the database
    $imageName = time() . "_" . $fileName;

    // Insert into the database
    $sql = "INSERT INTO lost_found_items (item_name, description, location, date_found, contact, image, regno) 
            VALUES ('$itemName', '$description', '$location', '$dateFound', '$contact', '$imageName', '$regno')";

    if ($conn->query($sql) === TRUE) {
        echo "Item uploaded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect back to the form page
    header("Location:lostfound_01html.php");
    exit();
}
?>

 
