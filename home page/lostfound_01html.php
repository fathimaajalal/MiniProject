<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found</title>
    <link rel="stylesheet" href="lostfound_style.css">
</head>
<body>


    <form id="lostFoundForm" action="upload_lostfound.php" method="POST" enctype="multipart/form-data">
    <h1>Lost and Found</h1>
        <label for="itemName">Item Name:</label>
        <input type="text" id="itemName" name="itemName" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="location">Location Found (or Last found Location):</label>
        <input type="text" id="location" name="location" required><br><br>

        <label for="dateFound">Date Lost/Found:</label>
        <input type="date" id="dateFound" name="dateFound" required><br><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required><br><br>

        <label for="itemImage">Upload Image:</label>
        <input type="file" id="itemImage" name="itemImage" accept="image/*" required><br><br>

        <button type="submit">Upload Item</button>
    </form>

    <h2>Lost and Found Items</h2>
    <div id="lostFoundList">
        <?php
        // Display uploaded items from the database
        $conn = new mysqli("localhost", "root", "", "c_a_m");
        $sql = "SELECT * FROM lost_found_items";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='item'>";
                echo "<h3>" . htmlspecialchars($row['item_name']) . "</h3>";
                echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Location: " . htmlspecialchars($row['location']) . "</p>";
                echo "<p>Date Found: " . htmlspecialchars($row['date_found']) . "</p>";
                echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' width='200'>";
                echo "</div><hr>";
            }
        } else {
            echo "No items found.";
        }
        ?>
    </div>
    <script>
      sendNotification('You have a new message from the seller');
        </script>
</body>
</html>
