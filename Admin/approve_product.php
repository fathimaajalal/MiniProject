<?php
// Include database connection
include 'connection.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get product details from the request table, including the user (regno)
    $sql = "SELECT * FROM request WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $regno = $row['user']; // Fetch the user (regno) from the request table

        // Get the user's name from the Users table
        $user_sql = "SELECT name FROM Users WHERE regno = '$regno'";
        $user_result = $conn->query($user_sql);

        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $seller = $user_row['name']; // Get the user's name to use as the seller

            // Insert into the products table with regno and seller fields
            $insert_sql = "INSERT INTO products (title, description, category, conditions, price, location, contact, image, regno, seller)
                    VALUES ('" . $conn->real_escape_string($row['title']) . "', 
                            '" . $conn->real_escape_string($row['description']) . "', 
                            '" . $conn->real_escape_string($row['category']) . "', 
                            '" . $conn->real_escape_string($row['conditions']) . "', 
                            '" . $conn->real_escape_string($row['price']) . "', 
                            '" . $conn->real_escape_string($row['location']) . "', 
                            '" . $conn->real_escape_string($row['contact']) . "', 
                            '" . $conn->real_escape_string($row['image']) . "', 
                            '" . $conn->real_escape_string($regno) . "', 
                            '" . $conn->real_escape_string($seller) . "')";

            if ($conn->query($insert_sql) === TRUE) {
                // Delete from the request table after approval
                $delete_sql = "DELETE FROM request WHERE id = $id";
                if ($conn->query($delete_sql) === TRUE) {
                    // Redirect to the admin dashboard
                    header("Location: admin_dash.php");
                    exit();
                } else {
                    echo "Error deleting from request table: " . $conn->error . "<br>";
                }
            } else {
                echo "Error inserting into products table: " . $conn->error . "<br>";
            }
        } else {
            echo "User not found in the Users table.<br>";
        }
    } else {
        echo "Product not found in the request table.<br>";
    }
} else {
    echo "No product ID provided in the URL.<br>";
}

$conn->close();
?>
