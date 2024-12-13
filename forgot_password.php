<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password Form</title>
  <link rel="stylesheet" href="forgot_style.css">
</head>
<body>
<?php

include 'connection.php';

if (isset($_POST['submit'])) {

    $regno = $_POST['regno'];
    $email = $_POST['email'];

    // Prepare the SQL statement to retrieve the user's password
    $stmt = mysqli_prepare($conn, "SELECT password FROM MailDemo WHERE regno = ? AND email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $regno, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
        // User found, send password via email
        $password = $user['password'];
        // Replace with your email sending logic (e.g., using PHPMailer)
        // send_email($email, "Your Password", "Your password is: $password");
        echo "Password sent to your email.";
    } else {
        // User not found
        echo "User not found";
    }
}

?>
<div class="wrapper">
    <form action="" method="POST">
    <h1>FORGOT PASSWORD</h1>
      <div class="input-box">
        <input type="text" name="regno" placeholder="Register Number" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="form-submit-btn">
        <input type="submit" id="submit" name="submit" value="Send Password" >
      </div>
      </form>
  </div>
</body>
</html>