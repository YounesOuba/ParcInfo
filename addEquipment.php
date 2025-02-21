<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Sidebar Toggle Button (Visible on Mobile) -->
    <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 bg-blue-950 text-white p-2 px-4 rounded-lg">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="md:flex hidden w-64 bg-blue-900 rounded-r-lg z-10 text-white p-6 fixed top-0 left-0 h-full shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="space-y-6 w-full">
            <!-- Logo -->
            <div class="logo w-full border-b-2 -mt-6 mx-auto">
                <img src="assets/logo.png" alt="" class="w-48 -mb-4 mx-auto">
            </div>

            <!-- Search Bar and Notifications -->
            <div class="flex justify-between items-center">
                <input type="text" placeholder="Search..." class="w-3/4 p-2 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Search">
                <button class="relative text-xl" aria-label="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded-full">3</span>
                </button>
            </div>

            <!-- User Info -->
            <div class="UserInfo flex items-center w-full space-x-3 mt-4 border-2 border-white p-4 rounded-2xl relative">
                <span class="cursor-pointer" id="userDropdownButton"><i class="fa-solid fa-caret-down"></i></span>
                <img src="assets/profile.jpg" alt="User Avatar" class="w-12 h-12 rounded-full cursor-pointer" id="userAvatar">
                <div class="UserDetails cursor-pointer">
                    <span class="w-full text-sm font-bold">Younes Ouba</span>
                    <p class="UserText">IT Department</p>
                </div>
                <div class="absolute top-16 left-0 bg-white text-gray-800 p-4 rounded-lg shadow-lg hidden" id="userDropdownMenu">
                    <a href="settings.html" class="block px-4 py-2 hover:bg-gray-200 rounded-xl"><i class="fas fa-cogs"></i> Settings</a>
                    <a href="logout.html" class="block px-4 py-2 hover:bg-gray-200 rounded-xl"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                <a href="assign.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Assign</span>
                </a>
                <a href="maintenance.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-wrench"></i>
                    <span>Maintenance</span>
                </a>
            </div>

            <!-- Settings and Logout -->
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
    <div class="ml-64 p-6 mb-20 mt-8">
        <h2 class="text-4xl font-bold text-center mb-16 text-blue-950">Add Equipment</h2>
        <div class="bg-white p-6 rounded-lg shadow-md shadow-gray-500">
            <form id="equipmentForm" action="#" method="POST" class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold">Equipment Name</label>
                    <input type="text" name="equipment_name" class="w-full bg-gray-50 p-2 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Category</label>
                    <select name="category" class="w-full bg-gray-50 p-2 border rounded-md focus:ring-2 focus:ring-blue-600">
                        <option>Computers</option>
                        <option>Printers</option>
                        <option>Monitors</option>
                        <option>Speakers</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Serial Number</label>
                    <input type="text" name="serial_number" class="w-full bg-gray-50 p-2 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Purchase Date</label>
                    <input type="date" name="purchase_date" class="w-full bg-gray-50 p-2 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Status</label>
                    <select name="status" class="w-full bg-gray-50 p-2 border rounded-md focus:ring-2 focus:ring-blue-600">
                        <option>Available</option>
                        <option>Assigned</option>
                        <option>Maintenance</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium mb-1">Upload Picture</label>
                    <input type="file" name="equipment_image" accept="image/*" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold">Description</label>
                    <textarea name="description" class="w-full bg-gray-50 p-2 border rounded-md focus:ring-2 focus:ring-blue-600" rows="3"></textarea>
                </div>
                <div class="md:col-span-2 text-center">
                    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-md hover:bg-blue-800 transition">Add Equipment</button>
                </div>
            </form>
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex ml-60 z-0 items-center justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>
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

            // Toggle User Dropdown Menu
            document.getElementById('userDropdownButton').addEventListener('click', function () {
                document.getElementById('userDropdownMenu').classList.toggle('hidden');
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
    </script>
</body>
</html>