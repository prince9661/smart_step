<?php
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle quantity updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $id = intval($id);
        $qty = intval($qty);
        $conn->query("UPDATE products SET quantity = $qty WHERE id = $id");
    }
    echo "<script>alert('Quantities updated successfully!'); window.location='update_quantity.php';</script>";
    exit();
}

// Get products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product Quantities - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Update Product Quantities</h1>

        <form action="" method="POST">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-left">
                        <th class="p-2 border">Image</th>
                        <th class="p-2 border">Product Name</th>
                        <th class="p-2 border">Size</th>
                        <th class="p-2 border">Current Quantity</th>
                        <th class="p-2 border">Update Quantity</th>
                        <th class="p-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="bg-white border-t text-center">
                            <td class="p-2">
                                <img src="<?= $row['image']; ?>" class="w-16 h-16 object-cover mx-auto" />
                            </td>
                            <td class="p-2"><?= $row['name']; ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['size']); ?></td>
                            <td class="p-2"><?= $row['quantity']; ?></td>
                            <td class="p-2">
                                <input type="number" name="quantities[<?= $row['id']; ?>]" value="<?= $row['quantity']; ?>" class="p-1 border rounded w-20 text-center" />
                            </td>
                            <td class="p-2">
                                <?php if ($row['quantity'] < 20): ?>
                                    <span class="text-red-600 font-semibold">Low Stock</span>
                                <?php else: ?>
                                    <span class="text-green-600 font-semibold">Sufficient</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="mt-6 text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update Quantities</button>
            </div>
        </form>
    </div>
</body>
</html>
