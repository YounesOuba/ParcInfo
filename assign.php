<?php

require 'config.php';

// Fetch available equipment
$equipmentQuery = "SELECT id, name FROM equipment WHERE status = 'available'";
$equipmentStmt = $pdo->prepare($equipmentQuery);
$equipmentStmt->execute();
$equipmentList = $equipmentStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch users
$userQuery = "SELECT user_id, name FROM users";
$userStmt = $pdo->prepare($userQuery);
$userStmt->execute();
$userList = $userStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment = $_POST["equipment"];
    $user = $_POST["user"];
    $assignment_date = $_POST["assignment_date"];

    error_log("Form submitted with equipment: $equipment, user: $user, assignment_date: $assignment_date");

    if (!empty($equipment) && !empty($user) && !empty($assignment_date)) {
        $pdo->beginTransaction();
        try {
            // Insert assignment record
            $sql = "INSERT INTO assignments (equipment_id, user_id, assigned_date) VALUES (:equipment, :user, :assignment_date)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':equipment', $equipment);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':assignment_date', $assignment_date);
            $stmt->execute();

            // Update equipment status to 'assigned'
            $updateEquipmentStatus = "UPDATE equipment SET status = 'assigned' WHERE id = :equipment";
            $updateStmt = $pdo->prepare($updateEquipmentStatus);
            $updateStmt->bindParam(':equipment', $equipment);
            $updateStmt->execute();

            $pdo->commit();
            $message = "<p class='text-green-600 font-bold text-center'>Equipment assigned successfully!</p>";
            error_log("Equipment assigned successfully!");
        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "<p class='text-red-600 font-bold text-center'>Error: " . $e->getMessage() . "</p>";
            error_log("Error: " . $e->getMessage());
        }
    } else {
        $message = "<p class='text-red-600 font-bold text-center'>All fields are required!</p>";
        error_log("All fields are required!");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Equipment</title>
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
    <div class="p-6 fixed top-4 mt-6 right-4 z-50">
        <button id="darkModeToggle" class="bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600 transition-colors duration-300">
            <i id="darkModeIcon" class="fas fa-moon"></i>
        </button>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-12 mb-32 mt-16 w-full flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md shadow-gray-500 w-full max-w-3xl">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Assign Equipment</h2>
            <?php if (isset($message)) echo $message; ?>
            <form id="assignForm" action="assign.php" method="POST" class="space-y-5 w-2xl mx-auto">
                <!-- Equipment Selection -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Select Equipment</label>
                    <select name="equipment" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Choose Equipment --</option>
                        <?php foreach ($equipmentList as $equipment): ?>
                            <option value="<?= $equipment['id'] ?>"><?= htmlspecialchars($equipment['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- User Selection -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Assign to User</label>
                    <select name="user" class="w-full p-3 border bg-gray-50 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Choose User --</option>
                        <?php foreach ($userList as $user): ?>
                            <option value="<?= $user['user_id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

    <!-- Assignment Date -->
    <div>
        <label class="block text-gray-700 font-medium mb-2">Assignment Date</label>
        <input type="date" name="assignment_date" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition duration-300 font-bold">
        Assign Equipment
    </button>
</form>

        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="hidden fixed inset-0 ml-60 z-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
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

            // Toggle User Dropdown Menu
            // document.getElementById('userDropdownButton').addEventListener('click', function () {
            //     document.getElementById('userDropdownMenu').classList.toggle('hidden');
            // });

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
    </script>


</body>
</html>