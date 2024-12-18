<?php
session_start();

// Clear the session variable after displaying the success message
unset($_SESSION['submission_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <style>
        body {
                font-family: 'Helvetica Neue', Arial, sans-serif;
                background-color: #f9f9f9;
                color: #333;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                background-color: white;
                padding: 50px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h1 {
                color: #e60000; /* Deep red for the heading */
                font-size: 36px;
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                margin-bottom: 30px;
            }
            a {
                text-decoration: none;
                background-color: #e60000; /* Red background for the button */
                color: white;
                padding: 15px 30px;
                border-radius: 5px;
                font-size: 16px;
                transition: background-color 0.3s ease;
            }
            a:hover {
                background-color: #b30000; /* Darker red on hover */
            }
            .smiley {
                font-size: 60px;
                color: #e60000;
                margin-bottom: 20px;
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="smiley">🥰</div>
        <h1>Thank You!</h1>
        <p>Your product has been successfully submitted for approval.</p>
        <a href="donation_01.php?clear=true">Submit Another Product</a>
    </div>
</body>
</html>
