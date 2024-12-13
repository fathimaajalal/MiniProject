<?php
include 'connection.php';

$sql = "SELECT id, order_date, customer, seller, total_amount FROM sales_order";
$result = mysqli_query($conn, $sql);

// Check if there are any sales orders
if (mysqli_num_rows($result) > 0) {
    // Output the sales order details in a table with inline CSS
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

    echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Seller</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['order_date'] . "</td>
                <td>" . $row['customer'] . "</td>
                <td>" . $row['seller'] . "</td>
                <td>" . $row['total_amount'] . "</td>
            </tr>";
    }
    echo "</tbody>
        </table>";
} else {
    echo "No sales orders found.";
}

mysqli_close($conn);
?>
