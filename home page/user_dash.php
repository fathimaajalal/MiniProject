<?php
session_start();
include('connection.php'); // Ensure you include your database connection file

// Debugging: Check if the session is being set correctly
if (!isset($_SESSION['user'])) {
    echo 'Session not set, redirecting to login page...';
    header("Location: login/login.php");
    exit();
}

$regno = $_SESSION['user'];  // Get the logged-in user's registration number

// Fetch user profile data
$stmt = mysqli_prepare($conn, "SELECT name, phoneNumber FROM Users WHERE regno = ?");
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $regno);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);  // Fetch profile data

// Fetch user orders
$order_stmt = mysqli_prepare($conn, "SELECT id, order_date FROM purchase_orders WHERE regno = ?");
if (!$order_stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($order_stmt, "s", $regno);
mysqli_stmt_execute($order_stmt);
$orders = mysqli_stmt_get_result($order_stmt);

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
  <title>User Dashboard</title>
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
            <span class="nav-item">Profile</span>
          </a></li>
          <li><a href="#" class="nav-link" data-target="wishlist">
            <i class="fas fa-heart"></i>
            <span class="nav-item">Wishlist</span>
          </a></li>
          <li><a href="#" class="nav-link" data-target="my_ads">
    <i class="material-icons">add_shopping_cart</i>
    <span class="nav-item">My Ads</span>
</a></li>

          <!-- <li><a href="notification01.php">
            <i class="material-icons">add_alert</i>
            <span class="nav-item">Notifications</span>
          </a></li> -->
          <li><a href="login/logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Logout</span>
          </a></li>
        </ul>
      </div>
    </nav>

    <!-- Display sections -->
    <div id="dashboard" class="section">
        <!-- Background Video -->
        <video autoplay muted loop id="myVideo">
            <source src="user_dash.mp4" type="video/mp4">
        </video>
    </div>

<div id="profile" class="section" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); max-width: 600px; width: 100%;">
        <h2 style="text-align: center;">Profile Information</h2>
        <!-- Profile Image -->
        <img src="Default_pfp.svg.png" alt="Profile Picture" style="width: 150px; border-radius: 50%; display: block; margin: 0 auto;">
        <!-- Profile Details -->
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phoneNumber']); ?></p>
        <p><strong>Register Number:</strong> <?php echo htmlspecialchars($regno); ?></p> <!-- Added regno here -->
        <button onclick="location.href='editprofilepage.php'" style="width: 100%; padding: 15px; background-color: #e60000; color: white; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s ease;">Edit Profile</button>
    </div>
</div>

<div id="wishlist" class="section" style="display: none;">
    <div class="wishlist-container-wrapper">
        <h2>Your Wishlist</h2>
        <div class="wishlist-container">
            <?php
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
                        <a href='remove_from_wishlist.php?id=$productId' class='remove-button' title='Remove from Wishlist'>
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
<div id="my_ads" class="section" style="display: none;">


<div class="ads-container-wrapper">
<h2>Your Advertisements</h2>
<div class="ads-container">

<?php
// Fetch user ads
$ads_stmt = mysqli_prepare($conn, "SELECT id, title, description, image, location FROM advertisements WHERE regno = ?");
mysqli_stmt_bind_param($ads_stmt, "s", $regno);
mysqli_stmt_execute($ads_stmt);
$ads_result = mysqli_stmt_get_result($ads_stmt);

if (mysqli_num_rows($ads_result) > 0) {
    while ($ad = mysqli_fetch_assoc($ads_result)) {
        $adId = htmlspecialchars($ad['id']);
        $adTitle = htmlspecialchars($ad['title']);
        $adDescription = htmlspecialchars($ad['description']);
        $adImage = htmlspecialchars($ad['image']);
        $adLocation = htmlspecialchars($ad['location']);
        
        echo "
        <div class='ad-item' id='ad-$adId'>
            <span class='remove-icon' onclick='removeItem(\"advertisements\", $adId)'>×</span>
            <a href='ad_details.php?id=$adId'>
                <img src='uploads/$adImage' alt='$adTitle'>
                <h3>$adTitle</h3>
                <p>$adLocation</p>
            </a>
        </div>";
    }
} else {
    echo "<p>You have no advertisements.</p>";
}
?>
</div>
</div>

<div class="ads-container-wrapper">
<h2>Your Products</h2>
<div class="ads-container">
    <?php
    // Fetch user products
    $products_stmt = mysqli_prepare($conn, "SELECT id, title, description, image, location, is_sold FROM products WHERE regno = ?");
    mysqli_stmt_bind_param($products_stmt, "s", $regno);
    mysqli_stmt_execute($products_stmt);
    $products_result = mysqli_stmt_get_result($products_stmt);

    if (mysqli_num_rows($products_result) > 0) {
        while ($product = mysqli_fetch_assoc($products_result)) {
            $productId = htmlspecialchars($product['id']);
            $productTitle = htmlspecialchars($product['title']);
            $productImage = htmlspecialchars($product['image']);
            $isSold = $product['is_sold'] == 1; // Check if product is marked as sold

            echo "
            <div class='ad-item' id='product-$productId'>
                <span class='remove-icon' onclick='removeItem(\"products\", $productId)'>×</span>
                <a href='product_details.php?id=$productId'>
                    <img src='uploads/$productImage' alt='$productTitle'>
                    <h3>$productTitle " . ($isSold ? "<span class='sold-label'>Sold</span>" : "") . "</h3>
                </a>";
            
            if (!$isSold) {
                echo "<br>";
                echo "<button class='sold-button' id='sold-button-$productId' onclick='showSoldForm($productId)'>Mark as Sold</button>";
            }

            echo "
                <div id='sold-form-$productId' class='sold-form' style='display: none;'>
                    <form onsubmit='return markAsSold(event, this, $productId)'>
                        <input type='hidden' name='product_id' value='$productId'>
                        <label for='buyer_name'>Buyer Name:</label>
                        <input type='text' name='buyer_name' required> <br>

                        <label for='total_price'>Total Price:</label>
                        <input type='number' name='total_price' required><br> 

                        <label for='date'>Date:</label>
                        <input type='date' name='date' required><br> 
                        <label for='buyer_regno'>Buyer's Reg No:</label>
                        <input type='text' name='buyer_regno' placeholder='fetched automatically' required readonly><br> 
                        <p id='error-message-$productId' style='color:red; display:none;'></p>
                        <button type='submit'>Submit</button>
                        <button type='button' onclick='hideSoldForm($productId)'>Cancel</button>
                    </form>
                </div>
            </div>";
        }
    } else {
        echo "<p>You have no products listed.</p>";
    }
    ?>
</div>
</div>


<div class="ads-container-wrapper">
    <h2>Your Donations</h2>
        <div class="ads-container">

        <?php
        // Fetch user donations
        $donations_stmt = mysqli_prepare($conn, "SELECT id, product_name, description, image_url, location FROM donations WHERE regno = ?");
        mysqli_stmt_bind_param($donations_stmt, "s", $regno);
        mysqli_stmt_execute($donations_stmt);
        $donations_result = mysqli_stmt_get_result($donations_stmt);

        if (mysqli_num_rows($donations_result) > 0) {
            while ($donation = mysqli_fetch_assoc($donations_result)) {
                $donationId = htmlspecialchars($donation['id']);
                $donationName = htmlspecialchars($donation['product_name']);
                $donationDescription = htmlspecialchars($donation['description']);
                $donationImage = htmlspecialchars($donation['image_url']);
                $donationLocation = htmlspecialchars($donation['location']);
                
                echo "
                <div class='ad-item' id='donation-$donationId'>
                <span class='remove-icon' onclick='removeItem(\"donations\", $donationId)'>×</span>
                    <a href='donation_details.php?id=$donationId'>
                        <img src='uploads/$donationImage' alt='$donationName'>
                        <h3>$donationName</h3>
                    </a>
                </div>";
            }
        } else {
            echo "<p>You have no donations.</p>";
        }
        ?>
     </div>
    </div>

</div>


    </div>
  </div>
<script>
function showSoldForm(id) {
    document.getElementById('sold-form-' + id).style.display = 'block';
}

function hideSoldForm(id) {
    document.getElementById('sold-form-' + id).style.display = 'none';
}

function markAsSold(event, form, productId) {
    event.preventDefault(); // Prevent default form submission

    const buyerName = form.buyer_name.value;

    // Fetch the registration number based on the buyer's name
    fetch('fetch_buyer_regno.php?buyer_name=' + encodeURIComponent(buyerName))
        .then(response => response.json())
        .then(data => {
            if (data.regno) {
                form.buyer_regno.value = data.regno; // Set the fetched regno

                // Now submit the form data using fetch
                const formData = new FormData(form);

                fetch('mark_sold.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Update the UI to indicate the product is sold
                        const soldLabel = document.createElement('span');
                        soldLabel.classList.add('sold-label');
                        soldLabel.innerText = 'Sold';

                        // Add the "Sold" label and hide the "Mark as Sold" button
                        const productItem = document.getElementById('product-' + productId);
                        productItem.querySelector('h3').appendChild(soldLabel);
                        const soldButton = document.getElementById('sold-button-' + productId);
                        if (soldButton) soldButton.style.display = 'none';

                        hideSoldForm(productId); // Hide the form after success
                        alert('Product marked as sold successfully!');
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error marking product as sold:', error);
                });
            } else {
                // Invalid buyer name
                const errorMessage = document.getElementById('error-message-' + productId);
                errorMessage.textContent = "Invalid buyer name. Please try again.";
                errorMessage.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error fetching buyer regno:', error);
        });

    return false; // Prevent the form from submitting
}
</script>

<style>
    /* Add this CSS to your stylesheet or in a <style> tag in your HTML */
    .ad-item {
    position: relative;
    padding: 10px;
}

.remove-icon {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 18px;
    color: red;
    cursor: pointer;
}

.remove-icon:hover {
    color: darkred;
}

.sold-button {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: #fff;
    background-color: #e74c3c; /* Red color */
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.sold-button:hover {
    background-color: #c0392b; /* Darker red on hover */
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
}

.sold-button:active {
    background-color: #a93226; /* Even darker red when active (clicked) */
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);
}

.sold-button:focus {
    outline: none; /* Remove default outline */
}

.sold-label {
    background-color: red;
    color: white;
    font-size: 14px;
    margin-left: 10px;
    padding: 3px 5px;
    border-radius: 3px;
}
</style>

  <script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');
    
    // Restore active section from sessionStorage
    const activeSection = sessionStorage.getItem('activeSection') || 'dashboard';
    sections.forEach(section => {
        section.style.display = (section.id === activeSection) ? 'block' : 'none'; // Set display based on active section
    });
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('data-target');
            
            // If the link is for home, don't prevent default
            if (targetId === 'dashboard') {
                window.location.href = 'home_page.php';
                return;
            }
            
            e.preventDefault(); // Prevent default for other links
            
            sections.forEach(section => {
                if (section.id === targetId) {
                    section.style.display = 'block'; // Show the selected section
                    sessionStorage.setItem('activeSection', targetId); // Save the active section
                } else {
                    section.style.display = 'none'; // Hide other sections
                }
            });
        });
    });
});

// Function to remove item
function removeItem(table, id) {
    if (confirm('Are you sure you want to delete this item?')) {
        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_item.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText === 'success') {
                    // Remove the item from the DOM
                    document.getElementById(`${table === 'products' ? 'product' : 'ad'}-${id}`).remove();
                } else {
                    alert('Failed to delete the item. Please try again.');
                }
            }
        };
        xhr.send(`table=${table}&id=${id}`);
    }
}


</script>

</body>
</html>