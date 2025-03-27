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
$result = $conn->query("SELECT * FROM cart WHERE user_id = {$_SESSION['user_id']}");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Cart - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 p-4 text-white">
        <h1 class="text-2xl font-bold">Smart Step - Your Cart</h1>
        <a href="products.php" class="float-right text-white">Continue Shopping</a>
    </header>

    <div class="container mx-auto mt-10">
        <h2 class="text-3xl font-bold mb-6">Your Cart</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="w-full bg-white rounded-lg shadow-md ">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $total = 0; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $subtotal = $row['quantity'] * $row['discount_price']; ?>
                        <?php $total += $subtotal; ?>
                        <tr >
                            <td>
                                <img src="<?= $row['image']; ?>" alt="<?= $row['name']; ?>" class="w-20 h-20 object-cover">
                                <?= $row['name']; ?>
                            </td>
                            <td>$<?= number_format($row['discount_price'], 2); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td>$<?= number_format($subtotal, 2); ?></td>
                            <td>
                                <a href="remove_from_cart.php?id=<?= $row['id']; ?>" class="text-red-500">Remove</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3 class="text-xl font-bold mt-6">Total: $<?= number_format($total, 2); ?></h3>
            <form action="checkout.php" method="post">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 mt-4 rounded-lg hover:bg-blue-700">Proceed to Checkout</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty. <a href="products.php" class="text-blue-500">Shop Now</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
