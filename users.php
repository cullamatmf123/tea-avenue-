<?php
// Start the session and check if the user is an admin
session_start();

// Ensure that the user is logged in and has an admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Include the database connection
include('db.php'); // Adjust the path to db.php

// Query to fetch all users
$sql = "SELECT id, username, role FROM login";
$result = $conn->query($sql);

// Check for database query errors
if (!$result) {
    die("Error fetching users: " . $conn->error);
}
?>

<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Tea Shop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: -250px;
            display: flex;
            flex-direction: column;
            padding: 15px 10px;
            transition: left 0.3s ease, transform 0.3s ease;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px;
            margin-bottom: 10px;
            font-size: 1.2rem;
            border-radius: 5px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        .sidebar ul li:hover {
            background-color: #495057;
        }

        .sidebar ul li i {
            margin-right: 10px;
        }

        .sidebar .close-btn {
            position: absolute;
            top: 40px;
            right: 20px;
            color: white;
            font-size: 1.8rem;
            cursor: pointer;
        }

        .content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .content.shift {
            margin-left: 250px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            margin-top: -20px;
        }

        .header-left {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            position: absolute;
            left: 10px;
            margin-top: 40px;
            transition: margin-left 0.3s ease;
        }

        .header-left.shift {
            margin-left: 250px;
        }

        .header-right {
            font-size: 1.5rem;
            color: black;
            font-weight: bold;
            text-align: right;
            position: absolute;
            right: 20px;
            margin-top: 50px;
        }

        .stats-boxes {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-top: 160px;
        }

        .stats-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 20px;
            width: calc(32% - 10px);
            height: 180px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .stats-box i {
            color: #007bff;
            font-size: 3rem;
        }

        .stats-box span {
            font-size: 1.5rem;
            color: #333;
            text-align: center;
            font-weight: bold;
        }

        .stats-boxes .stats-box:nth-child(n+4) {
            margin-top: 10px; /* Slightly raise the last three boxes */
        }

        .total-earnings-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .total-earnings {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 20px;
            width: 100%;
            max-width: 600px;
            height: 180px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .total-earnings:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .total-earnings i {
            color: #28a745;
            font-size: 3rem;
            margin-right: 20px;
        }

        .total-earnings span {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
        }

        .toggle-btn {
            font-size: 2rem;
            color: #343a40;
            position: absolute;
            top: 100px;
            left: 20px;
            cursor: pointer;
        }

        .manage-users-container {
            text-align: center; 
            margin-top: 50px; /* Adjusted margin */
        }
    </style>
</head>

<body>
    <i class="fas fa-home toggle-btn" onclick="toggleSidebar()"></i>
    <div class="sidebar" id="sidebar">
        <i class="fas fa-times close-btn" onclick="closeSidebar()"></i>
        <div class="logo"> <i class="fas fa-user-shield"></i> <!-- Updated to user-shield icon -->
            admin</div>
        <ul>
            <li><a href="admin index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-boxes"></i> Products</a></li>
            <li><a href="orders.php"><i class="fas fa-clipboard-list"></i> Orders</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
        </ul>
    </div>
    <div class="content" id="content">
        <div class="header">
            <div class="header-left">Admin Dashboard</div>
            <div class="header-right">
                Welcome, <a href="login.php" style="color: black; text-decoration: none; font-weight: bold;">admin</a>
            </div>
        </div>

        <div class="container manage-users-container">
            <h1> Manage User</h1>

            <?php
            // Check if there are any users
            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";

                // Loop through each user and display their info in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . ucfirst($row['role']) . "</td>
                            <td>
                                <a href='view_user.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>View</a>
                                <a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                <a href='delete_user.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</a>
                            </td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No users found.</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>

    <script>
        // JavaScript for toggling sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('show');
            content.classList.toggle('shift');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.remove('show');
            content.classList.remove('shift');
        }
    </script>
</body>

</html>
