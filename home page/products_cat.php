<?php
// Include database connection
include 'connection.php';

// Get the category from the query string
$category = $_GET['category'] ?? '';
if($category==='All Categories'){
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s");
    $stmt->execute();
    $result = $stmt->get_result();
} else{
    $sql = "SELECT * FROM products WHERE category = ? and is_sold='0'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
}
// Fetch products based on the category

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Include Poppins Font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start; /* Align items to the start */
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            gap: 20px; /* Add space between products */
        }   
        
        .product-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: calc(25% - 20px);
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none; /* Prevent underline for the entire item */
        }
        .product-item:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .product-item a {
            text-decoration: none; /* Remove underline from entire link */
            color: inherit; /* Ensure text color inheritance */
        }
        .product-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }
        .product-info h3 {
            /* font-size: 16px; */
            margin: 0;
            color: #333;
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
            font-family: 'Poppins', sans-serif;
            text-decoration: none; /* Remove underline from title by default */
        }
        .product-info h3::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            display: block;
            margin-top: 5px;
            right: 0;
            background: #e53935;
            transition: width 0.3s ease;
            -webkit-transition: width 0.3s ease;
        }
        .product-info h3:hover::after {
            width: 100%;
            left: 0;
            background-color: #e53935;
        }
        .product-info p {
            margin: 5px 0;
            color: #666;
            /* font-size: 14px; */
            text-decoration: none; /* Ensure no underline on price */
        }
        .product-info .price {
            font-size: 18px;
            font-weight: bold;
            color: #e53935;
            font-family: 'Poppins', sans-serif;
            text-decoration: none; /* Prevent underline on price */
        }
    </style>
</head>
<body>
    <section class="product-list">
        <?php
        // Assuming $result contains the product data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product-item'>
                        <a href='product_details.php?id=" . $row['id'] . "'>
                            <img src='uploads/" . $row['image'] . "' alt='" . htmlspecialchars($row['title']) . "'>
                            <div class='product-info'>
                                <h3>" . htmlspecialchars($row['title']) . "</h3>
                                <p class='price'>Rs. " . htmlspecialchars($row['price']) . "</p>
                            </div>
                        </a>
                    </div>";
            }
        } else {
            echo "<p>No products found in this category.</p>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </section>
</body>
</html>
