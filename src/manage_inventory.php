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
    $required_stock = $_POST['required_stock'];

    $conn->query("INSERT INTO inventory (material_name, unit_type, current_stock, min_required_stock, required_stock) 
                  VALUES ('$material_name', '$unit_type', $current_stock, $min_required_stock, $required_stock)");

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif !important;
        }
        nav ul li a {
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            text-decoration: none;
            color: blue;
            background-color: #ffffff;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Manage Inventory</h1>
            <ul class="flex space-x-6">
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="order.php">Order</a></li>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="upload_product.php">Upload Shoes</a></li>
                <li><a href="update_quantity.php">Update Shoes</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Inventory Overview -->
    <section class="container mx-auto mt-10 px-4">
  <div class="bg-white shadow-lg rounded-lg p-6 text-center">
    <h2 class="text-3xl font-bold">Manage Your Inventory Efficiently</h2>
    <p class="text-gray-700 mt-2">Track raw materials in real-time and ensure seamless shoe production.</p>

    <!-- Inventory Table -->
    <div class="mt-6 overflow-x-auto">
      <table class="w-full border-collapse bg-white shadow-md text-left">
        <thead>
          <tr class=" text-white bg-gray-500">
            <th class="p-3">Material Name</th>
            <th class="p-3">Current Stock</th>
            <th class="p-3">Required Stock</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="border-b">
              <td class="p-3"><?php echo $row['material_name']; ?></td>
              <td class="p-3"><?php echo $row['current_stock']; ?></td>
              <td class="p-3"><?php echo $row['required_stock']; ?></td>
              <td class="p-3">
                <?php 
                  $status = "<span class='text-green-600'>Sufficient</span>";
                  if ($row['current_stock'] <= $row['required_stock'] * 0.5) {
                    $status = "<span class='text-red-600 font-bold'>Critical - Restock Needed!</span>";
                  } elseif ($row['current_stock'] <= $row['required_stock'] * 0.8) {
                    $status = "<span class='text-yellow-500 font-semibold'>Low Stock</span>";
                  }
                  echo $status;
                ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

    <!-- Add New Material Section -->
<section class="container mx-auto mt-10 px-4">
  <div class="bg-white shadow-lg rounded-lg p-6 text-center">
    <h2 class="text-2xl font-bold mb-4">Add New Raw Material</h2>
    <form method="POST" class="flex flex-col items-center">
        <input type="text" name="material_name" placeholder="Material Name" required class="border p-2 m-2 w-1/2">
        <input type="text" name="unit_type" placeholder="Unit Type (meters, pieces, etc.)" required class="border p-2 m-2 w-1/2">
        <input type="number" name="current_stock" placeholder="Initial Stock Quantity" required class="border p-2 m-2 w-1/2">
        <input type="number" name="min_required_stock" placeholder="Minimum Required Stock" required class="border p-2 m-2 w-1/2">
        <input type="number" name="required_stock" placeholder="Required Stock" required class="border p-2 m-2 w-1/2">
        <button type="submit" name="add_material" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Add Material</button>
    </form>
  </div>
</section>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>&copy; 2025 Smart Step. All rights reserved.</p>
    </footer>

</body>
</html>
