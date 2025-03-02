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

if (!isset($_SESSION['Email'])) {
    header("Location: ./StageFolder/signin.php");
    exit();
} else {
    $Email = $_SESSION['Email'];
    $fullName = $pdo->prepare("SELECT Full_Name, Email FROM `informations` WHERE Email = :Email");
    $fullName->bindParam(':Email', $Email);
    $fullName->execute();
    $Name = $fullName->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
        .image-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .zoom-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 10;
            cursor: pointer;
        }
        .image-container:hover .zoom-icon {
            opacity: 1;
        }
        .image-popup {
            display: none;
            position: fixed;
            width: 75%;
            height: auto;
            background-color: rgba(14, 14, 14, 0.8);
            z-index: 1000;
            top: 50%;
            left: 50%;
            margin-left: 150px;
            transform: translate(-50%, -50%);
        }
        .image-popup img {
            display: block;
            margin: 50px auto;
            width: 50%;
            height: auto;
            object-fit: cover;
        }
        .image-popup .closeBtn {
            position: absolute;
            top: 20px;
            right: 20px;
            border: none;
            color: red;
            margin-top: 10px;
            padding: 8px 20px;
            font-size: 30px;
            cursor: pointer;
        }
        .image-popup .closeBtn:hover {
            color: pink;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
   <!-- Sidebar Toggle Button (Visible on Mobile) -->
   <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 bg-blue-950 text-white p-2 px-4 rounded-lg">
    <i class="fas fa-bars"></i>
</button>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar"); // تأكدي أن الـ Sidebar عنده هذا الـ ID

    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("hidden"); // إضافة أو إزالة كلاس 'hidden'
    });
});
</script>

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
            <a href="settings.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                <i class="fas fa-cogs"></i>
                <span>Settings</span>
            </a>


<!-- Logout button -->
<a href="logout.php" id="logoutBtn" class="flex mb-4 items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
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
    <div class="p-6 mb-20 mt-8 ml-64 w-full mx-auto">
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
                    echo "<td class='px-6 py-4'>
                            <div class='image-container'>
                                <img src='{$equipment['equipment_image']}' alt='{$equipment['name']}' class='equipment-image w-16 h-16 object-cover rounded-lg cursor-pointer'>
                                <span class='zoom-icon text-white text-2xl mx-auto'> <i class='fa-solid fa-expand'></i> </span>


                            <!-- // popup img after clicking -->
                            <div class='image-popup'>
                                <img src='{$equipment['equipment_image']}' alt='{$equipment['name']}' class='equipment-image'>
                                <button class='closeBtn'> &times; </button>
                            </div>
                            </div>
                          </td>";
                    echo "<td class='px-6 py-4'>{$equipment['status']}</td>";
                    echo "<td class='px-6 py-4'>" . (!empty($equipment['assigned_user']) ? $equipment['assigned_user'] : 'Not Assigned') . "</td>";
                    echo "<td class=' px-6 py-4 grid text-center mx-auto'>
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

            // Form Submission Handling
            const form = document.getElementById('equipmentForm');
            const loadingSpinner = document.getElementById('loadingSpinner');

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission
                showSpinner();

                // Simulate form submission (replace with actual submission logic)
                setTimeout(() => {
                    hideSpinner();
                    alert('Equipment added successfully!');
                }, 3000); // Simulate a 3-second delay
            });

            function showSpinner() {
                loadingSpinner.classList.remove('hidden');
            }

            function hideSpinner() {
                loadingSpinner.classList.add('hidden');
            }
        });

        // popup img after clicking
        document.querySelectorAll('.image-container').forEach(container => {
            const img = container.querySelector('.equipment-image');
            const zoomIcon = container.querySelector('.zoom-icon');
            const popupImg = container.querySelector('.image-popup');
            const closeBtn = container.querySelector('.closeBtn');


            zoomIcon.addEventListener('click', () => {
                console.log('Image clicked');
                popupImg.style.display = 'block';
            });
            img.addEventListener('click', () => {
                popupImg.style.display = 'block';
            });

            // Close popup when close button is clicked
            closeBtn.addEventListener('click', () => {
                popupImg.style.display = 'none';
            });
        });

        console.log('Script loaded');

    </script>

</body>
</html>