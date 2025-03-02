<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];
    $table_name = $_POST['table_name'];
    $record_id = $_POST['record_id'];
    $description = $_POST['description'];

    // Prepare the SQL statement
    $sql = "INSERT INTO logs (user_id, action, table_name, record_id, description, timestamp) 
            VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP())";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("issis", $user_id, $action, $table_name, $record_id, $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Log added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding log: " . $stmt->error . "');</script>";
    }
}

// Fetch logs data from the database
$sql = "SELECT logs.id, informations.Full_Name AS name, logs.action, logs.table_name, logs.record_id, logs.description, logs.timestamp 
        FROM logs 
        JOIN informations ON logs.user_id = informations.id"; 

$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
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
                        <h2 class="text-xs font-semibold text-black">Do you want to log out?</h2>
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

    <!-- Main Content -->
    <div class="ml-0 md:ml-64 p-6">
        <h2 class="text-4xl font-bold text-center mb-8 text-blue-950">System Logs</h2>
        
        <!-- Add Log Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h3 class="text-2xl font-bold mb-4">Add New Log</h3>
            <form action="logs.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">User ID</label>
                    <input type="number" name="user_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Action</label>
                    <input type="text" name="action" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Table Name</label>
                    <input type="text" name="table_name" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Record ID</label>
                    <input type="number" name="record_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium hover:bg-blue-700 transition">Add Log</button>
            </form>
        </div>

        <!-- Logs List -->
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-700 text-white">
                        <th class="p-2 border">User</th>
                        <th class="p-2 border">Action</th>
                        <th class="p-2 border">Table</th>
                        <th class="p-2 border">Record ID</th>
                        <th class="p-2 border">Description</th>
                        <th class="p-2 border">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 border"><?php echo htmlspecialchars($row['name']) ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($row['action']) ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($row['table_name']) ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($row['record_id']) ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($row['description']) ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($row['timestamp']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
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

        // Logout Modal
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutModal = document.getElementById("logoutModal");
        const keepPassword = document.getElementById("keepPassword");
        const removePassword = document.getElementById("removePassword");
        const cancelLogout = document.getElementById("cancelLogout");

        logoutBtn.addEventListener("click", (event) => {
            event.preventDefault();
            logoutModal.classList.remove("hidden");
        });

        keepPassword.addEventListener("click", () => {
            sessionStorage.removeItem("user");
            logoutModal.classList.add("hidden");
            alert("You have logged out, but your password is kept!");
            location.reload();
        });

        removePassword.addEventListener("click", () => {
            localStorage.removeItem("password");
            sessionStorage.removeItem("user");
            logoutModal.classList.add("hidden");
            alert("You have logged out without keeping the password!");
            location.reload();
        });

        cancelLogout.addEventListener("click", () => {
            logoutModal.classList.add("hidden");
        });
    </script>
</body>
</html>