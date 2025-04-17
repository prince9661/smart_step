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

        /* Styling adjustments */
        .container {
            max-width: 1400px; /* Increased the container width */
            margin: 0 auto; /* Center the container */
            padding: 0 30px; /* Slightly increased padding */
        }

        .product-card {
            background-color: white;
            padding: 16px; /* Increased padding */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: auto; /* Auto height to adjust based on content */
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: 200px; /* Increased image height */
            object-fit: cover;
            border-radius: 8px;
        }

        .product-info {
            margin-top: 12px;
        }

        .product-info h2 {
            font-size: 1.125rem; /* Slightly larger font size */
            font-weight: 600;
        }

        .product-info p {
            font-size: 0.875rem; /* Slightly larger font size for description */
            color: #4B5563;
            margin-top: 6px;
        }

        .pricing {
            margin-top: 10px;
            font-size: 1.125rem;
            font-weight: 600;
            color: #16A34A;
        }

        .old-price {
            text-decoration: line-through;
            font-size: 0.875rem;
            color: #6B7280;
            margin-left: 8px;
        }

        .product-rating {
            margin-top: 8px;
            display: flex;
            align-items: center;
            color: #F59E0B;
        }

        .product-rating svg {
            width: 18px;
            height: 18px;
        }

        .product-info p,
        .product-rating {
            font-size: 0.875rem; /* Slightly larger font size */
        }

        .product-action {
            margin-top: 12px;
        }

        .btn-add-cart,
        .btn-view {
            display: block;
            width: 100%;
            padding: 10px; /* Increased padding */
            background-color: #3B82F6;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: 600;
            transition: background-color 0.3s ease;
            font-size: 1rem; /* Slightly larger font size for buttons */
        }

        .btn-add-cart:hover,
        .btn-view:hover {
            background-color: #2563EB;
        }

        .quantity-input {
            width: 60px; /* Slightly increased width */
            padding: 6px; /* Increased padding */
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 0.875rem; /* Slightly larger font size */
            text-align: center;
        }

        .grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjusted grid layout */
            gap: 24px; /* Increased gap between items */
        }

    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 p-2 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step - Products</h1>
            <nav class="bg-blue-600 p-4 text-white">
                <div class="container mx-auto flex justify-between items-center">
                    <ul class="flex space-x-6 items-center">
                        <li><a href="index.php" >Home</a></li>
                        <li><a href="cart.php" >View Cart</a></li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Customer'): ?>
                            <li><a href="my_orders.php" >My Orders</a></li>
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

    <div class="container mt-10">
        <div class="grid">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?= $row['image']; ?>" alt="<?= $row['name']; ?>" class="product-image">
                <div class="product-info">
                    <h2><?= $row['name']; ?></h2>
                    <p><?= $row['description']; ?></p>
                    <p class="pricing">
                        $<?= $row['discount_price']; ?>
                        <span class="old-price">$<?= $row['price']; ?></span>
                    </p>

                    <div class="product-rating">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <?php if ($i < $row['rating']): ?>
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.954L10 0l2.949 5.956 6.561.954-4.755 4.635 1.123 6.545z"/></svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.954L10 0l2.949 5.956 6.561.954-4.755 4.635 1.123 6.545z"/></svg>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="ml-2 text-sm text-gray-600">(<?= $row['reviews']; ?> reviews)</span>
                    </div>

                    <p class="text-sm text-gray-700">Available: <?= $row['quantity']; ?> pcs</p>
                    <p class="text-sm text-gray-700">Size: <?= $row['size']; ?></p>
                </div>

                <div class="product-action">
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                        <label class="block text-sm text-gray-600 mb-1">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="<?= $row['quantity']; ?>" class="quantity-input">
                        <a href="product_detail.php?id=<?= $row['id'] ?>" class="btn-view mt-2">View</a>
                        <button type="submit" class="btn-add-cart mt-2">Add to Cart</button>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
