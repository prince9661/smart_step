
<?php
$conn = new mysqli("localhost", "root", "", "smart_step_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount_price = $_POST['discount_price'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, discount_price, rating, reviews, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdddss", $name, $description, $price, $discount_price, $rating, $reviews, $target_file);
        $stmt->execute();
        echo "<p class='text-green-600 mt-4'>Product uploaded successfully!</p>";
    } else {
        echo "<p class='text-red-600 mt-4'>Error uploading file.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Product - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6">Upload Product</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="name" placeholder="Product Name" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <input type="text" name="description" placeholder="Description" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <input type="number" step="0.01" name="price" placeholder="Price" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <input type="number" step="0.01" name="discount_price" placeholder="Discount Price" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <input type="number" name="reviews" placeholder="Number of Reviews" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded-lg" required />
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Upload Product</button>
        </form>
    </div>
</body>
</html>