<?php
include 'connection.php'; // Include your database connection file

// Assuming a button or link to trigger the purchase order listing
// if (isset($_POST['view_purchase_orders'])) {
    // SQL query to fetch purchase order details
    $sql = "SELECT id, order_date, seller, total_amount FROM purchase_orders";
    $result = mysqli_query($conn, $sql);

    // Check if there are any purchase orders
    if (mysqli_num_rows($result) > 0) {

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
 
      </style>";
      
        // Output the purchase order details in a table (you can customize the HTML)
        echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Order Date</th>
                        <th>Seller</th>
                        <th>Total Amount</th>
                    </tr>
                <tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['order_date'] . "</td>
                    <td>" . $row['seller'] . "</td>
                    <td>" . $row['total_amount'] . "</td>
                </tr>";
        }
        echo "</tbody>
            </table>";
    } else {
        echo "No purchase orders found.";
    }

    mysqli_close($conn);
// }
?>