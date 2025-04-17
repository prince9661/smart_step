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
    <style>
        /* Background image and blur effect */
        body {
            background-image: url('https://example.com/your-image.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
            filter: blur(10px); /* Apply blur */
            z-index: -1;
        }

        /* Styling the login form container */
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #d1d5db; /* Border around the login credentials */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            z-index: 10;
        }

        /* Button hover effect */
        button:hover {
            background-color: #3b82f6;
        }
    </style>
</head>
<body>

    <div class="overlay"></div> <!-- Overlay with blur effect -->

    <div class="login-container">
        <h2 class="text-2xl font-bold text-center mb-6 text-blue-600">Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required class="border p-2 w-full mt-3 rounded-md">
            <input type="password" name="password" placeholder="Password" required class="border p-2 w-full mt-3 rounded-md">
            <button type="submit" name="login" class="bg-blue-500 text-white w-full p-2 rounded mt-4">Login</button>
        </form>
        <p class="mt-2 text-right">
            <a href="forgot_password.php" class="text-blue-500 text-sm hover:underline">Forgot Password?</a>
        </p>
        <p class="mt-4 text-center">
            Don't have an account? <a href="signup.php" class="text-blue-500">Sign Up</a>
        </p>
    </div>

</body>
</html>
