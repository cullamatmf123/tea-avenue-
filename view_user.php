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

    // Query to fetch user details
    $sql = "SELECT * FROM login WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user ID provided.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View User Details</h1>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?php echo $row['id']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $row['username']; ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo ucfirst($row['role']); ?></td>
            </tr>
        </table>
        <a href="users.php" class="btn btn-primary">Back to Users</a>
    </div>
</body>
</html>
