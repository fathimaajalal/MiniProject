<?php
session_start();
include 'connection.php';

// Assuming the user is logged in
$user_id = $_SESSION['user'] ?? '';

// Get the lost/found item ID from the query string
$item_id = $_GET['id'] ?? '';

// Fetch lost/found item details
$sql = "SELECT * FROM lost_found_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    echo "Lost/Found item not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($item['item_name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .item-details {
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
        .item-details img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            margin-right: 20px;
        }
        .item-info {
            flex: 1;
        }
        .item-info h2 {
            margin: 0;
        }
        .item-info p {
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

        .return-button {
            background-color: #3498db;
        }

        .return-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <section class="item-details">
        <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
        <div class="item-info">
            <h2><?php echo htmlspecialchars($item['item_name']); ?></h2>
            <p><?php echo htmlspecialchars($item['description']); ?></p>
            <p>Location Found: <?php echo htmlspecialchars($item['location']); ?></p>
            <p>Date Found: <?php echo htmlspecialchars($item['date_found']); ?></p>
            <!-- <p>Reported by (Reg No.): <?php echo htmlspecialchars($item['regno']); ?></p> -->
            <p>Contact: <?php echo htmlspecialchars($item['contact']); ?></p>
            
            <div class="button-container">
                <!-- Call the finder using their contact number -->
                <a href="tel:<?php echo htmlspecialchars($item['contact']); ?>" class="call-button">Call</a>
                
                <!-- Option to return the item if found -->
                <!-- <a href="return_item.php?id=<?php echo htmlspecialchars($item_id); ?>" class="return-button">Mark as Returned</a> -->
            </div>
        </div>
    </section>
</body>
</html>

<?php
// Close statements and connections
$stmt->close();
$conn->close();
?>
