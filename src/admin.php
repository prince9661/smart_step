<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "smart_step_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// if (!isset($_SESSION['user'])) {
//     header("Location: login.php");
//     exit();
// }


// Fetch Key Metrics
$totalOrders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
$pendingOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status='Pending'")->fetch_assoc()['count'];
$completedOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status='Completed'")->fetch_assoc()['count'];
$lowStockItems = $conn->query("SELECT COUNT(*) AS count FROM inventory WHERE current_stock < required_stock")->fetch_assoc()['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Admin Dashboard</h1>
            <ul class="flex space-x-6">
                <li><a href="admin-dashboard.php" class="hover:underline">Dashboard</a></li>
                <li><a href="orders.php" class="hover:underline">Orders</a></li>
                <li><a href="inventory.php" class="hover:underline">Inventory</a></li>
                <li><a href="reports.php" class="hover:underline">Reports</a></li>
                <li><a href="logout.php" class="hover:underline">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Overview -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-center mb-6">Welcome, Admin! 🚀</h2>
        <p class="text-gray-600 text-center">Monitor orders, track inventory, and optimize production from one place.</p>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
            <div class="p-6 bg-blue-200 rounded-lg text-center">
                <h3 class="text-2xl font-bold"><?= $totalOrders ?></h3>
                <p class="text-gray-700">Total Orders</p>
            </div>
            <div class="p-6 bg-yellow-200 rounded-lg text-center">
                <h3 class="text-2xl font-bold"><?= $pendingOrders ?></h3>
                <p class="text-gray-700">Pending Orders</p>
            </div>
            <div class="p-6 bg-green-200 rounded-lg text-center">
                <h3 class="text-2xl font-bold"><?= $completedOrders ?></h3>
                <p class="text-gray-700">Completed Orders</p>
            </div>
            <div class="p-6 bg-red-200 rounded-lg text-center">
                <h3 class="text-2xl font-bold"><?= $lowStockItems ?></h3>
                <p class="text-gray-700">Low Stock Alerts</p>
            </div>
        </div>
    </section>

    <!-- Quick Access Links -->
    <section class="container mx-auto my-10 p-6 bg-gray-200 shadow-lg rounded-lg text-center">
        <h3 class="text-2xl font-bold">Quick Access</h3>
        <div class="flex justify-center space-x-6 mt-4">
            <a href="manage_orders.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">Manage Orders</a>
            <a href="manage_inventory.php" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600">Manage Inventory</a>
            <a href="reports.php" class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600">View Reports</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>&copy; 2025 Smart Step. All rights reserved.</p>
    </footer>
</body>
</html>
