<?php
session_start();
include('connection.php'); // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Error: You need to log in to remove items from your wishlist.'); window.location.href='login.php';</script>";
    exit();
}

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate the product ID
if ($productId <= 0) {
    echo "<script>alert('Error: Invalid product ID.'); window.history.back();</script>";
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user'];

// Check if the product exists in the wishlist
$checkStmt = mysqli_prepare($conn, "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
if (!$checkStmt) {
    echo "<script>alert('Error preparing check statement: " . mysqli_error($conn) . "'); window.history.back();</script>";
    exit();
}
mysqli_stmt_bind_param($checkStmt, "ii", $userId, $productId);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($checkResult) === 0) {
    echo "<script>alert('Error: Product not found in wishlist.'); window.location.href='wishlist.php';</script>";
    mysqli_stmt_close($checkStmt);
    mysqli_close($conn);
    exit();
}

mysqli_stmt_close($checkStmt);

// Prepare the SQL statement to remove the product from the wishlist
$removeStmt = mysqli_prepare($conn, "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
if (!$removeStmt) {
    echo "<script>alert('Error preparing delete statement: " . mysqli_error($conn) . "'); window.history.back();</script>";
    exit();
}

mysqli_stmt_bind_param($removeStmt, "ii", $userId, $productId);
$result = mysqli_stmt_execute($removeStmt);

if ($result) {
    $message = "Success: Product removed from wishlist.";
} else {
    $message = "Error: Could not remove product from wishlist. " . mysqli_error($conn);
}

mysqli_stmt_close($removeStmt);
mysqli_close($conn);

// If the product was successfully removed, show the popup
if ($result) {
    echo "
    <html>
    <head>
        <style>
            #popup {
                position: fixed;
                top: 20%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 20px;
                background-color: #f8f8f8;
                border: 2px solid #4CAF50;
                border-radius: 8px;
                text-align: center;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }
        </style>
        <script>
            function closePopup() {
                document.getElementById('popup').style.display = 'none';
                window.location.href = 'product_details.php?id=" . $productId . "'; // Redirect to the product details page
            }
            setTimeout(closePopup, 3000);
        </script>
    </head>
    <body>
        <div id='popup'>
            <p>$message</p>
            <p>Redirecting to product details in 3 seconds...</p>
        </div>
    </body>
    </html>
    ";
} else {
    // If the product could not be removed, show an alert and redirect
    echo "<script>alert('$message'); window.location.href='wishlist.php';</script>";
}
?>
