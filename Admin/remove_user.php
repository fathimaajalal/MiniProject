<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['regno'])) {
        $regno = $_POST['regno'];

        // Begin transaction to ensure atomicity
        $conn->begin_transaction();

        try {
            // Delete from referencing table(s) first
            $sql_delete_orders = "DELETE FROM purchase_orders WHERE regno = ?";
            $stmt1 = $conn->prepare($sql_delete_orders);
            $stmt1->bind_param("s", $regno);

            if (!$stmt1->execute()) {
                throw new Exception("Error deleting records from purchase_orders: " . $stmt1->error);
            }

            // Delete from the Users table
            $sql_delete_user = "DELETE FROM Users WHERE regno = ?";
            $stmt2 = $conn->prepare($sql_delete_user);
            $stmt2->bind_param("s", $regno);

            if (!$stmt2->execute()) {
                throw new Exception("Error deleting user: " . $stmt2->error);
            }

            // Commit the transaction
            $conn->commit();

            echo json_encode(['success' => true, 'message' => 'User removed successfully.']);

        } catch (Exception $e) {
            // Rollback in case of an error
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        // Close statements
        $stmt1->close();
        $stmt2->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing regno parameter.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
