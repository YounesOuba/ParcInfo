
<?php
$servername = "localhost"; // أو اسم السيرفر ديالك
$username = "root"; // اسم المستخدم
$password = ""; // كلمة المرور
$dbname = "stagedb1"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
