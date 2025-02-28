<?php
require 'config.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Start a transaction
    $pdo->beginTransaction();

    try {
        // Delete order items associated with the order
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        // Delete the order
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        echo "Order deleted successfully!";
        header("Location: orders.php");
    } catch (Exception $e) {
        // Rollback the transaction if something failed
        $pdo->rollBack();
        echo "Failed to delete order: " . $e->getMessage();
    }
} else {
    echo "No order ID provided.";
}
?>