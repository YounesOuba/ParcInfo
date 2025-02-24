<?php
include 'db.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $query = "SELECT o.*, s.name AS supplier_name FROM orders o 
              JOIN suppliers s ON o.supplier_id = s.id 
              WHERE o.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    // جلب عناصر الطلب
    $query_items = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt_items = $conn->prepare($query_items);
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $items_result = $stmt_items->get_result();
} else {
    echo "Invalid Order ID";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="p-6 bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold">Order Details</h2>
        <p><strong>Supplier:</strong> <?= $order['supplier_name'] ?></p>
        <p><strong>Order Date:</strong> <?= $order['order_date'] ?></p>
        <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
        <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
        
        <h3 class="text-xl font-semibold mt-4">Items</h3>
        <table class="w-full border-collapse mt-2">
            <thead>
                <tr class="bg-blue-700 text-white">
                    <th class="p-2 border">Item</th>
                    <th class="p-2 border">Quantity</th>
                    <th class="p-2 border">Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items_result->fetch_assoc()): ?>
                <tr class="hover:bg-gray-100">
                    <td class="p-2 border"><?= $item['equipment_name'] ?></td>
                    <td class="p-2 border"><?= $item['quantity'] ?></td>
                    <td class="p-2 border">$<?= number_format($item['unit_price'], 2) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
