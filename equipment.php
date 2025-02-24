<?php
require 'config.php';
session_start();

// Fetch logged-in user
$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    $stmt = $pdo->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $fullName = $stmt->fetchColumn();
} else {
    $fullName = "Guest";
}

// Fetch equipment and assigned users
$query = "
    SELECT e.*, u.name AS assigned_user
    FROM equipment e
    LEFT JOIN assignments a ON e.id = a.equipment_id
    LEFT JOIN users u ON a.user_id = u.user_id
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$equipmentData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

<div class="md:flex hidden w-68 bg-blue-900 rounded-r-md text-white p-6 fixed top-0 left-0 h-full shadow-lg">
        <div class="space-y-6 w-full">
        <div class="logo w-full border-b-2 -mt-6 mx-auto">
            <img src="assets/logo.png" alt="" class="w-48 -mb-4 mx-auto">
        </div>
            <div class="flex justify-between items-center">
                <input type="text" placeholder="Search..." class="w-3/4 p-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Search">
                <button class="relative text-xl" aria-label="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded-full">5</span>
                </button>
            </div>

            <div class="UserInfo flex items-center w-full space-x-3 mt-4 border-2 border-white p-4 rounded-2xl relative">
                <span class="cursor-pointer" id="userDropdownButton"><i class="fa-solid fa-caret-down"></i></span>
                <img src="assets/profile.jpg" alt="User Avatar" class="w-12 h-12 rounded-full cursor-pointer" id="userDropdownButton">
                <div class="UserDetails cursor-pointer">
                    <span class="w-full text-sm font-bold">Younes Ouba</span>
                    <p class="UserText">IT Department</p>
                </div>
                <div class="absolute top-16 left-0 bg-white text-gray-800 p-4 rounded-lg shadow-lg hidden" id="userDropdownMenu">
                    <a href="settings.html" class="block px-4 py-2 hover:bg-gray-200 rounded-xl"><i class="fas fa-cogs"></i> Settings</a>
                    <a href="logout.html" class="block px-4 py-2 hover:bg-gray-200 rounded-xl"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <div class="space-y-4 mt-6">
                <a href="index.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="equipment.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-cogs"></i>
                    <span>Equipment</span>
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

            <div class="mt-8 space-y-4">
                <a href="settings.html" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <a href="logout.html" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Dark Mode -->
    <div class="p-6 fixed top-4 mt-6 right-4 z-50">
        <button id="darkModeToggle" class="bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600 transition-colors duration-300">
            <i id="darkModeIcon" class="fas fa-moon"></i>
        </button>
    </div>

    <!-- Main Content -->
    <div class="p-6 mb-20 mt-8 ml-32 w-full mx-auto">
        <div class="w-full text-center">
            <h2 class="text-3xl font-bold text-gray-700 mb-10 mx-auto">Equipment List</h2>
        </div>

        <!-- Search Bar -->
        <input type="text" id="searchInput" placeholder="Search equipment..." class="w-full p-2 border rounded-lg mb-4 focus:ring-2 focus:ring-blue-500">

        <!-- Equipment Table -->
        <table class="w-full border-collapse border border-gray-300 shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-6 py-4">ID</th>
                    <th class="border border-gray-300 px-6 py-4">Name</th>
                    <th class="border border-gray-300 px-6 py-4">Category</th>
                    <th class="border border-gray-300 px-6 py-4">Brand</th>
                    <th class="border border-gray-300 px-6 py-4">Model</th>
                    <th class="border border-gray-300 px-6 py-4">Picture</th>
                    <th class="border border-gray-300 px-6 py-4">Status</th>
                    <th class="border border-gray-300 px-6 py-4">Assigned User</th>
                    <th class="border border-gray-300 px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody id="equipmentTable">
                <?php
                // Loop through the equipment data and display it in the table
                foreach ($equipmentData as $equipment) {
                    echo "<tr class='bg-white border border-gray-300'>";
                    echo "<td class='px-6 py-4'>{$equipment['id']}</td>";
                    echo "<td class='px-6 py-4'>{$equipment['name']}</td>";
                    echo "<td class='px-6 py-4'>{$equipment['category']}</td>";
                    echo "<td class='px-6 py-4'>{$equipment['brand']}</td>";
                    echo "<td class='px-6 py-4'>{$equipment['model']}</td>";
                    echo "<td class='px-6 py-4'><img src='{$equipment['equipment_image']}' alt='{$equipment['name']}' class='w-16 h-16 object-cover rounded-lg'></td>";
                    echo "<td class='px-6 py-4'>{$equipment['status']}</td>";
                    echo "<td class='px-6 py-4'>" . (!empty($equipment['assigned_user']) ? $equipment['assigned_user'] : 'Not Assigned') . "</td>";
                    echo "<td class='px-6 py-4 grid text-center mx-auto'>
                            <a href='editEquipment.php?id={$equipment['id']}' class='text-blue-500 hover:underline mr-4'><i class='fas fa-edit'></i> Edit</a>
                            <a href='deleteEquipment.php?id={$equipment['id']}' class='text-red-500 hover:underline'><i class='fas fa-trash'></i> Delete</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Add New Equipment Button -->
        <div class="mt-4">
            <a href="addEquipment.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                Add New Equipment
            </a>
        </div>
    </div>

    <script>
        // Search Functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#equipmentTable tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
 
        // Toggle menu
        document.getElementById('userDropdownButton').addEventListener('click', function() {
            document.getElementById('userDropdownMenu').classList.toggle('hidden');
        });

        // Dark Mode Toggle
        const darkModeButton = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        darkModeButton.addEventListener('click', () => {
            document.body.classList.toggle('dark');
            darkModeIcon.classList.toggle('fa-moon');
            darkModeIcon.classList.toggle('fa-sun');
        });
    </script>

</body>
</html>