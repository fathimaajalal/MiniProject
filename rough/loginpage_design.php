<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="loginpage_stylesheet.css">
  <!-- <link href="loginpage_stylesheet.css" rel='stylesheet'> -->
</head>
<body>
  <div class="wrapper">
    <?php
    include 'connection.php';

    if(isset($_POST['submit']))
    {
        $regno = $_POST['regno'];
        $password = $_POST['password'];

        $sql = "SELECT password FROM Register WHERE regno = '$regno'";
        $result = mysqli_query($conn, $sql); 
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        if($user){
            if(password_verify($password,$user['password'])){
                //login successful
                session_start();
                $_SESSION['user'] = $user["regno"];
                header("Location: formdemo.html");
            }
        }
    ?>

  <div class="wrapper">
    <form action="" method = "POST">
      <h1>LOGIN</h1>
      <div class="input-box">
        <input type="text" placeholder="Register Number" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox">Remember Me</label>
        <a href="#">Forgot Password</a>
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