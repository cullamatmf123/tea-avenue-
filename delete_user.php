<?php
session_start();
include('db.php');

// Ensure that the user is logged in and has an admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from the database
    $delete_sql = "DELETE FROM login WHERE id = '$user_id'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "User deleted successfully.";
        header("Location: users.php"); // Redirect back to users list
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "No user ID provided.";
    exit();
}

$conn->close();
?>
