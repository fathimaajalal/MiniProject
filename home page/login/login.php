<?php
session_start();
include 'connection.php';  

if (isset($_SESSION['user'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header("Location: ../../Admin/admin_dash.php");
    } else {
        header("Location: ../user_dash.php");
    }
    exit();
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $regno = $_POST['regno'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT regno, password, user_type FROM Users WHERE regno = ?");
    mysqli_stmt_bind_param($stmt, "s", $regno);  // Bind parameter
    mysqli_stmt_execute($stmt);  // Execute statement
    $result = mysqli_stmt_get_result($stmt);  // Get result
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
        // Compare the password (using plain-text comparison, but consider password hashing)
        if ($password === $user['password']) {
            // Login successful, set session variables
            $_SESSION['user'] = $user['regno'];  // Store regno in session
            $_SESSION['user_type'] = $user['user_type'];  // Store user type in session

            // Redirect based on user type
            if ($user['user_type'] === 'admin') {
                header("Location: ../../Admin/admin_dash.php");  // Redirect admin to dashboard
            } else {
                header("Location: ../user_dash.php");  // Redirect regular user to user dashboard
            }
            exit();
        } else {
            echo '<div class="error-message">Incorrect Password!</div>';
        }
    } else {
        // User not found
        echo '<div class="error-message">User not found!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
<video autoplay muted loop class="background-video">
    <source src="gandhi_sq.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
<div class="wrapper">
    <form action="" method="POST">
        <h1>LOGIN</h1>
        <div class="input-box">
            <input type="text" name="regno" placeholder="Register Number" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="remember-forgot">
            <label><input type="checkbox">Remember Me</label>
            <a href="forgot_password.php">Forgot Password</a>
        </div>
        <div class="form-submit-btn">
            <input type="submit" id="submit" name="submit" value="Log In">
        </div>
        <div class="register-link">
            <p>Don't have an account? <a href="registration.php">Register</a></p>
        </div>
    </form>
</div>
</body>
</html>
