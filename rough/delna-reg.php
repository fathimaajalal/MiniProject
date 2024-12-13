<?php

    $servername="localhost";
    $username="root";
    $password="";
    $dbname="C_A_M";

$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error)
{
    die("connection error".$conn->connect_error);
}
echo "connected sucsessfully";

if(isset($_POST['submit']))
{
    //echo "inside insert";

    $regno=$_POST['regno'];

   // echo "before insert into";


    $sql="SELECT * FROM Register regno = '$regno'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "taken";
    } else {
        echo "available";
    }
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST")
    {


        
        //echo "inside insert";

        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $regno=$_POST['regno'];
        $phoneNumber=$_POST['phoneNumber'];
        $passwords=$_POST['passwords'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($passwords !== $confirmPassword) {
            die("Passwords do not match");
         
          }
?>
<html>
          <body>
          <div class="container">
            <h1 class="form-title">Registration</h1>
      
           <form action="register_database.php" method="post" >
              <div class="main-user-info">
      
                <div class="user-input-box">
                  <label for="firstname">First Name</label>
                    <input type="text"
                            id="firstname"
                            name="firstname"
                            placeholder="Enter First Name" 
                            required/>
                </div>
      
                <div class="user-input-box">
                  <label for="lastname">Last Name</label>
                    <input type="text"
                            id="lastname"
                            name="lastname"
                            placeholder="Enter Last name" 
                            required/>
                </div>
      
                <div class="user-input-box">
                  <label for="regno">Register Number</label>
                    <input type="text"
                            id="regno"
                            name="regno"
                            placeholder="Eg., 22UBC129" 
                            onkeyup = "checkRegNo()" 
                            required/>
      
                            <p style='color:red;font-size:12px' id='user-warn'></p>
                            <!-- pattern = "/^\d{2}[a-zA-Z]{3}\d{3}$/"; -->
                </div>
      
                <div class="user-input-box">
                  <label for="phoneNumber">Phone Number</label>
                    <input type="text"
                            id="phoneNumber"
                            name="phoneNumber"
                            placeholder="Enter a 10 digit phone number"
                            />
                </div>
      
                <div class="user-input-box">
                  <label for="passwords">Password</label>
                    <input type="password"
                            id="passwords"
                            name="passwords"
                            placeholder="Enter Password"
                            required/>
                </div>
      
                <div class="user-input-box">
                  <label for="confirmPassword">Confirm Password</label>
                    <input type="password"
                            id="confirmPassword"
                            name="confirmPassword"
                            placeholder="Confirm Password"
                             <!-- = "checkPassword()"  -->
                            required/>
                </div>
      
              </div>
              <div class="form-submit-btn">
                <input type="submit" id="submit" name="submit" value="Register" >
              </div>
            </form>
          </div>
        </body>
      </html>
      <script>
        function togglePassword(fieldId, btn) {
            const passField = document.getElementById(fieldId);
            if (passField.type === "password") {
                passField.type = "text";
                btn.style.color = "#3498db";
                btn.textContent = "HIDE";
            } else {
                passField.type = "password";
                btn.style.color = "#222";
                btn.textContent = "SHOW";
            }
        }

       
          

        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var phoneNumber = document.getElementById('phoneNumber').value;
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            // Validate first and last names
            if (firstName.charAt(0) !== firstName.charAt(0).toUpperCase() ||
                lastName.charAt(0) !== lastName.charAt(0).toUpperCase()) {
                alert('First and Last names must start with an uppercase letter.');
                event.preventDefault();
                return;
            }

            // Validate phone number
            if (phoneNumber.length !== 10 || isNaN(phoneNumber)) {
                alert('Phone number must be exactly 10 digits.');
                event.preventDefault();
                return;
            }

            // Validate password
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (!passwordRegex.test(password)) {
                alert('Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.');
                event.preventDefault();
                return;
            }

            // Validate confirm password
            if (password !== confirmPassword) {
                alert('Confirm Password must be equal to Password.');
                event.preventDefault();
                return;
            }
        });
        function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function emailCheck() {
    var email = document.getElementById('email').value;
    var emailWarn = document.getElementById('email-warn');

    if (!isValidEmail(email)) {
        emailWarn.innerText = "Invalid email format";
        emailWarn.style.color = "red";
        emailWarn.style.display = 'block';
        return;
    } else {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'individual user registration.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status == 200) {
                console.log("Response received: " + xhr.responseText);
                if (xhr.responseText.trim() === "taken") {
                    console.log("Email status: taken");
                    emailWarn.textContent = "Email already exists";
                    emailWarn.style.color = "red";
                    emailWarn.style.display = 'block';
                } else {
                    console.log("Email status: available");
                    emailWarn.textContent = "Email approved";
                    emailWarn.style.color = "green";
                    emailWarn.style.display = 'block';
                }
            } else {
                console.log("Error in response: " + xhr.status);
            }
        };

        var params = "email_check=" + encodeURIComponent(email);
        console.log("Sending request with params: " + params);
        xhr.send(params);
    }
}
    </script>
</body>
</html>