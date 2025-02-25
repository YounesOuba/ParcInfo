<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $equipmentId = $_POST['id'];

    try {
        // Delete equipment record from the database
        $deleteQuery = "DELETE FROM equipment WHERE id = :id";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute(['id' => $equipmentId]);

        // Redirect back to the equipment list page after deleting
        header("Location: equipment.php?deleted=success");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting equipment: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.addEventListener('submit', function(event) {
                const confirmation = confirm('Are you sure you want to delete this equipment?');
                if (!confirmation) {
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
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
    
<form id="deleteForm" action="deleteEquipment.php" method="POST" class="mt-4 ml-72 flex space-x-4">
    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">

    <!-- Delete Button -->
    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
        Delete Equipment
    </button>

    <!-- Cancel Button -->
    <a href="equipment.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
        Cancel
    </a>
</form>


<script>
            document.getElementById('userDropdownButton').addEventListener('click', function() {
            document.getElementById('userDropdownMenu').classList.toggle('hidden');
            });


            //charts section
            var pieChartCtx = document.getElementById('pieChart').getContext('2d');
            var barChartCtx = document.getElementById('barChart').getContext('2d');

            // Pie Chart
            new Chart(pieChartCtx, {
                type: 'pie',
                data: {
                    labels: ['Total Equipment', 'Assigned Equipment', 'Under Maintenance'],
                    datasets: [{
                        data: [<?php echo count($totalEquipment);?>, <?php echo count($assignedEquipment)  ?>, <?php echo count($maintenanceEquipment) ?>],
                        backgroundColor: ['#3b82f6', '#10b981', '#f97316'],
                    }]
                },
                options: {
                    responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'start',
                        labels: {
                            boxWidth: 15,  
                        }
                    }
            }
        }
            });

            // Bar Chart
            new Chart(barChartCtx, {
                type: 'bar',
                data: {
                    labels: ['Total Equipment', 'Assigned Equipment', 'Under Maintenance'],
                    datasets: [{
                        label: 'Equipment Status',
                        data: [<?php echo count($totalEquipment);?>, <?php echo count($assignedEquipment)  ?>, <?php echo count($maintenanceEquipment) ?>],
                        backgroundColor: ['#3b82f6', '#10b981', '#f97316'],
                    }]
                },
                options: {
                    responsive: true,
                }
            });


            // new Chart(document.getElementById('lineChart'), {
            //     type: 'line',
            //     data: {
            //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            //         datasets: [{
            //             label: 'Equipment Usage',
            //             data: [10, 20, 15, 25, 30],
            //             borderColor: '#3b82f6',
            //             fill: false,
            //         }]
            //     },
            // });

        //dark mode
        document.getElementById('darkModeToggle').addEventListener('click', function() {
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

            document.querySelectorAll('.shadow-md').forEach(element => {
                element.classList.toggle('dark:shadow-white');
            });

            document.querySelectorAll('input, select, textarea').forEach(element => {
                element.classList.toggle('bg-gray-900');
                element.classList.toggle('text-white');
                element.classList.toggle('border-gray-600');
            });
        });



            // Toggle Sidebar on Mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close Sidebar When Clicking Outside (Optional)
            document.addEventListener('click', (event) => {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

        
        </script>
</body>
</html>
