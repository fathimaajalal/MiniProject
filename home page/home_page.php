<?php
    session_start();
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Site</title>
    <link rel="stylesheet" href="home_style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="search.css"/>
	<!-- <link rel="stylesheet" href="chatgpt_categoerisstyle.css"/> -->
</head>
<body>
    <!-- Header Section -->


    <div class="parent-container">

        <!-- Navigation Links -->
        <a href="user_dash.php">Dashboard</a>
        <!-- <a href="#home">Home</a> -->
            <div class="dropdown_menu">
                <a href="#categories">Categories</a>
                <div class="dropdown-content">
                    <a href="products_cat.php?category=Electronics">Electronics</a>
                    <a href="products_cat.php?category=Hostel%20Materials">Hostel Materials</a>
                    <a href="products_cat.php?category=Study%20Materials">Study Materials</a>
                    <a href="products_cat.php?category=Stationary">Stationary</a>
                </div>
            </div>
          
          <div class="dropdown_menu">
            <a href="#login">Login</a>
            <div class="dropdown-content">
              <a href="login/login.php">Log In</a>
              <a href="registration/registration.php">Sign Up</a>
              <!-- <a href="#">Profile</a> -->
            </div>
          </div>
        
        <a href="add_advertisement.php" class="sell-button">Advertise</a>
        <a href ="donation_01.php" class="sell-button">Donate</a>
        <a href="seller_page.php" class="sell-button">SELL</a>
        <a href="lostfound_01html.php" class="sell-button">LOST & FOUND</a>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
        <form action="search.php" method="GET" class="search" id="search-bar">
            <input type="search" placeholder="Search something..." name="q" class="search__input">
            <div class="search__button" id="search-button">
                <i class="ri-search-2-line search__icon"></i>
                <i class="ri-close-line search__close"></i>
            </div>
        </form>
        </div>


        <div class="background-image" style="background-image: url('home_pic.jpg');"></div>
        <h1>Welcome to Connect at Marian! :)</h1>
    </section>

    <section class="featured-advertisements">
    <?php
        // Include database connection
        include 'connection.php';
        // Fetch advertisements from the database
        $sql = "SELECT id, hosted_by, title, description, location, image FROM advertisements"; 
        $result = $conn->query($sql);
    ?>
    <h2>Featured Advertisements</h2>
    <div class="ad-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $adId = htmlspecialchars($row['id']);
                $adTitle = htmlspecialchars($row['title']);
                $adImage = htmlspecialchars($row['image']);
                $adDescription = htmlspecialchars($row['description']);
                $adHostedBy = htmlspecialchars($row['hosted_by']);
                $adLocation = htmlspecialchars($row['location']);

                echo "<div class='ad'>
                    <div class='ad-image-container'>
                        <a href='ad_details.php?id=$adId' class='ad-link'>
                            <img src='uploads/$adImage' alt='$adTitle'>
                            <h3>$adTitle</h3>
                            <p class='ad-description' style='color: #666; font-size: 14px;'>$adDescription</p>
                            <p class='ad-location'>
                                <i class='fas fa-map-marker-alt' style='color: #e60000;'></i> $adLocation
                            </p>
                        </a>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No advertisements available.</p>";
        }
        $conn->close();
        ?>
    </div>
</section>

        <section class="featured-products">
            <?php
                // Include database connection
                include 'connection.php';
                // Fetch featured products from the database
                $sql = "SELECT id, title, description, price, image FROM products WHERE featured = '1' and is_sold='0'"; // Assuming you have a 'featured' column to mark products as featured
                    $result = $conn->query($sql);
            ?>
            <h2>Featured Products</h2>
            <div class="product-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $productId = htmlspecialchars($row['id']);
                        $productTitle = htmlspecialchars($row['title']);
                        $productImage = htmlspecialchars($row['image']);
                        $productDescription = htmlspecialchars($row['description']);
                        $productPrice = htmlspecialchars($row['price']);

                        // URL to add the product to the wishlist
                        $wishlistUrl = "add_to_wishlist.php?id=$productId";

                        // Check if the product is already in the wishlist
                        $isInWishlist = false;
                        if (isset($_SESSION['user'])) {
                            $userId = $_SESSION['user'];
                            $checkStmt = mysqli_prepare($conn, "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
                            mysqli_stmt_bind_param($checkStmt, "ii", $userId, $productId);
                            mysqli_stmt_execute($checkStmt);
                            $checkResult = mysqli_stmt_get_result($checkStmt);
                            if (mysqli_num_rows($checkResult) > 0) {
                                $isInWishlist = true;
                            }
                            mysqli_stmt_close($checkStmt);
                        }
                        
                        $wishlistClass = $isInWishlist ? 'filled' : '';

                        echo "<div class='product'>
                            <div class='product-image-container'>
                                <a href='product_details.php?id=$productId' class='product-link'>
                                    <img src='uploads/$productImage' alt='$productTitle'>
                                    <h3>$productTitle</h3>
                                    
                                <p style='color: #666; font-size: 14px;'>$productDescription</p>
                                <p>Rs. $productPrice</p>
                                </a>
                                <a href='$wishlistUrl' class='wishlist-icon $wishlistClass' title='Add to Wishlist'>
                <i class='fas fa-heart'></i>
            </a>

                            </div>
                        </div>";
                    }
                } else {
                    echo "<p>No featured products available.</p>";
                }
                $conn->close();
                ?>
            </div>

        </section>

        <section class="featured-products">
    <?php
    // Include database connection
    include 'connection.php';
    // Fetch donations from the database
    $sql = "SELECT id, product_name, description, image_url, category, conditions, location, contact, regno, donor FROM donations";
    $donationsResult = $conn->query($sql);
    ?>
    <h2>Available Donations</h2>
    <div class="product-grid">
        <?php
        if ($donationsResult->num_rows > 0) {
            while ($donation = $donationsResult->fetch_assoc()) {
                $donationId = htmlspecialchars($donation['id']);
                $donationTitle = htmlspecialchars($donation['product_name']);
                $donationImage = htmlspecialchars($donation['image_url']);
                $donationDescription = htmlspecialchars($donation['description']);
                $donationLocation = htmlspecialchars($donation['location']);
                $donorName = htmlspecialchars($donation['donor']);

                echo "<div class='product'>
                    <div class='product-image-container'>
                        <a href='donation_details.php?id=$donationId' class='product-link'>
                            <img src='uploads/$donationImage' alt='$donationTitle'>
                            <h3>$donationTitle</h3>
                            <p style='color: #666; font-size: 14px;'>$donationDescription</p>
                        
                        </a>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No donations available.</p>";
        }
        $conn->close();
    ?>
    </div>
</section>

<section class="featured-products">
    <?php
    // Include database connection
    include 'connection.php';
    // Fetch donations from the database
    $sql = "SELECT `id`, `item_name`, `description`, `location`, `date_found`, `image`, `regno`, `contact` FROM `lost_found_items`";
    $lostFoundResult = $conn->query($sql);
    ?>
    <h2>Lost & Found</h2>
    <div class="product-grid">
        <?php
        if ($lostFoundResult->num_rows > 0) {
            while ($lost_found_items = $lostFoundResult->fetch_assoc()) {
                $lostFoundId = htmlspecialchars($lost_found_items['id']);
                $lostFoundTitle = htmlspecialchars($lost_found_items['item_name']);
                $lostFoundImage = htmlspecialchars($lost_found_items['image']);
                $lostFoundDescription = htmlspecialchars($lost_found_items['description']);
                $lostFoundLocation = htmlspecialchars($lost_found_items['location']);
                $lostFoundContact = htmlspecialchars($lost_found_items['contact']);

                echo "<div class='product'>
                    <div class='product-image-container'>
                        <a href='lostFound_details.php?id=$lostFoundId' class='product-link'>
                            <img src='uploads/$lostFoundImage' alt='$lostFoundTitle'>
                            <h3>$lostFoundTitle</h3>
                            <p style='color: #666; font-size: 14px;'>$lostFoundDescription</p>
                        
                        </a>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No lost and found available.</p>";
        }
        $conn->close();
    ?>
    </div>
</section>




        <section class="shop-by-category">
            <h2>Shop by Category</h2>
            <div class="category-grid">
                
                <div class="category-item">
                    <a href="products_cat.php?category=Electronics" class="category-link">
                        <img src="electronics.jpg" alt="Electronics">
                        <h3>Electronics</h3>
                    </a>
                </div>
                <div class="category-item">
                    <a href="products_cat.php?category=Study%20Materials" class="category-link">
                        <img src="study_materials.jpg" alt="Study Materials">
                        <h3>Study Materials</h3>
                    </a>
                </div>
                <div class="category-item">
                    <a href="products_cat.php?category=Hostel%20Materials" class="category-link">
                        <img src="hostel_materials.jpg" alt="Hostel Materials">
                        <h3>Hostel Materials</h3>
                    </a>
                </div>
                <div class="category-item">
                    <a href="products_cat.php?category=Stationary" class="category-link">
                        <img src="stationary.jpg" alt="Stationary">
                        <h3>Stationary</h3>
                    </a>
                </div>
            </div>
        </section>

        <!-- New Launches Section -->
        <section class="new-launches">
            <?php
                // Include database connection
                include 'connection.php';

                // Fetch new launches from the database
                $sql = "SELECT id, title, description, price, image FROM products WHERE new_launch = '1'"; // Adjust the column name as needed
                $result = $conn->query($sql);
            ?>
            <h2>New Launches</h2>
            <div class="product-grid">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $productId = htmlspecialchars($row['id']);
                        $productTitle = htmlspecialchars($row['title']);
                        $productImage = htmlspecialchars($row['image']);
                        $productDescription = htmlspecialchars($row['description']);
                        $productPrice = htmlspecialchars($row['price']);

                        // WIHSLIST PART
                        // URL to add the product to the wishlist
                        $wishlistUrl = "add_to_wishlist.php?id=$productId";

                        // Check if the product is already in the wishlist
                        $isInWishlist = false;
                        if (isset($_SESSION['user'])) {
                            $userId = $_SESSION['user'];
                            $checkStmt = mysqli_prepare($conn, "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
                            mysqli_stmt_bind_param($checkStmt, "ii", $userId, $productId);
                            mysqli_stmt_execute($checkStmt);
                            $checkResult = mysqli_stmt_get_result($checkStmt);
                            if (mysqli_num_rows($checkResult) > 0) {
                                $isInWishlist = true;
                            }
                            mysqli_stmt_close($checkStmt);
                        }
                        
                        $wishlistClass = $isInWishlist ? 'filled' : '';


                        echo "<div class='product'>
                        <div class='product-image-container'>
                            <a href='product_details.php?id=$productId' class='product-link'>
                                <img src='uploads/$productImage' alt='$productTitle'>
                                <h3>$productTitle</h3>
                                <p style='color: #666; font-size: 14px;'>$productDescription</p>
                                <p>Rs. $productPrice</p>
                            </a>
                            <a href='$wishlistUrl' class='wishlist-icon $wishlistClass' title='Add to Wishlist'>
    <i class='fas fa-heart'></i>
</a>

                        </div>
                    </div>";
                    }
                } else {
                    echo "<p>No new launches available.</p>";
                }
                $conn->close();
            ?>
            </div>
        </section>


    <!-- Call to Action Section -->
<section class="call-to-action">
    <h2>Contact Us</h2>
    <p>If you have any complaints, feedback, or inquiries, feel free to reach out to us at:</p>
    <p class="contact"><strong>Email:</strong> connectatmarian@gmail.com</p>
    <p>We appreciate your feedback and will get back to you as soon as possible!</p>
</section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Connect at Marian</p>
    </footer>

    <script src="script.js"></script>

    <!-- Add to wishlist script -->
    <script> 
        document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wishlist-icon').forEach(function(icon) {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            var isFilled = icon.classList.contains('filled');
            var url = icon.getAttribute('href');

            console.log('Fetching URL:', url);

            fetch(url, { method: 'GET' })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log('Response:', data); // Log the server response

                    // If there's a response error, log it
                    if (data.includes('Error') || data.includes('error')) {
                        alert('An error occurred: ' + data);
                    } else {
                        // Toggle the wishlist icon fill
                        if (!isFilled) {
                            icon.classList.add('filled');
                        } else {
                            icon.classList.remove('filled');
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('An error occurred: ' + error.message);
                });
                });
            });
        });

  </script>
</body>
</html>
