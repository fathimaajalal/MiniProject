<?php
// Include database connection
include 'connection.php';

// Get the search query from the form
$searchQuery = $_GET['q'] ?? '';

// Protect against SQL injection and prepare the search pattern
$searchPattern = "%" . $conn->real_escape_string($searchQuery) . "%";

// Fetch products from the database that match the search query
$sql = "SELECT * FROM products 
        WHERE (title LIKE ? OR description LIKE ? OR category LIKE ? OR tags LIKE ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $searchPattern, $searchPattern, $searchPattern, $searchPattern);


$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</title>
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
            display: block; /* Ensure the entire area is clickable */
            height: 100%; /* Make the link cover the entire product-item */
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .product-item {
                width: calc(33.333% - 20px);
            }
        }
        @media (max-width: 768px) {
            .product-item {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .product-item {
                width: 100%;
            }
        }
        
        /* Optional: Style for No Results Message */
        .no-results {
            text-align: center;
            padding: 50px 20px;
            font-size: 18px;
            color: #666;
        }

        /* Optional: Style for Header */
        .header {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h1>
    </div>
    <section class="product-list">
        <?php
        // Check if any results are found
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Ensure to escape any output to prevent XSS
                $title = htmlspecialchars($row['title']);
                $price = htmlspecialchars($row['price']);
                $image = htmlspecialchars($row['image']);
                $id = htmlspecialchars($row['id']);
                echo "<div class='product-item'>
                        <a href='product_details.php?id={$id}'>
                            <img src='uploads/{$image}' alt='{$title}'>
                            <div class='product-info'>
                                <h3>{$title}</h3>
                                <p class='price'>Rs. {$price}</p>
                            </div>
                        </a>
                    </div>";
            }
        } else {
            echo "<div class='no-results'>No products found for your search query.</div>";
        }
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </section>
</body>
</html>
