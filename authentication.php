<?php
session_start(); // Start the session to store user data
include('connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $username = mysqli_real_escape_string($con, trim($_POST['username']));
    $password = mysqli_real_escape_string($con, trim($_POST['password']));

    // SQL query to check the username and password
    $sql = "SELECT * FROM Login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    // Fetch user data
    $row = mysqli_fetch_assoc($result);

    // Check if the user exists
    if ($row) {
        // Store user data in the session
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on the user's role
        if ($row['role'] == 'admin') {
            header("Location: admin index.php"); // Redirect to the admin dashboard
            exit();
        } else {
            header("Location: index.php"); // Redirect to the user dashboard
            exit();
        }
    } else {
        // If login fails, display an error message
        echo "<h3>Login failed. Invalid username or password.</h3>";
        echo "<a href='login.php'>Try Again</a>"; // Provide a link back to the login page
    }
} elseif (isset($_GET['logout'])) {
    // Handle logout functionality
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
} else {
    // If not a POST request, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
