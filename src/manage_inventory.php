<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "smart_step_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add New Material
if (isset($_POST['add_material'])) {
    $material_name = $_POST['material_name'];
    $unit_type = $_POST['unit_type'];
    $current_stock = $_POST['current_stock'];
    $min_required_stock = $_POST['min_required_stock'];
    $min_required_stock = $_POST['required_stock'];

    $conn->query("INSERT INTO inventory (material_name, unit_type, current_stock, min_required_stock, required_stock) 
                  VALUES ('$material_name', '$unit_type', $current_stock, $min_required_stock, '$required_stock')");

    header("Location: manage_inventory.php");
    exit();
}

// Update Stock
if (isset($_POST['update_stock'])) {
    $id = $_POST['id'];
    $new_stock = $_POST['new_stock'];

    $conn->query("UPDATE inventory SET current_stock = $new_stock WHERE id = $id");

    header("Location: manage_inventory.php");
    exit();
}

// Delete Material
if (isset($_POST['delete_material'])) {
    $id = $_POST['id'];

    $conn->query("DELETE FROM inventory WHERE id = $id");

    header("Location: manage_inventory.php");
    exit();
}

// Fetch Inventory Data
$result = $conn->query("SELECT * FROM inventory");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Manage Inventory</h1>
            <ul class="flex space-x-6">
                <li><a href="admin-dashboard.php" class="hover:underline">Dashboard</a></li>
                <li><a href="manage-orders.php" class="hover:underline">Orders</a></li>
                <li><a href="production.php" class="hover:underline">Production Schedule</a></li>
                <li><a href="reports.php" class="hover:underline">Reports</a></li>
                <li><a href="logout.php" class="hover:underline">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Inventory Overview -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-center mb-6">Manage Raw Materials & Stock Levels 🏭</h2>
        <p class="text-gray-600 text-center">Track materials, update stock, and automate restocking.</p>

        <!-- Inventory Table -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3">Material Name</th>
                        <th class="border p-3">Unit Type</th>
                        <th class="border p-3">Current Stock</th>
                        <th class="border p-3">Minimum Required</th>
                        <th class="border p-3">Status</th>
                        <th class="border p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border">
                            <td class="border p-3"><?= $row['material_name'] ?></td>
                            <td class="border p-3"><?= $row['unit_type'] ?></td>
                            <td class="border p-3"><?= $row['current_stock'] ?></td>
                            <td class="border p-3"><?= $row['min_required_stock'] ?></td>
                            <td class="border p-3 text-center <?= ($row['current_stock'] >= $row['min_required_stock']) ? 'text-green-500' : (($row['current_stock'] > 0) ? 'text-yellow-500' : 'text-red-500') ?>">
                                <?= ($row['current_stock'] >= $row['min_required_stock']) ? '✔️ Sufficient' : (($row['current_stock'] > 0) ? '⚠️ Low Stock' : '❌ Critical') ?>
                            </td>
                            <td class="border p-3 text-center">
                                <!-- Update Stock Form -->
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="number" name="new_stock" class="border p-1 w-20" value="<?= $row['current_stock'] ?>">
                                    <button type="submit" name="update_stock" class="bg-blue-500 text-white px-3 py-1 rounded">Update</button>
                                </form>
                                <!-- Delete Material Form -->
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_material" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Add New Material Section -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Add New Raw Material</h2>
        <form method="POST" class="flex flex-col items-center">
            <input type="text" name="material_name" placeholder="Material Name" required class="border p-2 m-2 w-1/2">
            <input type="text" name="unit_type" placeholder="Unit Type (meters, pieces, etc.)" required class="border p-2 m-2 w-1/2">
            <input type="number" name="current_stock" placeholder="Initial Stock Quantity" required class="border p-2 m-2 w-1/2">
            <input type="number" name="min_required_stock" placeholder="Minimum Required Stock" required class="border p-2 m-2 w-1/2">
            <input type="number" name="required_stock" placeholder="Required Stock" required class="border p-2 m-2 w-1/2">
            <button type="submit" name="add_material" class="bg-green-500 text-white px-4 py-2 rounded">Add Material</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>&copy; 2025 Smart Step. All rights reserved.</p>
    </footer>
</body>
</html>
