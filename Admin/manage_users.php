<?php
include 'connection.php';

// Fetch all users from the database
$sql = "SELECT `regno`, `phoneNumber`, `user_type`, `name` FROM `Users` where `user_type`= 'user'";
$result = $conn->query($sql);

// Include the style at the beginning
echo "<style>
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td {
            text-align: center;
        }
        button {
            padding: 5px 10px;
            background-color: #cc3c43; /* Button background color */
            color: white; /* Text color */
            border: none; /* No border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
        }
        button:hover {
            background-color: #a32b30; /* Darker shade on hover */
        }
      </style>";

      echo "<h2 style='text-align: center; text-decoration: underline;'>MANAGE USERS</h2>";
echo '<table>';
echo '<tr><th>Registration Number</th><th>Name</th><th>Phone Number</th><th>Actions</th></tr>';

// Display users
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['regno'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['phoneNumber'] . '</td>';
    // echo '<td>' . $row['user_type'] . '</td>';
    echo '<td>
            <button onclick="removeUser(\'' . $row['regno'] . '\')">Remove</button>
          </td>';
    echo '</tr>';
}

echo '</table>';
$conn->close();
?>

<script>
// Function to remove a user
function removeUser(regno) {
  if (confirm("Are you sure you want to remove this user?")) {
    // Make an AJAX request to delete the user
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "remove_user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (xhr.status === 200) {
        alert("User removed successfully!");
        loadManageUsersPage(); // Reload the users page
      } else {
        alert("Error removing user.");
      }
    };

    xhr.send("regno=" + regno);
  }
}
</script>
