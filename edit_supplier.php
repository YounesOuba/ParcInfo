<?php
include('db.php');

// جلب ID المورد من الرابط
$id = $_GET['id'];

// استعلام لجلب بيانات المورد
$sql = "SELECT * FROM suppliers WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // إذا كانت الطلبية POST، سيتم تحديث البيانات
    $name = $_POST['name'];
    $contact_person = $_POST['contact_person'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // استعلام التحديث
    $update_sql = "UPDATE suppliers SET name='$name', contact_person='$contact_person', phone='$phone', email='$email' WHERE id=$id";
    if ($conn->query($update_sql) === TRUE) {
        // إعادة التوجيه إلى صفحة الموردين بعد التحديث
        header("Location: suppliers.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
</head>
<body>
    <h2>Edit Supplier</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $row['name'] ?>" required><br><br>

        <label for="contact_person">Contact Person:</label>
        <input type="text" id="contact_person" name="contact_person" value="<?= $row['contact_person'] ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?= $row['phone'] ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $row['email'] ?>" required><br><br>

        <button type="submit">Update Supplier</button>
    </form>
</body>
</html>
