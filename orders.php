<?php
require 'config.php'; 

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_id = $_POST['supplier_id'];
    $order_date = $_POST['order_date'];
    $status = $_POST['status'];
    $equipment_ids = $_POST['equipment_id'];
    $quantities = $_POST['quantity'];
    $total_amount = 0;

    // Calculate total amount
    foreach ($equipment_ids as $index => $equipment_id) {
        $stmt = $pdo->prepare("SELECT price FROM equipment WHERE id = :equipment_id");
        $stmt->bindParam(':equipment_id', $equipment_id);
        $stmt->execute();
        $price = $stmt->fetchColumn();
        $total_amount += $price * $quantities[$index];
    }

    // Insert the new order into the database
    $stmt = $pdo->prepare("INSERT INTO orders (supplier_id, order_date, total_amount, status) VALUES (:supplier_id, :order_date, :total_amount, :status)");
    $stmt->bindParam(':supplier_id', $supplier_id);
    $stmt->bindParam(':order_date', $order_date);
    $stmt->bindParam(':total_amount', $total_amount);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    $order_id = $pdo->lastInsertId();

    // Insert order items into the database
    foreach ($equipment_ids as $index => $equipment_id) {
        $quantity = $quantities[$index];
        $stmt = $pdo->prepare("SELECT price, name FROM equipment WHERE id = :equipment_id");
        $stmt->bindParam(':equipment_id', $equipment_id);
        $stmt->execute();
        $equipment = $stmt->fetch(PDO::FETCH_ASSOC);
        $price = $equipment['price'];
        $equipment_name = $equipment['name'];

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, equipment_id, quantity, unit_price, equipment_name) VALUES (:order_id, :equipment_id, :quantity, :unit_price, :equipment_name)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':equipment_id', $equipment_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_price', $price);
        $stmt->bindParam(':equipment_name', $equipment_name);
        $stmt->execute();
    }

    echo "Order added successfully!";
}

// Fetch suppliers data from the database
$stmt = $pdo->prepare("SELECT id, name FROM suppliers");
$stmt->execute();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch equipment data from the database
$stmt = $pdo->prepare("SELECT id, name, price FROM equipment");
$stmt->execute();
$equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders data from the database
$sql = "SELECT orders.id, suppliers.name AS supplier, orders.order_date, orders.total_amount, orders.status 
        FROM orders 
        JOIN suppliers ON orders.supplier_id = suppliers.id
        ORDER BY orders.order_date DESC";
$result = $pdo->query($sql);

// Fetch order items data from the database
$order_items_sql = "SELECT order_items.order_id, order_items.equipment_name, order_items.quantity, order_items.unit_price 
                    FROM order_items 
                    JOIN orders ON order_items.order_id = orders.id";
$order_items_result = $pdo->query($order_items_sql);
$order_items = $order_items_result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
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
    const sidebar = document.getElementById("sidebar");

    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("hidden");
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
        <h2 class="text-4xl font-bold text-center mb-8 text-blue-950">Orders</h2>
        
        <!-- Add Order Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h3 class="text-2xl font-bold mb-4">Add New Order</h3>
            <form action="orders.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Supplier</label>
                    <select name="supplier_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= htmlspecialchars($supplier['id']) ?>"><?= htmlspecialchars($supplier['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Order Date</label>
                    <input type="date" name="order_date" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div id="order-items">
                    <label class="block text-gray-700 font-medium mb-1">Order Items</label>
                    <div class="flex space-x-4 mb-4">
                        <select name="equipment_id[]" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                            <?php foreach ($equipment as $item): ?>
                                <option value="<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['name']) ?> ($<?= htmlspecialchars($item['price']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="quantity[]" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Quantity" required>
                    </div>
                </div>
                <button type="button" id="add-item" class="w-full bg-green-600 text-white p-3 rounded-lg font-medium hover:bg-green-700 transition">Add Another Item</button>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <select name="status" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="received">Received</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium hover:bg-blue-700 transition">Add Order</button>
            </form>
        </div>

        <!-- Orders List -->
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-700 text-white">
                        <th class="p-2 border">Supplier</th>
                        <th class="p-2 border">Order Date</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Total Price</th>
                        <th class="p-2 border">Equipment Name</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 border"><?= htmlspecialchars($row['supplier']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['order_date']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['status']) ?></td>
                        <td class="p-2 border">$<?= htmlspecialchars($row['total_amount']) ?></td>
                        <td class="p-2 border">
                            <?php foreach ($order_items as $item): ?>
                                <?php if ($item['order_id'] == $row['id']): ?>
                                    <?= htmlspecialchars($item['equipment_name']) ?> (<?= htmlspecialchars($item['quantity']) ?> x $<?= htmlspecialchars($item['unit_price']) ?>)<br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td class="p-2 border text-center">
                            <a href="edit_order.php?id=<?= htmlspecialchars($row['id']) ?>" class="text-blue-600 hover:underline ml-2"><i class="fas fa-pen"></i> Edit</a>
                            <a href="delete_order.php?id=<?= htmlspecialchars($row['id']) ?>" class="text-red-600 hover:underline ml-2"><i class="fas fa-trash"></i> Delete</a>
                        </td>
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

            // Add another item
            document.getElementById('add-item').addEventListener('click', function () {
                const orderItems = document.getElementById('order-items');
                const newItem = document.createElement('div');
                newItem.classList.add('flex', 'space-x-4', 'mb-4');
                newItem.innerHTML = `
                    <select name="equipment_id[]" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <?php foreach ($equipment as $item): ?>
                            <option value="<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['name']) ?> ($<?= htmlspecialchars($item['price']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="quantity[]" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Quantity" required>
                `;
                orderItems.appendChild(newItem);
            });
        });
    </script>
</body>
</html>