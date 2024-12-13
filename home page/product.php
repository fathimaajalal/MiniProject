<?php
include 'db_connection.php'; // Include your database connection file

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
} else {
    echo "No product found.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['product_name']; ?> Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo $row['product_name']; ?></h1>
    <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['product_name']; ?>">
    <p>Price: Rs. <?php echo $row['price']; ?></p>
    <p>Description: <?php echo $row['description']; ?></p>
    <!-- <p>Seller:  < php echo $row['seller_name']; ?></p> -->
    <button onclick="window.location.href='chat_with_seller.php?seller_id=<?php echo $row['seller_id']; ?>'">Chat with Seller</button>
    <button onclick="window.location.href='tel:+91<?php echo $row['seller_phone']; ?>'">Call Seller</button>
</body>
</html>
