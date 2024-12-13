<?php
session_start();
include 'connection.php';

// Assuming the user is logged in
$user_id = $_SESSION['user'] ?? '';

// Get the donation ID from the query string
$donation_id = $_GET['id'] ?? '';

// Fetch donation details
$sql = "SELECT * FROM donations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donation_id);
$stmt->execute();
$result = $stmt->get_result();
$donation = $result->fetch_assoc();

if (!$donation) {
    echo "Donation not found.";
    exit;
}

// Check if the donation is already in the wishlist
$wishlist_check_sql = "SELECT * FROM wishlist WHERE user_id = ? AND donation_id = ?";
$wishlist_check_stmt = $conn->prepare($wishlist_check_sql);
$wishlist_check_stmt->bind_param("si", $user_id, $donation_id);
$wishlist_check_stmt->execute();
$wishlist_result = $wishlist_check_stmt->get_result();
$is_in_wishlist = $wishlist_result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($donation['product_name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .donation-details {
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
        .donation-details img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            margin-right: 20px;
        }
        .donation-info {
            flex: 1;
        }
        .donation-info h2 {
            margin: 0;
        }
        .donation-info p {
            margin: 5px 0;
            color: #666;
        }
        .button-container {
            display: flex;
            justify-content: space-between; /* Distribute buttons evenly */
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
            flex: 1; /* Ensures buttons take up equal space */
            margin: 0 10px; /* Add space between the buttons */
        }

        .button-container a:hover {
            background-color: #b30000; /* Darker red on hover */
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
    <section class="donation-details">
        <img src="uploads/<?php echo htmlspecialchars($donation['image_url']); ?>" alt="<?php echo htmlspecialchars($donation['product_name']); ?>">
        <div class="donation-info">
            <h2><?php echo htmlspecialchars($donation['product_name']); ?></h2>
            <p><?php echo htmlspecialchars($donation['description']); ?></p>
            <p>Donor: <?php echo htmlspecialchars($donation['donor']); ?></p>
            <p>Location: <?php echo htmlspecialchars($donation['location']); ?></p>
            <p>Contact: <?php echo htmlspecialchars($donation['contact']); ?></p>
            
            <div class="button-container">
                <!-- <a href="chat_interface.html">Chat</a> -->
                <a href="tel:<?php echo htmlspecialchars($donation['contact']); ?>" class="call-button">Call</a>
                
                
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
