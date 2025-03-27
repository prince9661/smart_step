<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "smart_step_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Total Sales Data
$salesResult = $conn->query("SELECT SUM(quantity_sold) AS total_shoes, SUM(revenue) AS total_revenue FROM sales");

// Fetch Production Data
$productionResult = $conn->query("SELECT SUM(quantity_produced) AS total_produced FROM production");

// Fetch Efficiency Metrics
$efficiencyResult = $conn->query("SELECT AVG(production_time) AS avg_time, COUNT(*) AS total_orders, 
                                  SUM(CASE WHEN completion_status='On Time' THEN 1 ELSE 0 END) AS on_time_orders
                                  FROM production");

// Fetch Inventory Usage
$inventoryResult = $conn->query("SELECT SUM(quantity_used) AS total_used, AVG(wastage_percentage) AS avg_wastage FROM inventory_usage");

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Reports & Analytics</h1>
            <ul class="flex space-x-6">
                <li><a href="admin-dashboard.php" class="hover:underline">Dashboard</a></li>
                <li><a href="manage-orders.php" class="hover:underline">Orders</a></li>
                <li><a href="manage-inventory.php" class="hover:underline">Inventory</a></li>
                <li><a href="production.php" class="hover:underline">Production Schedule</a></li>
                <li><a href="logout.php" class="hover:underline">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Reports Overview -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-center mb-6">📊 Gain Insights & Optimize Production</h2>
        <p class="text-gray-600 text-center">Monitor sales, track production efficiency, and forecast demand.</p>

        <!-- Sales & Production Reports -->
        <div class="grid grid-cols-2 gap-6 mt-6">
            <div class="bg-gray-200 p-4 rounded-lg">
                <h3 class="text-xl font-bold">Total Sales</h3>
                <p class="text-2xl">
                    <?php 
                    $sales = $salesResult->fetch_assoc();
                    echo number_format($sales['total_shoes']) . " Pairs Sold";
                    ?>
                </p>
                <p class="text-lg text-gray-600">Revenue: ₹<?php echo number_format($sales['total_revenue'], 2); ?></p>
            </div>

            <div class="bg-gray-200 p-4 rounded-lg">
                <h3 class="text-xl font-bold">Total Production</h3>
                <p class="text-2xl">
                    <?php 
                    $production = $productionResult->fetch_assoc();
                    echo number_format($production['total_produced']) . " Pairs Produced";
                    ?>
                </p>
            </div>

            <div class="bg-gray-200 p-4 rounded-lg">
                <h3 class="text-xl font-bold">Production Efficiency</h3>
                <?php 
                $efficiency = $efficiencyResult->fetch_assoc();
                $efficiencyScore = ($efficiency['on_time_orders'] / $efficiency['total_orders']) * 100;
                ?>
                <p class="text-2xl"><?php echo round($efficiencyScore, 2); ?>% On-Time Completion</p>
                <p class="text-lg text-gray-600">Avg. Production Time: <?php echo round($efficiency['avg_time'], 2); ?> hrs</p>
            </div>

            <div class="bg-gray-200 p-4 rounded-lg">
                <h3 class="text-xl font-bold">Inventory Utilization</h3>
                <?php 
                $inventory = $inventoryResult->fetch_assoc();
                ?>
                <p class="text-2xl"><?php echo number_format($inventory['total_used']); ?> Materials Used</p>
                <p class="text-lg text-gray-600">Avg. Wastage: <?php echo round($inventory['avg_wastage'], 2); ?>%</p>
            </div>
        </div>

        <!-- Graph Section -->
        <div class="mt-10">
            <h3 class="text-2xl font-bold text-center mb-4">Production Efficiency Chart</h3>
            <canvas id="productionChart"></canvas>
        </div>
    </section>

    <script>
        // Production Efficiency Chart
        var ctx = document.getElementById("productionChart").getContext("2d");
        var chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Cutting", "Assembling", "Finishing"],
                datasets: [{
                    label: "Time Taken (hrs)",
                    data: [5, 7, 3], // Sample data (replace with real data dynamically)
                    backgroundColor: ["blue", "green", "red"]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>&copy; 2025 Smart Step. All rights reserved.</p>
    </footer>
</body>
</html>
