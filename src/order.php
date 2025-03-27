<?php
session_start();
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shoe_type = $_POST['shoe_type'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $quantity = intval($_POST['quantity']);
    
    // Dummy price calculation logic
    $prices = ["Sneakers" => 50, "Boots" => 70, "Sandals" => 40, "Formal Shoes" => 80];
    $total_price = $prices[$shoe_type] * $quantity;
    
    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (shoe_type, size, color, quantity, total_price, status, estimated_delivery) VALUES (?, ?, ?, ?, ?, 'Pending', DATE_ADD(NOW(), INTERVAL 7 DAY))");
    $stmt->bind_param("sssis", $shoe_type, $size, $color, $quantity, $total_price);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $success_message = "Order placed successfully! Track your order <a href='track_order.php'>here</a>.";
    } else {
        $success_message = "Error placing order. Please try again.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Shoes - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">Smart Step</h1>
        <nav>
            <a href="index.php" class="px-4 hover:underline">Home</a>
            <a href="track_order.php" class="px-4 hover:underline">Track Order</a>
            <a href="inventory.php" class="px-4 hover:underline">Inventory</a>
            <a href="contact.php" class="px-4 hover:underline">Contact Us</a>
            <a href="login.php" class="px-4 hover:underline">Login/Register</a>
        </nav>
    </header>
    <main class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-center">Place Your Custom Shoe Order</h2>
        <p class="text-center text-gray-600">Customize your perfect pair with Smart Step’s advanced production system.</p>
        <form method="POST" class="mt-4 flex flex-col gap-4">
            <label>Shoe Type:</label>
            <select name="shoe_type" class="border p-2 rounded w-full" required>
                <option value="Sneakers">Sneakers</option>
                <option value="Boots">Boots</option>
                <option value="Sandals">Sandals</option>
                <option value="Formal Shoes">Formal Shoes</option>
            </select>
            <label>Size:</label>
            <input type="text" name="size" placeholder="Enter Size (EU/US/UK)" class="border p-2 rounded w-full" required>
            <label>Color:</label>
            <input type="color" name="color" class="border p-2 rounded w-full">
            <label>Quantity:</label>
            <input type="number" name="quantity" min="1" value="1" class="border p-2 rounded w-full" required>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Confirm Order</button>
        </form>
        <?php if ($success_message) { ?>
            <p class="text-green-500 mt-2 text-center"><?= $success_message; ?></p>
        <?php } ?>
    </main>
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>Contact support: support@smartstep.com | <a href="#" class="underline">FAQ</a> | <a href="#" class="underline">Refund Policy</a></p>
    </footer>
</body>
</html>
