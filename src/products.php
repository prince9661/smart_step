<?php
session_start();
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SESSION['role'] == 'Manager') {
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
    <header class="bg-blue-600 p-2 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Products</h1>
            <nav class="bg-blue-600 p-4 text-white">
                <div class="container mx-auto flex justify-between items-center">
                    <ul class="flex space-x-6 items-center">
                        <li><a href="index.php" class="hover:underline">Home</a></li>
                        <li><a href="cart.php" class="hover:underline">View Cart</a></li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Customer'): ?>
                            <li><a href="my_orders.php" class="hover:underline">My Orders</a></li>
                        <?php endif; ?>
                        <li>
                            <?php
                            if (isset($_SESSION["user_id"])) {
                                echo "<a href='logout.php' class='hover:underline'>Logout</a>";
                            } else {
                                echo "<a href='login.php' class='hover:underline'>Login</a>";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
    </header>


    <div class="container mx-auto mt-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="<?= $row['image']; ?>" alt="<?= $row['name']; ?>" class=" h-72 w-full  rounded-md">
                <h2 class="text-xl font-bold mt-3"><?= $row['name']; ?></h2>
                <p class="text-gray-500"><?= $row['description']; ?></p>
                
                <!-- Pricing -->
                <p class="text-lg font-semibold text-green-600 mt-2">
                    $<?= $row['discount_price']; ?>
                    <span class="text-sm text-gray-500 line-through">$<?= $row['price']; ?></span>
                </p>

                <!-- Rating and Reviews -->
                <div class="flex items-center mt-2 text-yellow-500">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <?php if ($i < $row['rating']): ?>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.954L10 0l2.949 5.956 6.561.954-4.755 4.635 1.123 6.545z"/></svg>
                        <?php else: ?>
                            <svg class="w-5 h-5 text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.954L10 0l2.949 5.956 6.561.954-4.755 4.635 1.123 6.545z"/></svg>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <span class="ml-2 text-sm text-gray-600">(<?= $row['reviews']; ?> reviews)</span>
                </div>

                <!-- Quantity and Size -->
                <p class="text-sm mt-2 text-gray-700">Available: <?= $row['quantity']; ?> pcs</p>
                <p class="text-sm text-gray-700">Size: <?= $row['size']; ?></p>
                

                <!-- Add to Cart Form -->
                <form action="add_to_cart.php" method="POST" class="mt-3">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <label class="block text-sm text-gray-600 mb-1">Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" max="<?= $row['quantity']; ?>" class="border p-1 w-20 rounded-md">
                    <a href="product_detail.php?id=<?= $row['id'] ?>" class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded-lg hover:bg-blue-700 block">Add to Cart</button>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
