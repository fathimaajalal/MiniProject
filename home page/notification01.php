<!--<?php
    include "connection.php";
?>-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Example</title>
    <style>
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            display: none;
            animation: fadeInOut 5s ease forwards;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(50px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(50px); }
        }

        .notification-close {
            position: absolute;
            top: 5px;
            right: 5px;
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* "No notifications" placeholder */
        .no-notifications {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #999;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            display: block;
        }
    </style>
</head>
<body>
    <!-- "No notifications" placeholder -->
    <div class="no-notifications" id="no-notifications">No notifications</div>

    <!-- Notification system -->
    <div class="notification" id="notification">
        <span class="notification-close" onclick="closeNotification()">×</span>
        <p id="notification-message">New notification</p>
    </div>

    <script>
        function sendNotification(message) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notification-message');
            const noNotifications = document.getElementById('no-notifications');

            // Hide "No notifications" placeholder
            noNotifications.style.display = 'none';

            // Show notification message
            notificationMessage.textContent = message;
            notification.style.display = 'block';

            // Auto-hide after 5 seconds
            setTimeout(() => {
                notification.style.display = 'none';

                // Show "No notifications" again after the notification disappears
                noNotifications.style.display = 'block';
            }, 5000);
        }

        function closeNotification() {
            const notification = document.getElementById('notification');
            const noNotifications = document.getElementById('no-notifications');

            // Hide notification and show "No notifications" again
            notification.style.display = 'none';
            noNotifications.style.display = 'block';
        }

        // Example usage: Trigger a notification (for demo purposes)
        document.getElementById('send-btn')?.addEventListener('click', function() {
            sendNotification('You sent a message');
        });
    </script>
</body>
</html>

