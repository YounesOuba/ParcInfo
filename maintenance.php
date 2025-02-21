<?php
// معالجة البيانات عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من النموذج
    $equipment_name = $_POST['equipment_name'];
    $maintenance_date = $_POST['maintenance_date'];
    $status = $_POST['status'];

    // هنا يمكنك إضافة كود لحفظ البيانات في قاعدة البيانات (إذا كنت تستخدم قاعدة بيانات)
    echo "تم تسجيل المعدات للصيانة بنجاح!";
}

// هذا مجرد مثال لبيانات المعدات في حالة لم تستخدم قاعدة بيانات
$equipment = [
    ['name' => 'Laptop', 'status' => 'Needs Repair'],
    ['name' => 'Printer', 'status' => 'In Good Condition'],
    ['name' => 'Router', 'status' => 'Needs Repair'],
];
?>
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
<body class="bg-gray-50 text-gray-800 min-h-screen flex justify-center items-center">


    <!-- Sidebar -->
    <div class="md:flex hidden w-64 bg-blue-900 rounded-r-lg text-white p-6 fixed top-0 left-0 h-full shadow-lg">
        <div class="space-y-6 w-full">
            <div class="logo w-full pb-6 border-b-2 mx-auto">
                <h2 class="text-2xl font-extrabold">💻 ParcInfo</h2>
            </div>
            <!-- User Info -->
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

            <!-- Sidebar Menu -->
            <div class="space-y-4 mt-6">
                <a href="index.php" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="view_equipment.html" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-cogs"></i>
                    <span>Equipment</span>
                </a>
                <a href="assign.html" class="flex items-center space-x-2 hover:bg-blue-700 px-4 py-2 rounded-lg">
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

    <!-- Dark Mode Button -->
    <div class="p-6 fixed top-4 mt-6 right-4 z-50">
        <button id="darkModeToggle" class="bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600 transition-colors duration-300">
            <i id="darkModeIcon" class="fas fa-moon"></i>
        </button>
    </div>

    <!-- Main Content -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-auto mt-10">
        <h2 class="text-2xl font-bold text-center mb-4">Maintenance Management</h2>

        <!-- نموذج إضافة صيانة جديدة -->
        <form action="maintenance.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700">Equipment Name</label>
                <input type="text" name="equipment_name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Maintenance Date</label>
                <input type="date" name="maintenance_date" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700">Status</label>
                <select name="status" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="Needs Repair">Needs Repair</option>
                    <option value="In Good Condition">In Good Condition</option>
                    <option value="Repaired">Repaired</option>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Register Maintenance</button>
        </form>

        <!-- قائمة المعدات للصيانة -->
        <h3 class="text-xl font-bold mt-8 mb-4">Equipment Needing Maintenance</h3>
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Equipment</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipment as $item): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= htmlspecialchars($item['name']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($item['status']) ?></td>
                        <td class="border px-4 py-2">
                            <?php if ($item['status'] == 'Needs Repair'): ?>
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Repair</button>
                            <?php elseif ($item['status'] == 'In Good Condition'): ?>
                                <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Good</button>
                            <?php else: ?>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Repaired</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    


    <script>
        // toggle menu
        document.getElementById('userDropdownButton').addEventListener('click', function() {
            document.getElementById('userDropdownMenu').classList.toggle('hidden');
        });

        // Dark Mode Toggle
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
    </script>
</body>
</html>
