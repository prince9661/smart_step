<?php
session_start();
$conn = new mysqli("localhost", "root", "", "smart_step_db");

// Check database connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8"); // Set charset for better compatibility

$order_id = $status = $delivery_date = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = trim($_POST['order_id']);

    if (!empty($order_id)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT status, estimated_completion FROM production_schedule WHERE order_id = ?");
        if ($stmt) {
            $stmt->bind_param("s", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $order = $result->fetch_assoc();
                $status = htmlspecialchars($order['status']);
                $delivery_date = htmlspecialchars($order['estimated_completion']);
            } else {
                $error_message = "Order not found. Please check your Order ID and try again.";
            }
            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $conn->error;
        }
    } else {
        $error_message = "Please enter a valid Order ID.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">Smart Step</h1>
        <nav>
            <a href="index.php" class="px-4 hover:underline">Home</a>
            <a href="order_shoes.php" class="px-4 hover:underline">Order Shoes</a>
            <a href="inventory.php" class="px-4 hover:underline">Inventory</a>
            <a href="contact.php" class="px-4 hover:underline">Contact Us</a>
            <a href="login.php" class="px-4 hover:underline">Login/Register</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-center">Track Your Order in Real Time</h2>
        <p class="text-center text-gray-600">Enter your Order ID below to check the status and estimated delivery time.</p>

        <form method="POST" class="mt-4 flex flex-col gap-4">
            <input type="text" name="order_id" placeholder="Enter Order ID" class="border p-2 rounded w-full" required>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Check Status</button>
        </form>

        <?php if (!empty($error_message)) { ?>
            <p class="text-red-500 mt-2 text-center"><?= $error_message; ?></p>
        <?php } ?>

        <?php if (!empty($status)) { ?>
            <h3 class="text-lg font-semibold mt-4 text-center">Order Status: <?= $status; ?></h3>
            <p class="text-gray-700 text-center">Estimated Delivery Date: <?= $delivery_date; ?></p>

            <!-- Order Status Progress Tracker -->
            <div class="flex justify-between items-center mt-4">
                <?php
                $statuses = ["Pending","Scheduled", "In Production", "Completed", "Delivered"];
                foreach ($statuses as $step) {
                    $active = (array_search($status, $statuses) >= array_search($step, $statuses)) ? "bg-green-500 text-white" : "bg-gray-300";
                    echo "<div class='w-1/4 text-center py-2 rounded $active'>$step</div>";
                }
                ?>
            </div>
        <?php } ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>Contact support: support@smartstep.com | <a href="#" class="underline">FAQ</a> | <a href="#" class="underline">Return Policy</a></p>
    </footer>
</body>
</html>
