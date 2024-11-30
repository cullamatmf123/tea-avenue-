<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Set the admin's username from session to display
$admin_username = $_SESSION['username'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "milk_tea_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Queries for stats
$sql_users = "SELECT COUNT(*) as total_users FROM login WHERE role = 'user'";
$result_users = $conn->query($sql_users);
$total_users = ($result_users->num_rows > 0) ? $result_users->fetch_assoc()['total_users'] : 0;

$sql_products = "SELECT COUNT(*) as total_products FROM products";
$result_products = $conn->query($sql_products);
$total_products = ($result_products->num_rows > 0) ? $result_products->fetch_assoc()['total_products'] : 0;

$sql_orders = "SELECT COUNT(*) as total_orders FROM orders";
$result_orders = $conn->query($sql_orders);
$total_orders = ($result_orders->num_rows > 0) ? $result_orders->fetch_assoc()['total_orders'] : 0;

$sql_pending = "SELECT COUNT(*) as total_pending_orders FROM orders WHERE status = 'Pending'";
$result_pending = $conn->query($sql_pending);
$total_pending_orders = ($result_pending->num_rows > 0) ? $result_pending->fetch_assoc()['total_pending_orders'] : 0;

$sql_completed = "SELECT COUNT(*) as total_completed_orders FROM orders WHERE status = 'Completed'";
$result_completed = $conn->query($sql_completed);
$total_completed_orders = ($result_completed->num_rows > 0) ? $result_completed->fetch_assoc()['total_completed_orders'] : 0;

$sql_cancelled = "SELECT COUNT(*) as total_cancelled_orders FROM orders WHERE status = 'Cancelled'";
$result_cancelled = $conn->query($sql_cancelled);
$total_cancelled_orders = ($result_cancelled->num_rows > 0) ? $result_cancelled->fetch_assoc()['total_cancelled_orders'] : 0;

$sql_earnings = "SELECT SUM(total_price) as total_earnings FROM orders WHERE status = 'Completed'";
$result_earnings = $conn->query($sql_earnings);
$total_earnings = ($result_earnings->num_rows > 0) ? $result_earnings->fetch_assoc()['total_earnings'] : 0;

$conn->close();
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

        @keyframes bgAnimation {
            0% {
                background-color: #f1f1f1;
            }

            100% {
                background-color: #e0e0e0;
            }
        }
    </style>
</head>

<body>
    <i class="fas fa-home toggle-btn" onclick="toggleSidebar()"></i>
    <div class="sidebar" id="sidebar">
        <i class="fas fa-times close-btn" onclick="closeSidebar()"></i>
        <div class="logo"> <i class="fas fa-user-shield"></i> <!-- Updated to user-shield icon -->

            <?php echo $admin_username; ?></a></div>
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
                Welcome, <a href="login.php" style="color: black; text-decoration: none; font-weight: bold;"><?php echo $admin_username; ?></a>
            </div>
        </div>

        <div class="stats-boxes">
            <div class="stats-box">
                <i class="fas fa-users"></i>
                <span><?php echo $total_users; ?> Users</span>
            </div>
            <div class="stats-box">
                <i class="fas fa-cogs"></i>
                <span><?php echo $total_products; ?> Products</span>
            </div>
            <div class="stats-box">
                <i class="fas fa-clipboard-list"></i>
                <span><?php echo $total_orders; ?> Orders</span>
            </div>
            <div class="stats-box">
                <i class="fas fa-hourglass-half"></i>
                <span><?php echo $total_pending_orders; ?> Pending</span>
            </div>
            <div class="stats-box">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $total_completed_orders; ?> Completed</span>
            </div>
            <div class="stats-box">
                <i class="fas fa-times-circle"></i>
                <span><?php echo $total_cancelled_orders; ?> Cancelled</span>
            </div>
        </div>

        <div class="total-earnings-container">
            <div class="total-earnings">
                <i class="fas fa-dollar-sign"></i>
                <span>Total Earnings: ₱<?php echo number_format($total_earnings, 2); ?></span>
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
            sidebar.classList.remove('show');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
