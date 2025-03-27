<?php
session_start();
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");

if ($cart_items->num_rows > 0) {
    while ($item = $cart_items->fetch_assoc()) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // Check if stock is sufficient
        $product_result = $conn->query("SELECT quantity FROM products WHERE id = $product_id");
        $product = $product_result->fetch_assoc();

        if ($product['quantity'] < $quantity) {
            echo "<script>alert('Insufficient stock for {$item['name']}. Available stock: {$product['quantity']}'); window.location='cart.php';</script>";
            exit();
        }

        // Reduce product quantity
        $conn->query("UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id");
    }

    // Clear the cart
    $conn->query("DELETE FROM cart WHERE user_id = $user_id");

    echo "<script>alert('Checkout successful! Your order has been placed.'); window.location='products.php';</script>";
} else {
    echo "<script>alert('Your cart is empty.'); window.location='products.php';</script>";
}

$conn->close();
?>
