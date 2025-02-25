<?php
include 'db.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "طلب غير موجود!";
        exit;
    }
} else {
    echo "معرف الطلب غير موجود!";
    exit;
}

// 3. التعامل مع إرسال البيانات لتحديث الطلب
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب البيانات من النموذج
    $status = $_POST['status'];
    $total_amount = $_POST['total_amount'];

    // تنفيذ استعلام UPDATE
    $update_sql = "UPDATE orders SET status = ?, total_amount = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sdi", $status, $total_amount, $order_id);

    if ($update_stmt->execute()) {
        echo "تم تحديث الطلب بنجاح!";
        header('Location: orders.php'); // إعادة التوجيه إلى صفحة الطلبات بعد التحديث
        exit;
    } else {
        echo "حدث خطأ أثناء تحديث الطلب!";
    }
}

// 4. إغلاق الاتصال
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
</head>
<body>

    <h2>تعديل الطلب</h2>

    <!-- النموذج لتعديل البيانات -->
    <form action="edit_order.php?id=<?php echo $order_id; ?>" method="POST">
        <label for="status">الحالة:</label>
        <select name="status" id="status">
            <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>قيد الانتظار</option>
            <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>تم الشحن</option>
            <option value="received" <?php if ($order['status'] == 'received') echo 'selected'; ?>>تم الاستلام</option>
            <option value="canceled" <?php if ($order['status'] == 'canceled') echo 'selected'; ?>>ملغى</option>
        </select><br><br>

        <label for="total_amount">المبلغ الإجمالي:</label>
        <input type="text" name="total_amount" id="total_amount" value="<?php echo $order['total_amount']; ?>"><br><br>

        <button type="submit">تحديث</button>
    </form>

</body>
</html>
