<?php
session_start();
include('connection.php'); // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "Error: You need to log in to add items to your wishlist.";
    exit();
}

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate the product ID
if ($productId <= 0) {
   // echo $productId;
    echo "Error: Invalid product ID.";
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user'];

// Check if the product is already in the wishlist
$checkStmt = mysqli_prepare($conn, "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
if (!$checkStmt) {
    echo "Error preparing check statement: " . mysqli_error($conn);
    exit();
}
mysqli_stmt_bind_param($checkStmt, "ii", $userId, $productId);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($checkResult) > 0) {
    echo "Error: Product already in wishlist.";
    mysqli_stmt_close($checkStmt);
    mysqli_close($conn);
    exit();
}

// Fetch the product name to store in the wishlist
$productNameStmt = mysqli_prepare($conn, "SELECT title FROM products WHERE id = ?");
if (!$productNameStmt) {
    echo "Error preparing product name statement: " . mysqli_error($conn);
    exit();
}
mysqli_stmt_bind_param($productNameStmt, "i", $productId);
mysqli_stmt_execute($productNameStmt);
$productNameResult = mysqli_stmt_get_result($productNameStmt);
$productNameRow = mysqli_fetch_assoc($productNameResult);
$productName = $productNameRow['title'];

mysqli_stmt_close($productNameStmt);

// Prepare the SQL statement to insert into the wishlist
$stmt = mysqli_prepare($conn, "INSERT INTO wishlist (user_id, product_id, added_on, status, product_name) VALUES (?, ?, NOW(), 'active', ?)");
if (!$stmt) {
    echo "Error preparing insert statement: " . mysqli_error($conn);
    exit();
}

mysqli_stmt_bind_param($stmt, "sis", $userId, $productId, $productName);
$result = mysqli_stmt_execute($stmt);

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
            window.location.href = 'product_details.php?id=" . $productId . "'; // Redirect to the correct product details page
        }
            setTimeout(closePopup, 2000);
        </script>
    </head>
    <body>
        <div id='popup'>
            <p>Success: Product added to wishlist!</p>
        </div>
    </body>
    </html>
    ";
} else {
    echo "Error: Could not add product to wishlist. " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
