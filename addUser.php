<?php
session_start();
require 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect to a different page or show an error message
    echo("You do not have permission to add users.");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

    $sql1 = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindParam(':name', $name);
    $stmt1->bindParam(':email', $email);
    $stmt1->bindParam(':password', $password);
    $stmt1->bindParam(':role', $role);

    $sql2 = "INSERT INTO informations (Full_Name, Email, Password, role) VALUES (:name, :email, :password, :role)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':name', $name);
    $stmt2->bindParam(':email', $email);
    $stmt2->bindParam(':password', $password);
    $stmt2->bindParam(':role', $role);

    // Execute both statements
    if ($stmt1->execute() && $stmt2->execute()) {
        $message = "User added successfully!";
    } else {
        $message = "Error adding user!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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
    <div class="ml-48 p-12 mb-32 mt-16 w-full flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md shadow-gray-500 w-full max-w-3xl">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Add User</h2>
            <?php if (isset($message)) echo "<p class='text-center text-green-600'>$message</p>"; ?>
            <form id="addUserForm" action="addUser.php" method="POST" class="space-y-5 w-2xl mx-auto">
                <!-- Full Name -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" name="name" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" name="password" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Role</label>
                    <select name="role" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="technician">Technician</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition duration-300 font-bold">
                    Add User
                </button>

                <a href="user.php" class="w-full mt-10 bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 transition duration-300 font-bold text-center block">
                    View Users
                </a>
            </form>
        </div>
    </div>

    <script>
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

        // Toggle user dropdown menu
        document.getElementById('userDropdownButton').addEventListener('click', function() {
            document.getElementById('userDropdownMenu').classList.toggle('hidden');
        });

        // Dark Mode Toggle
        document.getElementById('darkModeToggle').addEventListener('click', function() {
            document.body.classList.toggle('bg-gray-800');
            document.body.classList.toggle('text-gray-200');
            document.body.classList.toggle('bg-gray-50');
            document.body.classList.toggle('text-gray-800');

            var icon = document.getElementById('darkModeIcon');
            if (icon.classList.contains('fa-moon')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }

            // Toggle dark mode classes for other elements
            document.querySelectorAll('.bg-white').forEach(element => {
                element.classList.toggle('dark:bg-gray-800');
                element.classList.toggle('dark:text-gray-200');
            });
            document.querySelectorAll('.text-gray-700').forEach(element => {
                element.classList.toggle('dark:text-gray-300');
            });
            document.querySelectorAll('.border').forEach(element => {
                element.classList.toggle('dark:border-gray-600');
            });
            document.querySelectorAll('.focus:ring-blue-600').forEach(element => {
                element.classList.toggle('dark:focus:ring-blue-600');
            });
        });
    </script>
</body>
</html>