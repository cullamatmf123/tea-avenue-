<?php
// Start session and check if the user is an admin
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login page if not admin
    exit;
}

include('db.php'); // Include your database connection file

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Handle potential error in query execution
if (!$result) {
    echo "Error fetching products: " . $conn->error;
    exit;
}

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: products.php"); // Redirect to products list after deletion
        exit;
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Tea Shop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add your custom styles here */
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
            transition: left 0.3s ease;
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
        .toggle-btn {
            font-size: 2rem;
            color: #343a40;
            position: absolute;
            top: 100px;
            left: 20px;
            cursor: pointer;
        }
        .product-table {
            margin-top: 0; /* Set margin-top to 0 to remove extra space between heading and table */
            max-width: 90%;
            text-align: center;
        }
        .product-table th,
        .product-table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-container {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .manage-users-heading {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin: 0 0 10px; /* Removed top margin and added bottom margin */
            color: #333;
        }
    </style>
</head>
<body>
    <i class="fas fa-home toggle-btn" onclick="toggleSidebar()"></i>
    <div class="sidebar" id="sidebar">
        <i class="fas fa-times close-btn" onclick="closeSidebar()"></i>
        <div class="logo">
            <i class="fas fa-user-shield"></i> Admin
        </div>
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

        <div class="container mt-5">
            <div class="manage-users-heading">Manage Products</div>
            <!-- Add Product Button -->
            <div class="d-flex justify-content-between mb-3">
                <a href="add_product.php" class="btn btn-success">Add New Product</a>
            </div>
            <div class="table-container product-table">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Rating</th>
                            <th>Total Ratings</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM products";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td><img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" width="70" height="70"></td>';
                                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                echo '<td>' . number_format($row['price'], 2) . '</td>';
                                echo '<td>' . number_format($row['rating'], 1) . '</td>';
                                echo '<td>' . $row['total_ratings'] . '</td>';
                                echo '<td>';
                                echo '<a href="edit_product.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit</a> ';
                                echo '<a href="products.php?delete_id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7">No products available.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            var headerLeft = document.querySelector('.header-left');
            sidebar.classList.toggle('show');
            content.classList.toggle('shift');
            headerLeft.classList.toggle('shift');
        }

        function closeSidebar() {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            var headerLeft = document.querySelector('.header-left');
            sidebar.classList.remove('show');
            content.classList.remove('shift');
            headerLeft.classList.remove('shift');
        }
    </script>
</body>
</html>
