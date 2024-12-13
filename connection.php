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
    //echo "connected sucsessfully";  
?>