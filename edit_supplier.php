<?php
include('db.php');

// جلب ID المورد من الرابط
$id = $_GET['id'];

// استعلام لجلب بيانات المورد
$sql = "SELECT * FROM suppliers WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // إذا كانت الطلبية POST، سيتم تحديث البيانات
    $name = $_POST['name'];
    $contact_person = $_POST['contact_person'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // استعلام التحديث
    $update_sql = "UPDATE suppliers SET name='$name', contact_person='$contact_person', phone='$phone', email='$email' WHERE id=$id";
    if ($conn->query($update_sql) === TRUE) {
        // إعادة التوجيه إلى صفحة الموردين بعد التحديث
        header("Location: suppliers.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
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
    <div class="bg-white p-8 rounded-lg shadow-lg ml-64 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Supplier</h2>
        <form method="POST" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Name:</label>
                <input type="text" id="name" name="name" value="<?= $row['name'] ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="contact_person" class="block text-gray-700 font-medium mb-1">Contact Person:</label>
                <input type="text" id="contact_person" name="contact_person" value="<?= $row['contact_person'] ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="phone" class="block text-gray-700 font-medium mb-1">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?= $row['phone'] ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email:</label>
                <input type="email" id="email" name="email" value="<?= $row['email'] ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium hover:bg-blue-700 transition">Update Supplier</button>
        </form>
    </div>
</body>
</html>