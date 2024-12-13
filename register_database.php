<?php

include 'connection.php';

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit']))
{
    $name=$_POST['name'];
    $regno=$_POST['regno'];
    $phoneNumber=$_POST['phoneNumber'];
    $password=$_POST['password'];

    $sql="INSERT INTO Users(name,regno,phoneNumber,password)
            VALUES('$name','$regno','$phoneNumber','$password')";

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