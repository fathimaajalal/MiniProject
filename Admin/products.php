<?php
include 'connection.php'; // Include your database connection file

// Assuming you have a button or link to trigger the product listing
// if (isset($_POST['view_products'])) {
    
    // SQL query to fetch product details
    $sql = "SELECT id, title, description, category, conditions, price, location, contact, image FROM products";
    $result = mysqli_query($conn, $sql);

    // Check if there are any products
    if (mysqli_num_rows($result) > 0) {
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
                    width: 500px; /* Adjust this value as needed */
                    text-align: left;
                }
                img {
                    max-width: 100px;
                    height: auto;
                }
              </style>";
        echo "<h2 style='text-align: center; text-decoration: underline;'>PRODUCTS</h2>";
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th class='description-column'>Description</th>
                        <th>Category</th>
                        <th>Condition</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Contact</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>";
        
        // Fetch and display each row of data
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['title'] . "</td>
                    <td class='description-column'>" . $row['description'] . "</td>
                    <td>" . $row['category'] . "</td>
                    <td>" . $row['conditions'] . "</td>
                    <td>" . $row['price'] . "</td>
                    <td>" . $row['location'] . "</td>
                    <td>" . $row['contact'] . "</td>
                    <td><img src='" . $row['image'] . "' alt='Product Image'></td>
                </tr>";
        }
        
        echo "</tbody>
            </table>";
    } else {
        echo "<p style='text-align:center;'>No products found.</p>";
    }

    mysqli_close($conn);
// }
?>
