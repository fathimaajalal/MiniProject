<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Responsive Registration Form</title>
    <meta name="viewport" content="width=device-width,
      initial-scale=1.0"/>
    <link rel="stylesheet" href="login_style.css" />

  <!-- ----------------- SCRIPT BEGIN -----------------  -->
  <script>

    function validateForm(){

      var firstname = document.getElementById('firstname').value;
      var lastname = document.getElementById('lastname').value;
      var regno = document.getElementById('regno').value;
      var phoneNumber = document.getElementById('phoneNumber').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if(!checkPhone(phoneNumber)){
        alert("Phone number format is wrong");
        return false;
      }

      if(!checkPassword(password,confirmPassword)){
        alert("Passwords do not match");
        return false;
      }
      if(!checkReg(regno)){
        alert("Register number format is wrong");
        return false;
    }

    function checkPhone(phoneNumber){

      var pattern = /^[6789]\d{9}$/ ;
      var isValid = pattern.test(phoneNumber);

      if (!isValid) {
        return false;
      }
      return true;
    }
      
    function checkPassword(password,confirmPassword){

      if (password !== confirmPassword) {
      return false;
      }

      return true;

  }
  
  function checkReg(regno){
    var pattern= /^\d{2}[a-zA-Z]{3}\d{3}$/ ;
    return pattern.test(regno);
  }
}
  
function checkRegnoAvailability() {
  const regno = document.getElementById('regno').value;
  const regnoError = document.getElementById('regno-error');

  // AJAX request to check regno availability
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'check_regno.php', true); // Use synchronous request for simplicity
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200) {
      const response = xhr.responseText;
      if (response === 'exists') {
        regnoError.textContent = 'Register number already exists';
        return false;
      } else {
        regnoError.textContent = '';
        return true;
      }
    } else {
      console.error('Error checking regno availability:', xhr.statusText);
      return false;
    }
  };
  xhr.send(`regno=${regno}`);
}

</script>

</head>
  <body>
  <video autoplay muted loop class="background-video">
    <source src="gandhi_sq.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
    <div class="wrapper">
     <form onsubmit="return validateForm()" action="register_database.php" method="POST" >
        <!-- <div class="wrapper"> -->
        <h1 class="reg-form-title">REGISTRATION</h1>

          <div class="input-box">
            <!-- <label for="lastname"> Name</label> -->
              <input type="text"
                      id="name"
                      name="name"
                      placeholder="Enter Full name" 
                      required/>
          </div>

          <div class="input-box">
            <!-- <label for="regno">Register Number</label> -->
              <input type="text"
                      id="regno"
                      name="regno"
                      placeholder="Eg., 22UBC129" 
                      onkeyup = "checkRegnoAvailability()"
                      required/>   

                      <p style='color:red;font-size:12px' id='regno-error'></p>
          </div>

          <div class="input-box">
            <!-- <label for="phoneNumber">Phone Number</label> -->
              <input type="text"
                      id="phoneNumber"
                      name="phoneNumber"
                      placeholder="Enter a 10 digit phone number"
                      required />
                      
          </div>

          <div class="input-box">
            <!-- <label for="password">Password</label> -->
              <input type="password"
                      id="password"
                      name="password"
                      placeholder="Enter Password"
                      required/>
          </div>

          <div class="input-box">
            <!-- <label for="confirmPassword">Confirm Password</label> -->
              <input type="password"
                      id="confirmPassword"
                      name="confirmPassword"
                      placeholder="Confirm Password"
                      required/>
          </div>

        <!-- </div> -->
        <div class="form-submit-btn">
          <input type="submit" id="submit" name="submit" value="Register" >
        </div>
      </form>

    </div>
  </body>
</html>
