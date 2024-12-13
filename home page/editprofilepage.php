<?php
session_start();
include "connection.php";

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login if session not set
    header("Location: login.php");
    exit();
}

$regno = $_SESSION['user'];

// Fetch current user details
$sql = "SELECT regno, phoneNumber, name FROM Users WHERE regno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];

    // Update query to modify user details
    $updateSql = "UPDATE Users SET name = ?, phoneNumber = ?, password = ? WHERE regno = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssss", $name, $phoneNumber, $password, $regno);

    if ($updateStmt->execute()) {
        // Redirect to success page
        header("Location: success.php");
        exit();
    } else {
        echo "Error updating profile.";
    }

    $updateStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit-profile.css">
</head>
<body>
    <div class="profile-container">
        <form action="editprofilepage.php" method="post">
            <h1>Edit Profile</h1>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br>

            <label for="phoneNumber">Phone Number:</label>
            <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($row['phoneNumber']); ?>" required><br>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password" style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;"><br>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
