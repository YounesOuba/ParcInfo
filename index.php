<?php
session_start();
require 'config.php';

$sql = "SELECT * FROM equipment"; 
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalEquipment = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM equipment WHERE status = 'Assigned'";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();
$assignedEquipment = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM equipment WHERE status = 'Maintenance'";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$maintenanceEquipment = $stmt2->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Parc Informatique - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-50 text-gray-800">

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

        <script>
    // تعريف العدد الافتراضي للإشعارات
    let notificationCount = 5;

    // دالة لتحديث العدد في واجهة المستخدم
    function updateNotificationCount() {
        const countElement = document.getElementById('notification-count');
        countElement.textContent = notificationCount;  // تغيير النص لعدد الإشعارات
    }

    // تنفيذ التحديث عند تحميل الصفحة
    window.onload = updateNotificationCount;

    // هنا يمكن تغييره حسب الحاجة، مثلاً بعد وقت معين أو من خلال API
    setTimeout(function() {
        notificationCount = 10;  // تحديث العدد بعد 3 ثواني
        updateNotificationCount();
    }, 3000);
</script>








        <!-- User Info -->
        <div class="UserInfo flex items-center w-full space-x-3 mt-4 border-2 border-white p-4 rounded-2xl relative">
            <span class="cursor-pointer" id="userDropdownButton"><i class="fa-solid fa-caret-down"></i></span>
            <img src="assets/profile.jpg" alt="User Avatar" class="w-12 h-12 rounded-full cursor-pointer" id="userDropdownButton">
            <div class="UserDetails cursor-pointer">
                <span class="w-full text-sm font-bold">
                    <?php echo htmlspecialchars($Name['Full_Name']); ?>               
                </span>
                <p class="UserText">IT Department</p>
            </div>
            <div class="absolute top-16 left-0 bg-white text-gray-800 p-4 rounded-lg shadow-lg hidden" id="userDropdownMenu">
                <a href="settings.php" class="block px-4 py-2 hover:bg-gray-200 rounded-xl"><i class="fas fa-cogs"></i> Settings</a>
                <a href="logout.php" class="block px-4 py-2 hover:bg-gray-200 rounded-xl"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
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
<a href="logout.php" onclick="return confirmLogout();" class="flex mb-4 items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
    <i class="fas fa-sign-out-alt"></i>
    <span>Logout</span>
</a>

<script>
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
}
</script>


<script>
    // Page elements
    const logoutBtn = document.getElementById("logoutBtn");
    const logoutModal = document.getElementById("logoutModal");
    const keepPassword = document.getElementById("keepPassword");
    const removePassword = document.getElementById("removePassword");
    const cancelLogout = document.getElementById("cancelLogout");

    // When clicking the logout button
    logoutBtn.addEventListener("click", (event) => {
        event.preventDefault(); // Prevent the page from redirecting
        logoutModal.classList.remove("hidden"); // Show the modal
    });

    // Keep the password
    keepPassword.addEventListener("click", () => {
        sessionStorage.removeItem("user"); // Only remove the session
        logoutModal.classList.add("hidden"); // Hide the modal
        alert("You have logged out, but your password is kept!"); 
        location.reload(); // Reload the page without redirecting
    });

    // Remove password and log out
    removePassword.addEventListener("click", () => {
        localStorage.removeItem("password"); // Remove password from local storage
        sessionStorage.removeItem("user"); // Remove session data
        logoutModal.classList.add("hidden"); // Hide the modal
        alert("You have logged out without keeping the password!");
        location.reload(); // Reload the page without redirecting
    });

    // Cancel logout action
    cancelLogout.addEventListener("click", () => {
        logoutModal.classList.add("hidden"); // Hide the modal
    });
</script>






        </div>
    </div>
</div>

    <!-- Dark Mode -->
    <div class="p-6 fixed top-4 right-4 z-50">
        <button id="darkModeToggle" class="bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600 transition-colors duration-300">
            <i id="darkModeIcon" class="fas fa-moon"></i>
        </button>
    </div>


    

<div class="md:ml-64 p-6 mt-8">
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 pb-10 text-center rounded-lg mb-8">
    <h2 class="text-4xl font-bold">Parc Informatique Dashboard</h2>
</div>    

    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <div class="bg-blue-600 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-desktop text-4xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Total Equipment</h3>
                <p class="text-3xl font-bold mt-2"><?php echo count($totalEquipment); ?></p>
            </div>
        </div>
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-check-circle text-4xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Assigned Equipment</h3>
                <p class="text-3xl font-bold mt-2"><?php echo count($assignedEquipment) ?></p>
            </div>
        </div>
        <div class="bg-orange-600 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-tools text-4xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Under Maintenance</h3>
                <p class="text-3xl font-bold mt-2"><?php echo count($maintenanceEquipment) ?></p>
            </div>
        </div>
    </div>




    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="addEquipment.php" class="bg-blue-700 text-white text-center p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center">
            <i class="fas fa-plus-circle text-2xl mb-2"></i>
            Add Equipment
        </a>
        <a href="equipment.php" class="bg-blue-800 text-white text-center p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center">
            <i class="fas fa-list text-2xl mb-2"></i>
            View Equipment
        </a>
        <a href="assign.php" class="bg-green-700 text-white text-center p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center">
            <i class="fas fa-user-check text-2xl mb-2"></i>
            Assign Equipment
        </a>
        <a href="maintenance.php" class="bg-green-800 text-white text-center p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center">
            <i class="fas fa-wrench text-2xl mb-2"></i>
            Maintenance
        </a>
    </section>
    <!-- Notifications Panel -->
<div class="p-6 mt-8">
    <h2 class="text-2xl font-extrabold mb-4">Notifications</h2>
    <div class="p-4 rounded-lg shadow-md">
        <ul>
            <li class="flex items-center justify-between py-2 border-b">
                <span>You have 5 new notifications</span>
                <span class="text-sm text-gray-500">Just now</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Maintenance scheduled for 3 devices</span>
                <span class="text-sm text-gray-500">1 hour ago</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>New updates available</span>
                <span class="text-sm text-gray-500">2 hours ago</span>
            </li>
        </ul>
    </div>
</div>

    <!-- Recent Activities Section -->
<div class="p-6 mt-8">
    <h2 class="text-2xl font-extrabold mb-4">Recent Activities</h2>
    <div class="p-4 rounded-lg shadow-md">
        <ul>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Added new desktop to inventory</span>
                <span class="text-sm text-gray-500">10 mins ago</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Assigned laptop to Younes Ouba</span>
                <span class="text-sm text-gray-500">1 hour ago</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Scheduled maintenance for printer</span>
                <span class="text-sm text-gray-500">3 hours ago</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Updated software on server</span>
                <span class="text-sm text-gray-500">1 day ago</span>
            </li>
        </ul>
    </div>
<!-- Equipment Status Section -->
<div class="w-full mx-auto">
    <h2 class="text-2xl font-extrabold mt-8 mb-6">Equipment Status</h2>

    <!-- Charts Container -->
    <div class="flex w-full flex-auto flex-wrap justify-center items-center gap-8">
        <!-- Pie Chart -->
        <div class="w-2/5 h-64 p-4 shadow-md rounded-lg">
            <canvas id="pieChart"></canvas>
        </div>

        <!-- Bar Chart -->
        <div class="w-2/5 h-64 p-4 shadow-md rounded-lg">
            <canvas id="barChart"></canvas>
        </div>
    </div>
    <!-- <canvas id="lineChart" class="w-2xl mt-10 shadow-md shadow-gray-500"></canvas> -->
</div>
</div>

</div>



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







            document.getElementById('searchInput').addEventListener('input', function() {
                var searchQuery = this.value.toLowerCase();
                var items = document.querySelectorAll('.equipment-item'); // تأكد أن كل عنصر معدات عندو هاد الكلاس

                items.forEach(function(item) {
                    var itemText = item.textContent.toLowerCase();
                    if (itemText.includes(searchQuery)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });


        
    </script>
</body>
</html>
