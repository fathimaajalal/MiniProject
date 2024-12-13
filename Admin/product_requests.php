<?php
// Include database connection
include 'connection.php';

// SQL query to fetch product requests
$sql = "SELECT id, user, title, description, category, conditions, price, location, contact, image FROM request";
$result = $conn->query($sql);
echo "<h2 style='text-align: center; text-decoration: underline;'>PRODUCT REQUESTS</h2>";
if ($result->num_rows > 0) {
    // Add CSS to style the table
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
            .description-column {
                width: 250px; /* Adjust this value as needed */
                text-align: left;
            }
            img {
                max-width: 100px;
                height: auto;
            }
          </style>";
          
    echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th class='description-column'>Description</th>
                    <th>Category</th>
                    <th>Condition</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Contact</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";
           
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['user']) . "</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td class='description-column'>" . htmlspecialchars($row['description']) . "</td>
                <td>" . htmlspecialchars($row['category']) . "</td>
                <td>" . htmlspecialchars($row['conditions']) . "</td>
                <td>Rs." . htmlspecialchars($row['price']) . "</td>
                <td>" . htmlspecialchars($row['location']) . "</td>
                <td>" . htmlspecialchars($row['contact']) . "</td>
                <td><img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Product Image'></td>
                <td>
                    <a href='approve_product.php?id=" . $row['id'] . "'>Approve</a> | 
                    <a href='reject_product.php?id=" . $row['id'] . "'>Reject</a>
                </td>
            </tr>";
    }
    
    echo "</tbody>
        </table>";
} else {
    echo "<p style='text-align:center;'>No product requests found.</p>";
}

$conn->close();
?>
