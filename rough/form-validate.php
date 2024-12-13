<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {     
    
    //echo "before $regno";
    $regno = $_POST['regno'];
    
    // echo "before select";
    $sql = "SELECT * FROM Register WHERE regno = '$regno'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql); 
    
    // Check if there are rows
    if (mysqli_num_rows($result) > 0) {
       echo "exists";
       return false;
    } else {
        echo "available";
        return true;
    }
    }
?>