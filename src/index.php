<?php
session_start();

// Redirect based on user role
// if (isset($_SESSION["role"])) {
//     if ($_SESSION["role"] === "Manager") {
//         header("Location: index.php");
//         exit();
//     } elseif ($_SESSION["role"] === "Customer") {
//         header("Location: products.php");
//         exit();
//     }
// } else {
//     header("Location: login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Step - Automated Shoe Production System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Step</h1>
            <ul class="flex space-x-6">
                <li><a href="index.php" class="hover:underline">Home</a></li>
                <li><a href="order.php" class="hover:underline">Order Shoes</a></li>
                <li><a href="track.php" class="hover:underline">Track Order</a></li>
                <li><a href="inventory.php" class="hover:underline">Inventory</a></li>
                <li><a href="contact.php" class="hover:underline">Contact Us</a></li>
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

    <!-- Hero Section -->
    <header class="bg-blue-500 text-white text-center py-16">
        <h2 class="text-4xl font-bold">Smart Step: Revolutionizing Shoe Production with Automation!</h2>
        <p class="text-lg mt-4">Experience seamless and efficient shoe production with our AI-driven automation system. Track orders, manage inventory, and streamline manufacturing in one platform.</p>
        <div class="mt-6">
            <a href="order.php" class="bg-blue-700 px-6 py-3 text-lg font-semibold rounded-lg hover:bg-blue-800">Place Order</a>
            <a href="track.php" class="ml-4 bg-green-500 px-6 py-3 text-lg font-semibold rounded-lg hover:bg-green-600">Track Order</a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h3 class="text-2xl font-bold text-center">Why Choose Us?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 text-center">
            <div class="p-4 bg-gray-200 rounded-lg">
                <h4 class="font-semibold text-lg">Fast & Efficient Production</h4>
                <p class="text-gray-600">AI-powered workflow for quick turnarounds.</p>
            </div>
            <div class="p-4 bg-gray-200 rounded-lg">
                <h4 class="font-semibold text-lg">Real-Time Tracking</h4>
                <p class="text-gray-600">Monitor production and delivery at every stage.</p>
            </div>
            <div class="p-4 bg-gray-200 rounded-lg">
                <h4 class="font-semibold text-lg">Smart Inventory Management</h4>
                <p class="text-gray-600">Never run out of raw materials.</p>
            </div>
        </div>
    </section>

    <!-- Production Process Section -->
    <section class="container mx-auto my-10 p-6 bg-gray-100 shadow-lg rounded-lg text-center">
        <h3 class="text-2xl font-bold">Our Production Process</h3>
        <div class="mt-6 flex flex-wrap justify-center space-x-4">
            <span class="bg-blue-600 text-white px-4 py-2 rounded-lg">Order Placed</span>
            <span class="bg-blue-500 text-white px-4 py-2 rounded-lg">Processing</span>
            <span class="bg-blue-400 text-white px-4 py-2 rounded-lg">In Production</span>
            <span class="bg-blue-300 text-white px-4 py-2 rounded-lg">Quality Check</span>
            <span class="bg-blue-200 text-white px-4 py-2 rounded-lg">Ready for Delivery</span>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
        <h3 class="text-2xl font-bold text-center">What Our Customers Say</h3>
        <div class="mt-6 text-center">
            <p class="italic text-gray-700">"Smart Step has transformed our production process. The automation is seamless and efficient!" - John Doe</p>
            <p class="italic text-gray-700 mt-4">"Tracking orders in real-time has never been easier. Highly recommend!" - Jane Smith</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center py-6 mt-10">
        <p>&copy; 2025 Smart Step. All rights reserved.</p>
        <div class="mt-4">
            <a href="#" class="hover:underline mx-2">Facebook</a>
            <a href="#" class="hover:underline mx-2">Twitter</a>
            <a href="#" class="hover:underline mx-2">Instagram</a>
        </div>
        <div class="mt-4">
            <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-lg text-black" />
            <button class="bg-yellow-400 px-4 py-2 rounded-lg hover:bg-yellow-500">Subscribe</button>
        </div>
    </footer>
</body>
</html>
