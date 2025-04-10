
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "smart_step_db");

// Check DB Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            if ($user['status'] === 'Pending') {
                echo "<script>alert('Please verify your email first.');</script>";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                if($user['role'] === 'Manager') {
                    
                    header("Location: admin.php"); // Redirect to dashboard
                } else {
                    header("Location: index.php"); // Redirect to user dashboard
                
                } 
            }
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('User not found. Please sign up.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Smart Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center"> Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required class="border p-2 w-full mt-3">
            <input type="password" name="password" placeholder="Password" required class="border p-2 w-full mt-3">
            <button type="submit" name="login" class="bg-blue-500 text-white w-full p-2 rounded mt-4">Login</button>
        </form>
        <p class="mt-2 text-right">
            <a href="forgot_password.php" class="text-blue-500 text-sm hover:underline">Forgot Password?<a>
        </p>
        <p class="mt-4 text-center">
            Don't have an account? <a href="signup.php" class="text-blue-500">Sign Up</a>
        </p>
    </div>
</body>
</html>
