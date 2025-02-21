

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

    <div class="md:flex hidden w-64 bg-blue-900 rounded-r-md text-white p-6 fixed top-0 left-0 h-full shadow-lg">
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
                <a href="maintenance.html" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-wrench"></i>
                    <span>Maintenance</span>
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


    

<!-- Main Content Area -->
<div class="md:ml-64 p-6 mt-8">
    <h2 class="text-4xl to-blue-950 font-extrabold mb-16 text-center ">Parc Informatique Dashboard</h2>
    
    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <div class="bg-blue-600 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-desktop text-4xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Total Equipment</h3>
                <p class="text-3xl font-bold mt-2">150</p>
            </div>
        </div>
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-check-circle text-4xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Assigned Equipment</h3>
                <p class="text-3xl font-bold mt-2">85</p>
            </div>
        </div>
        <div class="bg-orange-600 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-tools text-4xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Under Maintenance</h3>
                <p class="text-3xl font-bold mt-2">20</p>
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
        <a href="assign.html" class="bg-green-700 text-white text-center p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center">
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
                        data: [150, 85, 20],
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
                        data: [150, 85, 20],
                        backgroundColor: ['#3b82f6', '#10b981', '#f97316'],
                    }]
                },
                options: {
                    responsive: true,
                }
            });



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



        
        </script>
</body>
</html>
