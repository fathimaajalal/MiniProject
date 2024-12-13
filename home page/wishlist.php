<?php
session_start();
include('connection.php'); // Ensure you include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo 'Session not set, redirecting to login page...';
    header("Location: login/login.php");
    exit();
}

$regno = $_SESSION['user']; // Get the logged-in user's registration number

// Fetch user profile data
$stmt = mysqli_prepare($conn, "SELECT name, phoneNumber FROM Users WHERE regno = ?");
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $regno);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result); // Fetch profile data

// Fetch wishlist with additional details including product_id
$wishlist_stmt = mysqli_prepare($conn, "
    SELECT 
        w.product_id, 
        w.product_name, 
        p.image, 
        p.price 
    FROM 
        wishlist w 
    JOIN 
        products p 
    ON 
        w.product_id = p.id 
    WHERE 
        w.user_id = ?
");
if (!$wishlist_stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($wishlist_stmt, "s", $regno);
mysqli_stmt_execute($wishlist_stmt);
$wishlist = mysqli_stmt_get_result($wishlist_stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Wishlist</title>
    <link rel="stylesheet" href="user_dash.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
    <div class="container">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <img src="logo_1.jpg" alt="">
                    <h1>Dashboard</h1>
                </div>
                <ul>
                    <li><a href="home_page.php" class="nav-link" data-target="dashboard">
                        <i class="fas fa-home"></i>
                        <span class="nav-item">Home</span>
                    </a></li>
                    <li><a href="#" class="nav-link" data-target="profile">
                        <i class="fas fa-user"></i>
                        <span class="nav-item">Profile: <?php echo htmlspecialchars($user['name']); ?></span>
                    </a></li>
                    <li><a href="#" class="nav-link" data-target="wishlist">
                        <i class="fas fa-heart"></i>
                        <span class="nav-item">Wishlist</span>
                    </a></li>
                    <li><a href="#">
                        <i class="material-icons">add_shopping_cart</i>
                        <span class="nav-item">My Orders</span>
                    </a></li>
                    <li><a href="#">
                        <i class="material-icons">add_alert</i>
                        <span class="nav-item">Notifications</span>
                    </a></li>
                    <li><a href="login/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-item">Logout</span>
                    </a></li>
                </ul>
            </div>
        </nav>

        <div id="wishlist" class="section">
            <br>
            <h2>Your Wishlist</h2>
            <div class="wishlist-container">
                <?php
                // Display alert if set
                if (isset($_SESSION['alert'])) {
                    echo "
                    <div class='alert'>
                        " . htmlspecialchars($_SESSION['alert']) . "
                        <span class='close'>&times;</span>
                    </div>";
                    unset($_SESSION['alert']); // Clear the alert after displaying
                }

                // Ensure you have a valid result set from your database query
                if (mysqli_num_rows($wishlist) > 0) {
                    while ($wish = mysqli_fetch_assoc($wishlist)) {
                        $productId = htmlspecialchars($wish['product_id']);
                        $productImage = htmlspecialchars($wish['image']);
                        $productName = htmlspecialchars($wish['product_name']);
                        $productPrice = htmlspecialchars($wish['price']);

                        echo "
                        <div class='wishlist-item'>
                            <a href='product_details.php?id=$productId' class='general-link'>
                                <img src='uploads/$productImage' alt='$productName' class='wishlist-product-image'>
                                <h2>$productName</h2>
                            </a>
                            <p class='price'>Rs. $productPrice</p>
                            <a href='remove_from_wishlist.php?id=$productId' class='remove-button'>
                                <i class='fas fa-times'></i>
                            </a>
                        </div>";
                    }
                } else {
                    echo "<p>Your wishlist is empty.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const closeBtn = document.querySelector('.alert .close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    const alertBox = document.querySelector('.alert');
                    if (alertBox) {
                        alertBox.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
