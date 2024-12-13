<?php
include 'connection.php';

// SQL query to fetch order details
$sql = "SELECT order_id, buyer_regno, seller_regno, product_id, total_price, order_date, proof, buyer, seller FROM orders";
$result = mysqli_query($conn, $sql);

// Check if there are any orders
if (mysqli_num_rows($result) > 0) {
    // Output the order details in a table with inline CSS
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
    echo "<h2 style='text-align: center; text-decoration: underline;'>ORDERS</h2>";

    echo "<table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Buyer</th>
                    <th>Seller</th>
                    <th>Total Price</th>
                    <th>Product ID</th>
                    <th>Proof</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['order_id'] . "</td>
                <td>" . $row['order_date'] . "</td>
                <td>" . $row['buyer'] . "</td>
                <td>" . $row['seller'] . "</td>
                <td>" . $row['total_price'] . "</td>
                <td>" . $row['product_id'] . "</td>
                <td><a href='" . $row['proof'] . "' target='_blank'>View Proof</a></td>
            </tr>";
    }
    echo "</tbody>
        </table>";
} else {
    echo "No orders found.";
}

mysqli_close($conn);
?>
