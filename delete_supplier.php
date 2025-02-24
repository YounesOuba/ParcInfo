<?php
include('db.php');

// جلب ID المورد من الرابط
$id = $_GET['id'];

// استعلام الحذف
$sql = "DELETE FROM suppliers WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    // إعادة التوجيه إلى صفحة الموردين بعد الحذف
    header("Location: suppliers.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
