<?php
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalOrders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
$pendingOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status='Pending'")->fetch_assoc()['count'];
$completedOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status='Completed'")->fetch_assoc()['count'];
$lowStockItems = $conn->query("SELECT COUNT(*) AS count FROM products WHERE quantity < 20")->fetch_assoc()['count'];

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Smart Step</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Custom font override -->
    <style>
        * {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-blue-600 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Smart Step - Admin Dashboard</h1>
        <ul class="flex space-x-6">
            <li><a href="admin.php" class="hover:underline">Dashboard</a></li>
            <li><a href="index.php" class="hover:underline">Home</a></li>
            <li><a href="order.php" class="hover:underline">Order</a></li>
            <li><a href="inventory.php" class="hover:underline">Inventory</a></li>
            <li><a href="upload_product.php" class="hover:underline">Upload_Shoes</a></li>
            <li><a href="update_quantity.php" class="hover:underline">Update_Shoes</a></li>
            <li><a href="users.php" class="hover:underline">users</a></li>
            <li><a href="logout.php" class="hover:underline">Logout</a></li>
        </ul>
    </div>
</nav>

<!-- Dashboard Metrics -->
<section class="container mx-auto mt-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-blue-200 p-6 rounded-lg text-center">
            <h3 class="text-2xl font-bold"><?= $totalOrders ?></h3>
            <p>Total Orders</p>
        </div>
        <div class="bg-yellow-200 p-6 rounded-lg text-center">
            <h3 class="text-2xl font-bold"><?= $pendingOrders ?></h3>
            <p>Pending Orders</p>
        </div>
        <div class="bg-green-200 p-6 rounded-lg text-center">
            <h3 class="text-2xl font-bold"><?= $completedOrders ?></h3>
            <p>Completed Orders</p>
        </div>
        <div class="bg-red-200 p-6 rounded-lg text-center">
            <h3 class="text-2xl font-bold"><?= $lowStockItems ?></h3>
            <p>Low Stock Alerts</p>
        </div>
    </div>
</section>

<!-- Product Inventory Table -->
<section class="container mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Product Inventory</h2>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Image</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Size</th>
                <th class="p-2 border">Quantity</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Update Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $products->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="p-2"><img src="<?= $row['image'] ?>" class="w-16 h-16 object-cover"></td>
                    <td class="p-2"><?= $row['name'] ?></td>
                    <td class="p-2"><?= $row['size'] ?></td>
                    <td class="p-2"><?= $row['quantity'] ?></td>
                    <td class="p-2">
                        <?php if ($row['quantity'] < 20): ?>
                            <span class="text-red-600 font-semibold">Low Stock</span>
                        <?php else: ?>
                            <span class="text-green-600">In Stock</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-2">
                        <form action="upd_quan.php" method="POST" class="flex items-center gap-2">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <input type="number" name="new_quantity" placeholder="Qty" class="border p-1 w-20" required>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<!-- Pending Orders Management -->
<section class="container mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Pending Orders</h2>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Order ID</th>
                <th class="p-2 border">User ID</th>
                <th class="p-2 border">Product ID</th>
                <th class="p-2 border">Size</th>
                <th class="p-2 border">Quantity</th>
                <th class="p-2 border">Total Price</th>
                <th class="p-2 border">Created At</th>
                <th class="p-2 border">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pendingResult = $conn->query("SELECT * FROM orders WHERE status = 'Pending'");
            while ($order = $pendingResult->fetch_assoc()):
            ?>
            <tr class="border-t">
                <td class="p-2"><?= $order['id'] ?></td>
                <td class="p-2"><?= $order['user_id'] ?></td>
                <td class="p-2"><?= $order['product_id'] ?></td>
                <td class="p-2"><?= $order['size'] ?></td>
                <td class="p-2"><?= $order['quantity'] ?></td>
                <td class="p-2">$<?= number_format($order['total_price'], 2) ?></td>
                <td class="p-2"><?= $order['created_at'] ?></td>
                <td class="p-2">
                    <form method="POST" action="update_order_status.php">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            Mark as Completed
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white text-center py-4 mt-10">
    &copy; 2025 Smart Step. All rights reserved.
</footer>

</body>
</html>
