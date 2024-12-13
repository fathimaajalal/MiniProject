function validate(){

    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    
    const regno = document.getElementById('regno').value;
    const registerNumberRegex = /^\d{2}[a-zA-Z]{3}\d{3}$/;

    const phoneNumber = document.getElementById('phoneNumber').value;

    const indianPhoneNumberRegex = /^\+?91[\-\s]?\d{10}$/;

    const passwords = document.getElementById('passwords').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if(firstname == '' || lastname == '' || regno == '' || phoneNumber == '' || passwords =''){
            alert('Fields cannot be empty');
            return false;
    }
    if (passwords !== confirmPassword) {
    alert("Passwords do not match");
    return false;
  }
  if (phoneNumber) { // Only validate if the field is not empty
    if (!indianPhoneNumberRegex.test(phoneNumber)) {
      alert("Invalid Indian phone number format");
      return false;
    }
  }
  if (regno) {
    if (!registerNumberRegex.test(regno)) {
      alert("Invalid register number format");
      return false;
    }
  }
  return true;
  }