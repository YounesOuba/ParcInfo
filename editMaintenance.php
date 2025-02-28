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


// Fetch the maintenance record based on the ID
if (isset($_GET['id'])) {
    $maintenance_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM maintenance WHERE id = :id");
    $stmt->bindParam(':id', $maintenance_id);
    $stmt->execute();
    $maintenance_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$maintenance_record) {
        echo "Maintenance record not found.";
        exit();
    }
} else {
    echo "No maintenance ID provided.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    $issue_description = $_POST['issue_description'];

    // Update the maintenance record in the database
    $stmt = $pdo->prepare("UPDATE maintenance SET status = :status, issue_description = :issue_description WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':issue_description', $issue_description);
    $stmt->bindParam(':id', $maintenance_id);
    $stmt->execute();

    echo "Maintenance record updated successfully!";
    header("Location: maintenance.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Maintenance Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex justify-center items-center">

    <!-- Sidebar Toggle Button (Visible on Mobile) -->
    <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 bg-blue-950 text-white p-2 px-4 rounded-lg">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="md:flex hidden w-64 bg-blue-900 rounded-r-md scroll-m-10 text-white p-6 fixed top-0 left-0 h-full shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto custom-scrollbar">
        <div class="space-y-6 w-full">
            <!-- Logo -->
            <div class="logo w-full border-b-2 -mt-10 mx-auto sticky -top-6 bg-blue-900 z-10 ">
                <img src="assets/logo.png" alt="" class="w-48 -mb-4 mx-auto">
            </div>

            <!-- Search Bar and Notifications -->
            <div class="flex justify-between items-center">
                <input type="text" placeholder="Search..." class="w-3/4 p-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Search">
                <button class="relative text-xl" aria-label="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 -mt-2 -mr-1 right-0 bg-red-500 text-white text-xs px-1 rounded-full">5</span>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4 mt-6">
                <a href="index.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="equipment.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-cogs"></i>
                    <span>Equipment</span>
                </a>
                <a href="addUser.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-user-plus"></i>
                    <span>Users</span>
                </a>
                
                <a href="assign.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Assign</span>
                </a>
                <a href="maintenance.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-wrench"></i>
                    <span>Maintenance</span>
                </a>
                <a href="suppliers.php" class="block py-2 px-4 hover:bg-blue-700">
                    <i class="fas fa-users"></i>
                    <span>Suppliers</span>
                </a>
                    <a href="orders.php" class="block py-2 px-4 hover:bg-blue-700">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                    <a href="logs.php" class="block py-2 px-4 hover:bg-blue-700">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Logs</span>
                    </a>
            </div>

            <!-- Settings and Logout -->
            <div class="mt-8 space-y-4">
                <a href="settings.html" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-cogs"></i>
                    <span>Settings</span>
                </a>

                <!-- Logout button -->
                <a href="#" id="logoutBtn" class="flex mb-4 items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>

                <!-- Confirmation Modal -->
                <div id="logoutModal" class="hidden absolute bg-gray-900 bg-opacity-50 flex justify-center items-center p-2 rounded-lg mt-1 left-1/2 transform -translate-x-1/2">
                    <div class="bg-white p-2 rounded-lg shadow-lg text-center max-w-xs w-full">
                        <h2 class="text-xs font-semibold  text-black">Do you want to log out?</h2>
                        <p class="text-gray-600 my-1 text-xs">Do you want to keep your password for faster login?</p>
                        
                        <div class="flex justify-center gap-2 mt-2">
                            <button id="keepPassword" class="bg-green-500 text-white px-2 py-1 rounded-lg text-xs">Keep Password</button>
                            <button id="removePassword" class="bg-yellow-500 text-white px-2 py-1 rounded-lg text-xs">Don't Keep</button>
                            <button id="cancelLogout" class="bg-gray-400 text-white px-2 py-1 rounded-lg text-xs">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dark Mode -->
    <div class="p-6 fixed top-4 mt-6 right-4 z-50">
        <button id="darkModeToggle" class="bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600 transition-colors duration-300">
            <i id="darkModeIcon" class="fas fa-moon"></i>
        </button>
    </div>

<!-- main content  -->
    <div class="p-8 rounded-lg ml-64 shadow-md shadow-gray-500 mx-auto w-full">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-700">Edit Maintenance Record</h2>
        </div>

        <!-- Form: Edit Maintenance Record -->
        <form action="editMaintenance.php?id=<?= htmlspecialchars($maintenance_id) ?>" method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Issue Description</label>
                <textarea name="issue_description" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required><?= htmlspecialchars($maintenance_record['issue_description']) ?></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <select name="status" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="pending" <?= $maintenance_record['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_progress" <?= $maintenance_record['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= $maintenance_record['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium hover:bg-blue-700 transition">
                Update Maintenance
            </button>
        </form>
    </div>

    <script>
        // Ensure the DOM is fully loaded before running the script
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle Sidebar on Mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close Sidebar When Clicking Outside
            document.addEventListener('click', (event) => {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggleButton = sidebarToggle.contains(event.target);

                if (!isClickInsideSidebar && !isClickOnToggleButton) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Dark Mode Toggle
            document.getElementById('darkModeToggle').addEventListener('click', function () {
                document.body.classList.toggle('bg-gray-800');
                document.body.classList.toggle('text-gray-50');

                // Toggle icon
                var icon = document.getElementById('darkModeIcon');
                if (icon.classList.contains('fa-moon')) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }

                document.querySelectorAll('.bg-white').forEach(element => {
                    element.classList.toggle('dark:bg-gray-800');
                    element.classList.toggle('dark:text-gray-200');
                });

                document.querySelectorAll('.shadow-gray-500').forEach(element => {
                    element.classList.toggle('dark:shadow-white');
                });

                document.querySelectorAll('.text-blue-950').forEach(element => {
                    element.classList.toggle('dark:text-blue-50');
                });

                document.querySelectorAll('.text-gray-700').forEach(element => {
                    element.classList.toggle('dark:text-gray-300');
                });

                document.querySelectorAll('.border').forEach(element => {
                    element.classList.toggle('dark:border-gray-600');
                });

                document.querySelectorAll('input, select, textarea').forEach(element => {
                    element.classList.toggle('bg-gray-900');
                    element.classList.toggle('text-white');
                    element.classList.toggle('border-gray-600');
                });
            });
        });
    </script>
</body>
</html>