<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin index.php");
            } else {
                header("Location: index.php");
            }
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "No user found with that username.";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Body background with perspective */
        body {
            background: linear-gradient(135deg, #dbeafe, #ffe4e1);
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: #333;
            perspective: 1000px; /* Adds depth for 3D animation */
        }

        /* Floating background shapes */
        .background-shape {
            position: absolute;
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #6c63ff, #a28cf5);
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.7;
            animation: float 10s infinite ease-in-out;
        }

        .background-shape:nth-child(2) {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #ffb6c1, #ffa07a);
            animation: float2 12s infinite ease-in-out;
        }

        .background-shape:nth-child(3) {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #add8e6, #87cefa);
            animation: float3 15s infinite ease-in-out;
        }

        /* Animations for movement */
        @keyframes float {
            0% {
                transform: translate(-30%, -30%);
            }
            50% {
                transform: translate(30%, 30%);
            }
            100% {
                transform: translate(-30%, -30%);
            }
        }

        @keyframes float2 {
            0% {
                transform: translate(30%, -40%);
            }
            50% {
                transform: translate(-40%, 40%);
            }
            100% {
                transform: translate(30%, -40%);
            }
        }

        @keyframes float3 {
            0% {
                transform: translate(-40%, 30%);
            }
            50% {
                transform: translate(40%, -30%);
            }
            100% {
                transform: translate(-40%, 30%);
            }
        }

        /* Login card styling */
        .login-card {
            background: rgba(255, 255, 255, 0.5); /* Reduced opacity */
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 380px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 10; /* Ensures it's above the background shapes */
            backdrop-filter: blur(10px); /* Optional: Adds a blur effect for a frosted glass look */
        }

        .login-card h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .login-card label {
            font-size: 14px;
            color: #555;
            font-weight: bold;
            text-align: left;
            display: block;
            margin-bottom: 8px;
        }

        .login-card input[type="text"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        .login-card input[type="text"]:focus,
        .login-card input[type="password"]:focus {
            border-color: #6c63ff;
            outline: none;
        }

        .login-card input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            background: linear-gradient(to right, #6c63ff, #a28cf5);
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-card input[type="submit"]:hover {
            background: linear-gradient(to right, #5a54e1, #8f7ef3);
        }

        .login-card a {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #6c63ff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-card a:hover {
            color: #4a47c6;
        }
    </style>
</head>

<body>
    <!-- Animated Background Shapes -->
    <div class="background-shape"></div>
    <div class="background-shape"></div>
    <div class="background-shape"></div>

    <!-- Login Card -->
    <div class="login-card">
        <h1>Tea Avenue Login</h1>
        <form name="f1" action="authentication.php" onsubmit="return validation()" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="user" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="pass" placeholder="Enter your password" required>

            <input type="submit" value="Login">
            <a href="./register.php">Don't have an account? Register here</a>
        </form>
    </div>
</body>

</html>
