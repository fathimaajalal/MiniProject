<?php
include 'connection.php'; // Include the database connection file

// Check if the search query is set
if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($conn, $_POST['query']);
    
    // SQL queries to search across different tables
    $sql_products = "SELECT id AS id, title AS name, 'Products' AS category 
                     FROM products WHERE product_name LIKE '%$query%' OR description LIKE '%$query%'";

    $sql_donations = "SELECT id, product_name AS name, 'Donations' AS category 
                      FROM donations WHERE product_name LIKE '%$query%' OR description LIKE '%$query%'";

    $sql_orders = "SELECT order_id AS id, product_id AS name, 'Orders' AS category 
                   FROM orders WHERE product_id LIKE '%$query%' OR buyer LIKE '%$query%' OR seller LIKE '%$query%'";

    // Combine all results
    $results = [];
    
    // Execute product search query
    $result_products = mysqli_query($conn, $sql_products);
    if (mysqli_num_rows($result_products) > 0) {
        while ($row = mysqli_fetch_assoc($result_products)) {
            $results[] = $row;
        }
    }

    // Execute donation search query
    $result_donations = mysqli_query($conn, $sql_donations);
    if (mysqli_num_rows($result_donations) > 0) {
        while ($row = mysqli_fetch_assoc($result_donations)) {
            $results[] = $row;
        }
    }

    // Execute order search query
    $result_orders = mysqli_query($conn, $sql_orders);
    if (mysqli_num_rows($result_orders) > 0) {
        while ($row = mysqli_fetch_assoc($result_orders)) {
            $results[] = $row;
        }
    }

    // Display search results
    if (!empty($results)) {
        echo "<table style='width: 100%; margin: 20px auto; border-collapse: collapse; text-align: left;'>
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                  </tr>
                </thead>
                <tbody>";

        foreach ($results as $result) {
            echo "<tr>
                    <td>{$result['id']}</td>
                    <td>{$result['name']}</td>
                    <td>{$result['category']}</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No results found for '<strong>$query</strong>'</p>";
    }
} else {
    echo "No search query provided.";
}

mysqli_close($conn);
?>
    