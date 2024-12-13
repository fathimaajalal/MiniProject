<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table']; // Table name (either 'products' or 'advertisements')
    $id = $_POST['id']; // Item ID to be deleted

    if ($table && $id) {
        // Prepare and execute the delete statement
        $stmt = mysqli_prepare($conn, "DELETE FROM $table WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo 'success';
        } else {
            echo 'error';
        }

        mysqli_stmt_close($stmt);
    }
}

$conn->close();
?>
