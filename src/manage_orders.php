<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "smart_step_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Order Status Updates
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // If the order is rejected, save the reason
    if ($new_status == "Rejected") {
        $reason = $_POST['reason'];
        $conn->query("UPDATE orders SET status='$new_status' WHERE id=$order_id");
    } else {
        $conn->query("UPDATE orders SET status='$new_status' WHERE id=$order_id");
    }

    header("Location: manage-orders.php");
    exit();
}

// Fetch Orders
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Manage Orders</h1>
            <ul class="flex space-x-6">
                <li><a href="admin-dashboard.php" class="hover:underline">Dashboard</a></li>
                <li><a href="inventory.php" class="hover:underline">Inventory</a></li>
                <li><a href="production.php" class="hover:underline">Production Schedule</a></li>
                <li><a href="reports.php" class="hover:underline">Reports</a></li>
                <li><a href="logout.php" class="hover:underline">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Orders Overview -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-center mb-6">Manage Customer Orders 🚀</h2>
        <p class="text-gray-600 text-center">Track, approve, reject, or modify orders to ensure smooth processing.</p>

        <!-- Orders Table -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3">Order ID</th>
                        <th class="border p-3">Customer Name</th>
                        <th class="border p-3">Shoe Type</th>
                        <th class="border p-3">Quantity</th>
                        <th class="border p-3">Order Date</th>
                        <th class="border p-3">Status</th>
                        <th class="border p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border">
                            <td class="border p-3"><?= $row['id'] ?></td>
                            <td class="border p-3"><?= $row['customer_name'] ?></td>
                            <td class="border p-3"><?= $row['shoe_type'] ?></td>
                            <td class="border p-3"><?= $row['quantity'] ?></td>
                            <td class="border p-3"><?= $row['order_date'] ?></td>
                            <td class="border p-3 text-center <?= $row['status'] == 'Rejected' ? 'text-red-500' : ($row['status'] == 'Completed' ? 'text-green-500' : 'text-yellow-500') ?>">
                                <?= $row['status'] ?>
                            </td>
                            <td class="border p-3 text-center">
                                <form method="POST">
                                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                    <select name="status" class="border p-2 rounded">
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                        <option value="In Production">In Production</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                    <button type="submit" name="update_status" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>&copy; 2025 Smart Step. All rights reserved.</p>
    </footer>
</body>
</html>
