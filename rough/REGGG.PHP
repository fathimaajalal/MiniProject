<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="loginpage_stylesheet.css">
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
        alert("password do not match");
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
</script>
</head>
<body>
<div class="wrapper">

<form onsubmit="return validateForm()" action="register_database.php" method="POST" >
      <h1>REGISTRATION</h1>
      <div class="input-box">
          <label for="userType">User Type</label>
          <select id="userType" name="userType" required>
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
          </select>
        </div>


      <div class="input-box">
        <input type="text" name="firstname" placeholder="Full Name" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
              <input type="text"
                      id="regno"
                      name="regno"
                      placeholder="Register Number Eg., 22UBC129" 
                      required/>   
                      <i class='bx bxs-lock-alt' ></i>
                      <p style='color:red;font-size:12px' id='user-warn'></p>
          </div>

          <div class="input-box">
              <input type="text"
                      id="phoneNumber"
                      name="phoneNumber"
                      placeholder="Phone number"
                      required />
                      <i class='bx bxs-lock-alt' ></i>
                      <p style='color:red;font-size:12px' id='user-warn'></p>
          </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
          <div class="form-submit-btn">
        <input type="submit" id="submit" name="submit" value="Register" >
      </div>
    </form>
  </div>
</body>
</html>



<!-- ----------------- CHECK REGNO BEGIN -----------------  -->
  <!-- // function checkRegNo(){

  //   var regno = document.getElementById('regno').value;
  //   var warn = document.getElementById("user-warn");

  //   if (!isValidReg(regno)) {
  //       warn.innerText = "Invalid Register number format";
  //       warn.style.color = "red";
  //       warn.style.display = 'block';
  //       return false;
  //   } else {

  //       warn.innerText = "Valid Register number format";

  //       var xhr = new XMLHttpRequest();
  //       xhr.open("GET", 'form-validate.php',true);
  //       //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  //       // works till this part, doesnt enter into the function

  //       xhr.onload = function(){
  //           if(xhr.status == 200){
  //               console.log(xhr.responseText);
  //               if(xhr.responseText.trim() === "exists"){
  //                   console.log(xhr.responseText);
  //                   document.getElementById("user-warn").textContent = "Register Number already exists";
  //               }
  //               else{
  //                   document.getElementById("user-warn").textContent = "";
  //               }
  //           }

  //     //  var params = "regno=" + encodeURIComponent(regno);
  //       xhr.send();
  //       document.getElementById("user-warn").textContent = "Register Number already exists";
  //     } -->

  <!-- //   }

  // } -->
  <!-- ----------------- CHECK REGNO END  -----------------  -->
<!-- ----------------- USER TYPE BEGIN  -----------------  -->
   <!-- <div class="user-input-box">
             <label for="userType">User Type</label>
           <select id="userType" name="userType" required>
        <option value="buyer">Buyer</option>
                 <option value="seller">Seller</option>
               </select>   

          </div> -->
<!-- ----------------- USER TYPE END  -----------------  -->