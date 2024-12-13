<?php
    session_start();
    include 'connection.php';

    // Assuming the user is logged in
    $user_id = $_SESSION['user'] ?? '';

    // Get the product ID from the query string
    $product_id = $_GET['id'] ?? '';

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "Product not found.";
        exit;
    }

    // Extract the seller's registration number (regno)
    $seller_regno = $product['regno'];

    // Check if the product is already in the wishlist
    $wishlist_check_sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $wishlist_check_stmt = $conn->prepare($wishlist_check_sql);
    $wishlist_check_stmt->bind_param("si", $user_id, $product_id);
    $wishlist_check_stmt->execute();
    $wishlist_result = $wishlist_check_stmt->get_result();
    $is_in_wishlist = $wishlist_result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .product-details {
            display: flex;
            align-items: center;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .product-details img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            margin-right: 20px;
        }
        .product-info {
            flex: 1;
        }
        .product-info h2 {
            margin: 0;
        }
        .product-info p {
            margin: 5px 0;
            color: #666;
        }
        .product-info .price {
            font-weight: bold;
            color: #e53935;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-container a {
            text-decoration: none;
            background-color: #e60000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s ease;
            flex: 1;
            margin: 0 10px;
        }

        .button-container a:hover {
            background-color: #b30000;
        }

        .call-button {
            background-color: #28a745;
        }

        .call-button:hover {
            background-color: #218838;
        }

        .wishlist-button {
            background-color: #e53935;
        }

        .wishlist-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <section class="product-details">
        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['title']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price">Rs. <?php echo htmlspecialchars($product['price']); ?></p>
            <p>Location: <?php echo htmlspecialchars($product['location']); ?></p>
            <p>Seller: <?php echo htmlspecialchars($product['seller']); ?></p>
            <p>Contact: <?php echo htmlspecialchars($product['contact']); ?></p>
            
            <div class="button-container">
                <!-- Updated Chat Button with Seller's regno -->
                <!-- <a href="chat_interface.html?receiver_regno=<?php echo $seller_regno; ?>" class="chat-button">Chat with Seller</a> -->
                <a href="tel:<?php echo htmlspecialchars($product['contact']); ?>" class="call-button">Call</a>
                
                <!-- Display appropriate button based on wishlist status -->
                <?php if ($is_in_wishlist): ?>
                    <a href="remove_from_wishlist.php?id=<?php echo htmlspecialchars($product_id); ?>" class="wishlist-button">Remove from Wishlist</a>
                <?php else: ?>
                    <a href="add_to_wishlist.php?id=<?php echo htmlspecialchars($product_id); ?>" class="wishlist-button">Add to Wishlist</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>

<?php
    // Close statements and connections
    $wishlist_check_stmt->close();
    $stmt->close();
    $conn->close();
?>
