<?php

include 'connection.php';

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit']))
{
   // echo "inside insert";

    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $regno=$_POST['regno'];
    $phoneNumber=$_POST['phoneNumber'];
    $password=$_POST['password'];
// $confirmPassword=$_POST['confirmPassword'];

   //echo "before insert into";

    $sql="INSERT INTO Users(firstname,lastname,regno,phoneNumber,password)
            VALUES('$firstname','$lastname','$regno','$phoneNumber','$password')";

    echo "";
    echo "after insert into";

    
    if($conn->query($sql))
    {
        echo "records inserted successfully";
    }
    else
    {
        echo "error:".$connect_error;
    }
} 

?>
<!-- 
    
include 'connection.php';

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit']))
{
    // Sanitize input (example)
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $regno = mysqli_real_escape_string($conn, $_POST['regno']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $userType = 'user'; // Default user type

    $sql = "INSERT INTO Users (firstname, lastname, regno, phoneNumber, password, user_type) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $regno, $phoneNumber, $password, $userType);

        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}




-->