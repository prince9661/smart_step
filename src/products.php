<?php
session_start();
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($_SESSION['role']=='Manager'){
    echo "<script>alert('You are not allowed to access this page!'); window.location='admin.php';</script>";
    exit();
}
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 p-4 text-white flex justify-between">
        <h1 class="text-2xl font-bold">Smart Step - Products</h1>
        <a href="cart.php" class=" text-white">View Cart</a>
    </header>

    <div class="container mx-auto mt-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="<?= $row['image']; ?>" alt="<?= $row['name']; ?>" class="w-full  object-cover">
                <h2 class="text-xl font-bold mt-2"><?= $row['name']; ?></h2>
                <p class="text-gray-500"><?= $row['description']; ?></p>
                <p class="text-gray-800 font-semibold">Price: $<?= $row['discount_price']; ?> 
                    <span class="text-sm text-gray-500 line-through">$<?= $row['price']; ?></span>
                </p>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" class="border p-1 w-16">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded-lg hover:bg-blue-700">Add to Cart</button>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
