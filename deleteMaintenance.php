<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['Email'])) {
    header("Location: ./StageFolder/signin.php");
    exit();
}

// Fetch user role from the database
$email = $_SESSION['Email'];
$stmt = $pdo->prepare("SELECT role FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_role = $user['role'];



// Check if the maintenance ID is provided
if (isset($_GET['id'])) {
    $maintenance_id = $_GET['id'];

    // Delete the maintenance record from the database
    $stmt = $pdo->prepare("DELETE FROM maintenance WHERE id = :id");
    $stmt->bindParam(':id', $maintenance_id);
    $stmt->execute();

    echo "Maintenance record deleted successfully!";
    header("Location: maintenance.php");
    exit();
} else {
    echo "No maintenance ID provided.";
    exit();
}
?>