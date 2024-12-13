<?php
session_start();
include('connection.php'); // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>
            alert('You need to log in to sell products.');
            if (confirm('Would you like to log in now?')) {
                window.location.href = 'login/login.php';
            } else {
                window.location.href = 'home_page.php';
            }
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Product</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: black; /* Deep red for the heading */
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }

        h1::after {
            content: '';
            display: block;
            width: 100%;
            height: 3px;
            background-color: #e60000; /* Red underline */
            position: absolute;
            left: 0;
            bottom: -10px;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: none;
        }

        input[type="file"] {
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #e60000; /* Red button */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #b30000; /* Darker red on hover */
        }
    </style>
</head>
<body>
    
    <form id="sellForm" action="process_product.php" method="post" enctype="multipart/form-data">
    <h1>SELL A PRODUCT</h1>
        <label for="title">Product Name:</label>
        <input type="text" id="title" name="title" 
               value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="Electronics" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Electronics') ? 'selected' : ''; ?>>Electronics</option>
            <option value="Study Materials" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Study Materials') ? 'selected' : ''; ?>>Study Materials</option>
            <option value="Hostel Materials" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Hostel Materials') ? 'selected' : ''; ?>>Hostel Materials</option>
            <option value="Stationary" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Stationary') ? 'selected' : ''; ?>>Stationary</option>
        </select>

        <label for="conditions">Conditions:</label>
        <select id="conditions" name="conditions" required>
            <option value="new" <?php echo (isset($_POST['conditions']) && $_POST['conditions'] === 'new') ? 'selected' : ''; ?>>New</option>
            <option value="used" <?php echo (isset($_POST['conditions']) && $_POST['conditions'] === 'used') ? 'selected' : ''; ?>>Used</option>
        </select>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0" 
               value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>

               <label for="location">Location:</label>
                    <input type="text" id="location" name="location" min="0" 
                        value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>" required>
                        
                    <label for="contact">Contact:</label>
                            <input type="number" id="contact" name="contact" min="0" 
                                value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required>
                    
        <label for="image">Upload Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <p>
            <input type="checkbox" id="agree-terms"> I have read and agree to the <a href="terms_conditions.html?redirect=seller_page.php"><span> terms and conditions. </span></a>
        </p>

        <button type="button" onclick="checkTermsAndProceed()">Submit Product</button>
    </form>

    <script>
        function checkTermsAndProceed() {
            const agreeTerms = document.getElementById('agree-terms').checked;
            if (!agreeTerms) {
                alert('You must agree to the terms and conditions before proceeding.');
                return;
            }
            document.getElementById('sellForm').submit(); // Submit the form if terms are accepted
        }
    </script>
</body>
</html>