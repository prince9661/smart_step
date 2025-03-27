<?php
// include 'db_connect.php';
$conn = new mysqli("localhost", "root", "", "smart_step_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch inventory data

// Fetch production schedule data
$sql = "SELECT * FROM production_schedule ORDER BY FIELD(priority, 'High', 'Medium', 'Low'), order_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Schedule - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-blue-600 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Smart Step</h1>
        <ul class="flex space-x-6">
            <li><a href="index.php" class="hover:underline">Home</a></li>
            <li><a href="order.php" class="hover:underline">Orders</a></li>
            <li><a href="inventory.php" class="hover:underline">Inventory</a></li>
            <li><a href="reports.php" class="hover:underline">Reports</a></li>
            <li><a href="contact.php" class="hover:underline">Contact Us</a></li>
            <li><a href="admin.php" class="hover:underline">Admin Dashboard</a></li>
        </ul>
    </div>
</nav>

<!-- Production Schedule -->
<section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-center">Production Schedule</h2>
    <p class="text-gray-700 text-center">Monitor pending orders and prioritize tasks efficiently.</p>

    <table class="table-auto w-full mt-6 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Order ID</th>
                <th class="border px-4 py-2">Customer</th>
                <th class="border px-4 py-2">Shoe Type</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Order Date</th>
                <th class="border px-4 py-2">Priority</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Estimated Completion</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr class="text-center">
                    <td class="border px-4 py-2"><?php echo $row['order_id']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['customer_name']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['shoe_type']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['quantity']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['order_date']; ?></td>
                    <td class="border px-4 py-2">
                        <span class="px-3 py-1 text-white rounded 
                        <?php echo ($row['priority'] == 'High') ? 'bg-red-500' : (($row['priority'] == 'Medium') ? 'bg-yellow-500' : 'bg-green-500'); ?>">
                        <?php echo $row['priority']; ?>
                        </span>
                    </td>
                    <td class="border px-4 py-2"><?php echo $row['status']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['estimated_completion']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

</body>
</html>
