<?php
// mark_sold.php

session_start();
require 'connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $buyerName = $_POST['buyer_name'];
    $totalPrice = $_POST['total_price'];
    $date = $_POST['date'];
    $buyerRegno = $_POST['buyer_regno'];
    $sellerRegno = $_SESSION['regno']; // Assuming regno is stored in session

    // Update the product as sold
    $updateProductStmt = mysqli_prepare($conn, "UPDATE products SET is_sold = 1 WHERE id = ?");
    mysqli_stmt_bind_param($updateProductStmt, "i", $productId);
    $productUpdateSuccess = mysqli_stmt_execute($updateProductStmt);

    if ($productUpdateSuccess) {
        // Insert into sales_order or any other table
        $insertSaleStmt = mysqli_prepare($conn, "INSERT INTO orders (product_id, buyer_regno, seller_regno, total_price, date) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insertSaleStmt, "issds", $productId, $buyerRegno, $sellerRegno, $totalPrice, $date);
        $saleInsertSuccess = mysqli_stmt_execute($insertSaleStmt);

        if ($saleInsertSuccess) {
            echo json_encode(['success' => true, 'message' => 'Product marked as sold successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error inserting into sales_order table.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating product as sold.']);
    }

    mysqli_stmt_close($updateProductStmt);
    mysqli_stmt_close($insertSaleStmt);
    mysqli_close($conn);
}
?>