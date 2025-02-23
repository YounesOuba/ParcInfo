<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $equipmentId = $_POST['id'];

    try {
        // Delete equipment record from the database
        $deleteQuery = "DELETE FROM equipment WHERE id = :id";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute(['id' => $equipmentId]);

        // Redirect back to the equipment list page after deleting
        header("Location: equipment.php?deleted=success");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting equipment: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e3915d69f3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.addEventListener('submit', function(event) {
                const confirmation = confirm('Are you sure you want to delete this equipment?');
                if (!confirmation) {
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>

<form id="deleteForm" action="deleteEquipment.php" method="POST" class="mt-4 ml-72 flex space-x-4">
    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">

    <!-- Delete Button -->
    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
        Delete Equipment
    </button>

    <!-- Cancel Button -->
    <a href="equipment.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
        Cancel
    </a>
</form>


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

        
        </script>
</body>
</html>
