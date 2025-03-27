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
// Check if product_id is set
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Validate product existence
    $sql = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $sql->bind_param("i", $product_id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();

        // Check if product is already in the cart
        $checkCart = $conn->prepare("SELECT * FROM cart WHERE product_id = ? AND user_id = ?");
        $checkCart->bind_param("ii", $product_id, $user_id);
        $checkCart->execute();
        $cartResult = $checkCart->get_result();
        
        if ($cartResult->num_rows > 0) {
            // Update the quantity if the product is already in the cart
            $updateCart = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ?");
            $updateCart->bind_param("iii", $quantity, $product_id, $user_id);
            $updateCart->execute();
        } else {
            // Insert the product into the cart
            $stmt = $conn->prepare("INSERT INTO cart (product_id, name, description, price, discount_price, quantity, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issddisi", $product['id'], $product['name'], $product['description'], $product['price'], $product['discount_price'], $quantity, $product['image'], $user_id);
            $stmt->execute();
        }
        
        echo "<script>alert('Product added to cart successfully!'); window.location='cart.php';</script>";
    } else {
        echo "<script>alert('Product not found!'); window.location='products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location='products.php';</script>";
}

$conn->close();
?>
