<?php
// Include database connection
include 'connection.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

   // Get product details from the request table, including the user (regno)
   $sql = "SELECT * FROM donation_requests WHERE id = $id";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();
       $regno = $row['user']; // Fetch the user (regno) from the request table

       // Get the user's name from the Users table
       $user_sql = "SELECT name FROM Users WHERE regno = '$regno'";
       $user_result = $conn->query($user_sql);

       if ($user_result->num_rows > 0) {
           $user_row = $user_result->fetch_assoc();
           $donor = $user_row['name']; // Get the user's name to use as the donor

           // Insert into the products table with regno and seller fields
           $insert_sql = "INSERT INTO donations (product_name, description, category, conditions, location, contact, image_url, regno, donor)
                    VALUES ('" . $conn->real_escape_string($row['product_name']) . "', 
                            '" . $conn->real_escape_string($row['description']) . "', 
                            '" . $conn->real_escape_string($row['category']) . "', 
                            '" . $conn->real_escape_string($row['conditions']) . "', 
                            '" . $conn->real_escape_string($row['location']) . "', 
                            '" . $conn->real_escape_string($row['contact']) . "', 
                            '" . $conn->real_escape_string($row['image_url']) . "', 
                            '" . $conn->real_escape_string($regno) . "', 
                            '" . $conn->real_escape_string($donor) . "')";

                            // '" . $conn->real_escape_string($row['image']) . "', 
            if ($conn->query($insert_sql) === TRUE) {
                // Delete from the request table after approval
                $delete_sql = "DELETE FROM donation_requests WHERE id = $id";
                if ($conn->query($delete_sql) === TRUE) {
                    // Redirect to the admin dashboard
                    header("Location: admin_dash.php");
                    exit();
                } else {
                    echo "Error deleting from donation request table: " . $conn->error . "<br>";
                }
            } else {
                echo "Error inserting into donations table: " . $conn->error . "<br>";
            }
        } else {
            echo "User not found in the Users table.<br>";
        }
    } else {
        echo "Product not found in the donation request table.<br>";
    }
} else {
    echo "No donation ID provided in the URL.<br>";
}

$conn->close();
?>
