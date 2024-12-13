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

// Assuming regno is passed via session or URL
$regno=$_SESSION['regno'];

$sql = "SELECT firstName, lastName, regno, phoneNumber FROM users WHERE regno = '$regno'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No user found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profilepage_01style.css">
</head>
<body>
    <div class="profile-container">
        <h1>Profile Information</h1>
        <div class="profile-info">
            <p><strong>First Name:</strong> <?php echo $row['firstName']; ?></p>
            <p><strong>Last Name:</strong> <?php echo $row['lastName']; ?></p>
            <p><strong>ID Number:</strong> <?php echo $row['regno']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $row['phoneNumber']; ?></p>
        </div>
        <button onclick="location.href='editprofilepage.php'">Edit Profile</button>
    </div>
</body>
</html>
