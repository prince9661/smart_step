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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Custom font override -->
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

 
   
        /* Set the background to white */
        body {
            background-color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
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
            text-align: center;
        }

        .login-container h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #3b82f6;
        }

        /* Input and button styling */
        .login-container input[type="email"],
        .login-container input[type="password"] {
            border: 1px solid #d1d5db;
            padding: 12px;
            width: 100%;
            margin-top: 10px;
            border-radius: 8px;
            font-size: 1rem;
        }

        .login-container button {
            background-color: #3b82f6;
            color: white;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 1rem;
            margin-top: 20px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #2563eb;
        }

        /* Text links */
        .login-container p {
            font-size: 0.875rem;
            margin-top: 12px;
        }

        .login-container a {
            color: #3b82f6;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>
            <a href="forgot_password.php">Forgot Password?</a>
        </p>
        <p>
            Don't have an account? <a href="signup.php">Sign Up</a>
        </p>
    </div>

</body>
</html>
