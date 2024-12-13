<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet"   
 href="login_style.css">
</head>
<body>
<?php

include 'connection.php';

if (isset($_POST['submit'])) {

    $regno = $_POST['regno'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT password, user_type FROM Users WHERE regno = ?");
    mysqli_stmt_bind_param($stmt, "s", $regno);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
        if ($password === $user['password']) {
            // Login successful
            session_start();
            $_SESSION['user'] = $user["regno"];
            $_SESSION['user_type'] = $user["user_type"];

            if ($user['user_type'] === 'admin') {
                header("Location: demo/index_copy.html");
            } else {
                header("Location: formdemo.html");
            }
            exit();
        } else {
            echo "Incorrect Password!";
        }
    } else {
        // User not found
        echo "User not found";
    }
}

?>

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
      <i class='bx bxs-lock-alt' ></i>   

    </div>
    <div class="remember-forgot">
      <label><input type="checkbox">Remember Me</label>
      <a href="forgot_password.php">Forgot Password</a>
    </div>   

    <div class="form-submit-btn">
      <input type="submit" id="submit" name="submit" value="Log In" >
    </div>
    <div class="register-link">
      <p>Dont have an account? <a href="registration.php">Register</a></p>
    </div>
  </form>
</div>
</body>
</html>

