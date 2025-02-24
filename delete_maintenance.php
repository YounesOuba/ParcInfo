<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM maintenance WHERE id = $id");
}

header("Location: maintenance.php");
exit();
?>
