<?php
session_start(); // Start the session
include 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>
            alert('You need to log in to advertise.');
            if (confirm('Would you like to log in now?')) {
                window.location.href = 'login/login.php';
            } else {
                window.location.href = 'home_page.php';
            }
        </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $title = $_POST['title'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $hosted_by = $_POST['hosted_by']; // Field for who hosted the ad
    $date_posted = $_POST['date_posted']; // New field for the date

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";   
    $target_file = $target_dir . basename($image);

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert into advertisements table
        $sql = "INSERT INTO advertisements (title, location, description, image, hosted_by, date_posted) 
                VALUES ('$title', '$location', '$description', '$image', '$hosted_by', '$date_posted')";

        if ($conn->query($sql) === TRUE) {
            header("Location: success_ad.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD ADVERTISEMENT</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        
        font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
    }

    h1 {
            color: black; 
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }

        h1::after {
            content: '';
            display: block;
            width: 100%;
            height: 3px;
            background-color: #e60000; /* Red underline */
            position: absolute;
            left: 0;
            bottom: -10px;
        }

    form {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-size: 16px;
        color: #666; /* Medium gray for labels */
    }

    input[type="text"],
    input[type="date"],
    textarea,
    select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    textarea {
        resize: none;
    }

    input[type="file"] {
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 15px;
        background-color: #e60000; /* Red button */
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    button:hover {
        background-color: #b30000; /* Darker red on hover */
    }
</style>
<body>
    <div class="container">
        <form id="advertisement-form" action="add_advertisement.php" method="post" enctype="multipart/form-data">
            <h2>Add Advertisement</h2>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="location">Location:</label>
            <textarea id="location" name="location" required></textarea>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="hosted_by">Hosted By:</label>
            <input type="text" id="hosted_by" name="hosted_by" placeholder="Enter class/department/club/council" required>

            <label for="date_posted">Date:</label>
            <input type="date" id="date_posted" name="date_posted" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <p>
                <input type="checkbox" id="agree-terms"> I have read and agree to the <a href="terms_conditions.html" target="_blank">terms and conditions</a>.
            </p>
            <button type="button" onclick="checkTermsAndProceed()">Add Advertisement</button>
        </form>
    </div>
    <script>
        function checkTermsAndProceed() {
            const agreeTerms = document.getElementById('agree-terms').checked;
            if (!agreeTerms) {
                alert('You must agree to the terms and conditions before proceeding.');
                return;
            }
            document.getElementById('advertisement-form').submit(); // Submit the form if terms are accepted
        }
    </script>
</body>
</html>
