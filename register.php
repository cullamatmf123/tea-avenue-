<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = 'user'; // Default role is 'user'

    // Input validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Check if the username already exists
        $sql_check = "SELECT * FROM login WHERE username = ?";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username already exists. Please choose another.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sql_insert = "INSERT INTO login (username, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            if ($stmt->execute()) {
                echo "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #ffe4e1);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 380px;
            width: 100%;
            text-align: center;
        }

        .register-card h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 25px;
        }

        .register-card label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        .register-card input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .register-card input[type="submit"] {
            background: linear-gradient(to right, #6c63ff, #a28cf5);
            color: white;
            border: none;
            cursor: pointer;
        }

        .register-card input[type="submit"]:hover {
            background: linear-gradient(to right, #5a54e1, #8f7ef3);
        }

        .register-card a {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #6c63ff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h1>Register</h1>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Re-enter your password" required>

            <input type="submit" value="Register">
            <a href="login.php">Already have an account? Login here</a>
        </form>
    </div>
</body>

</html>
