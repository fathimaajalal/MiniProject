<?php

session_start();
include 'connection.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = $_SESSION['user'];

    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $conditions = $_POST['conditions'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";   
    $target_file = $target_dir . basename($image);

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert into request table
            $sql = "INSERT INTO request (user, title, description, category, conditions, price, location, contact, image)
                    VALUES ('$user', '$title', '$description', '$category', '$conditions', '$price', '$location', '$contact', '$image')";

        if ($conn->query($sql) === TRUE) {
            header("Location: success.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $conn->close();

?>