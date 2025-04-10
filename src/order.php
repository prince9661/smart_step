<?php
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT orders.*, products.name AS product_name, products.size, users.full_name 
        FROM orders 
        JOIN products ON orders.product_id = products.id 
        JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-blue-600 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Smart Step - Orders</h1>
        <ul class="flex space-x-6">
            <li><a href="admin.php" class="hover:underline">Dashboard</a></li>
            <li><a href="index.php" class="hover:underline">Home</a></li>
            <li><a href="order.php" class="hover:underline">Order</a></li>
            <li><a href="inventory.php" class="hover:underline">Inventory</a></li>
            <li><a href="upload_product.php" class="hover:underline">Upload_Shoes</a></li>
            <li><a href="update_quantity.php" class="hover:underline">Update_Shoes</a></li>
            <li><a href="logout.php" class="hover:underline">Logout</a></li>
        </ul>
    </div>
</nav>

<!-- Orders Table -->
<section class="container mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">All Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">Order ID</th>
                    <th class="p-3 border">Customer Name</th>
                    <th class="p-3 border">Product</th>
                    <th class="p-3 border">Size</th>
                    <th class="p-3 border">Quantity</th>
                    <th class="p-3 border">Total Price</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="text-center border-t">
                            <td class="p-2"><?= $row['id'] ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['full_name']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['product_name']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['size']) ?></td>
                            <td class="p-2"><?= $row['quantity'] ?></td>
                            <td class="p-2">₹<?= number_format($row['total_price'], 2) ?></td>
                            <td class="p-2">
                                <?php
                                $status = $row['status'];
                                $color = match ($status) {
                                    'Pending' => 'bg-yellow-200 text-yellow-800',
                                    'Completed' => 'bg-green-200 text-green-800',
                                    'Cancelled' => 'bg-red-200 text-red-800',
                                    default => 'bg-gray-200 text-gray-800',
                                };
                                ?>
                                <span class="px-3 py-1 rounded-full <?= $color ?>"><?= $status ?></span>
                            </td>
                            <td class="p-2"><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center p-4 text-gray-600">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white text-center py-4 mt-10">
    &copy; 2025 Smart Step. All rights reserved.
</footer>

</body>
</html>
