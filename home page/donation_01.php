<?php

    session_start();
    include('connection.php'); // Include your database connection file

    // Check if the user is logged in
    if (!isset($_SESSION['user'])) {
        echo "<script>
                alert('You need to log in to donate products.');
                if (confirm('Would you like to log in now?')) {
                    window.location.href = 'login/login.php';
                } else {
                    window.location.href = 'home_page.php';
                }
            </script>";
        exit();
    }

    // Check if the form should be cleared
    if (isset($_GET['clear'])) {
        unset($_SESSION['submission_success']); // Clear session data if needed
        echo "<script>localStorage.clear();</script>"; // Clear local storage if you're using it
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate a Product</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .donation-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: black; 
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

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        input[type="text"],
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
        }

        button:hover {
            background-color: #b30000; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <div class="donation-container">
        <h1>DONATE A PRODUCT</h1>
        <form action="process_donation.php" method="post" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" 
                   value="<?php echo isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : ''; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>

            <!-- Other form fields remain unchanged -->
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Electronics">Electronics</option>
                <option value="Study Materials">Study Materials</option>
                <option value="Hostel Materials">Hostel Materials</option>
                <option value="Stationary">Stationary</option>
            </select>

            <label for="conditions">Conditions:</label>
            <select id="conditions" name="conditions" required>
                <option value="new">New</option>
                <option value="used">Used</option>
            </select>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="contact">Contact Information:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <p>
                <input type="checkbox" id="agree-terms"> I have read and agree to the <a href="terms_conditions.html?redirect=donation_01.php"><span> terms and conditions. </span></a>
            </p>
            <button type="button" onclick="checkTermsAndProceed()">Submit Donation</button>
        </form>
    </div>

    <script>
        function checkTermsAndProceed() {
            const agreeTerms = document.getElementById('agree-terms').checked;
            if (!agreeTerms) {
                alert('You must agree to the terms and conditions before proceeding.');
                return;
            }
            document.forms[0].submit(); // Submit the form if terms are accepted
        }
    </script>
</body>
</html>



