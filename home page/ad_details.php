<?php
session_start();
include 'connection.php';

// Get the advertisement ID from the query string
$ad_id = $_GET['id'] ?? '';

// Fetch advertisement details
$sql = "SELECT * FROM advertisements WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ad_id);
$stmt->execute();
$result = $stmt->get_result();
$ad = $result->fetch_assoc();

if (!$ad) {
    echo "Advertisement not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($ad['title']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .ad-details {
            display: flex;
            align-items: center;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .ad-details img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            margin-right: 20px;
        }
        .ad-info {
            flex: 1;
        }
        .ad-info h2 {
            margin: 0;
        }
        .ad-info p {
            margin: 5px 0;
            color: #666;
        }
        .contact-buttons {
            margin-top: 20px;
        }
        .contact-buttons a {
            text-decoration: none;
            background-color: #e60000; /* Red button */
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .contact-buttons a:hover {
            background-color: #b30000; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <section class="ad-details">
        <img src="uploads/<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>">
        <div class="ad-info">
            <h2><?php echo htmlspecialchars($ad['title']); ?></h2>
            <p><?php echo htmlspecialchars($ad['description']); ?></p>
            <p class="location">Location: <?php echo htmlspecialchars($ad['location']); ?></p>
            <p class="hosted-by">Hosted By: <?php echo htmlspecialchars($ad['hosted_by']); ?></p>
            <p class="date-posted">Date: <?php echo htmlspecialchars($ad['date_posted']); ?></p>
            
            <div class="contact-buttons">
                <!-- <a href="chat_interface.html">Chat</a> -->
                <a href="tel:<?php echo htmlspecialchars($ad['contact']); ?>">Call</a>
            </div>
        </div>
    </section>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
