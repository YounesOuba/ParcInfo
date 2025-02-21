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

    <!-- Sidebar -->
    <div class="md:flex hidden w-64 bg-blue-900 rounded-r-lg text-white p-6 fixed top-0 left-0 h-full shadow-lg">
        <div class="space-y-6 w-full">
            <div class="logo w-full border-b-2 -mt-6 mx-auto">
                <img src="assets/logo.png" alt="" class="w-48 -mb-4 mx-auto">
            </div>
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

            <div class="mt-8 space-y-4">
                <a href="settings.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
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
<div class="ml-64 p-12 mb-32 mt-16 w-full flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-md shadow-gray-500 w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Assign Equipment</h2>
        <form action="#" method="POST" class="space-y-5 w-2xl mx-auto">
            
            <!-- Equipment Selection -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Select Equipment</label>
                <select class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choose Equipment --</option>
                    <option value="laptop">Laptop</option>
                    <option value="printer">Printer</option>
                    <option value="monitor">Monitor</option>
                    <option value="keyboard">Keyboard</option>
                    <option value="mouse">Mouse</option>
                    <option value="accesspoint">Access Point</option>
                    <option value="router">Router</option>
                </select>
            </div>
            
            <!-- User Selection -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Assign to User</label>
                <select class="w-full p-3 border bg-gray-50 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choose User --</option>
                    <option value="user1">User 1</option>
                    <option value="user2">User 2</option>
                    <option value="user3">User 3</option>
                    <option value="user4">User 4</option>
                    <option value="user5">User 5</option>
                </select>
            </div>
            
            <!-- Assignment Date -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Assignment Date</label>
                <input type="date" class="w-full bg-gray-50 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition duration-300 font-bold">
                Assign Equipment
            </button>

        </form>
    </div>
</div>


<script>
        //toggle menu
        document.getElementById('userDropdownButton').addEventListener('click', function() {
        document.getElementById('userDropdownMenu').classList.toggle('hidden');
        });



        // Dark Mode    
        let toggledarkmode = document.getElementById('darkModeToggle').addEventListener('click', function() {
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

            document.querySelectorAll('.bg-white').forEach(element => {
                element.classList.toggle('dark:bg-gray-800');
                element.classList.toggle('dark:text-gray-200');
            });

            document.querySelectorAll('.shadow-gray-500').forEach(element => {
                element.classList.toggle('dark:shadow-white');
            });
            document.querySelectorAll('.text-blue-950').forEach(element => {
                element.classList.toggle('dark:text-blue-50')
            })
            document.querySelectorAll('.text-gray-800').forEach(element => {
                element.classList.toggle('dark:text-blue-50')
            })
            // document.querySelectorAll('[id="input"]').forEach(element => {
            //     element.style.backgroundColor = 'rgb(6, 6, 32)';
            // });
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
        console.log(toggledarkmode);
    </script>
</body>
</html>
