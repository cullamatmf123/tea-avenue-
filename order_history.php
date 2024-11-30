<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Get the logged-in user's details
$username = $_SESSION['username'];

// Fetch the user's order history
$query = "SELECT * FROM orders WHERE username = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Tea Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: white;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Navigation Styles */
        nav {
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: white;
            border: none;
            box-shadow: none;
        }

        nav h1 {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
            color: #444;
            position: relative;
        }

        /* Custom Back Button */
        .back-icon {
            position: absolute;
            bottom: -90px; /* Adjusted position */
            left: 10px;
            width: 60px; /* Circular button */
            height: 60px;
            background: linear-gradient(145deg, #6c63ff, #5a54e1); /* Gradient background */
            border-radius: 50%; /* Circle shape */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem; /* Larger icon size */
            color: white;
            text-decoration: none;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: all 0.3s ease-in-out; /* Smooth transition */
        }

        .back-icon:hover {
            transform: scale(1.1); /* Slightly grow the button */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2); /* Darker shadow */
            background: linear-gradient(145deg, #4f4aef, #3d39cc); /* Darker gradient on hover */
        }

        nav a {
            text-decoration: none;
            color: #444;
            font-weight: bold;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #888;
        }

        .cart-btn {
            padding: 8px 15px;
            border-radius: 20px;
            background-color: #e0e0e0;
            color: #333;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s;
        }

        .cart-btn:hover {
            background-color: #d0d0d0;
        }

        .table-responsive {
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav>
        <h1>
            Tea Avenue
            <!-- Back Button Positioned at Bottom Left -->
            <a href="cart.php" class="back-icon">
                <i class="bi bi-arrow-left"></i> <!-- Custom Back Icon -->
            </a>
        </h1>
        <div>
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="cart.php" class="cart-btn">Cart</a>
            <?php if (isset($_SESSION['username'])): ?>
                <a href="logout.php" class="ms-3">Hello, <?php echo $_SESSION['username']; ?></a>
            <?php else: ?>
                <a href="login.php">Login</a> / <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Order History</h1>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td>₱<?php echo number_format($row['total_price'], 2); ?></td>
                                <td><?php echo date('F j, Y, g:i a', strtotime($row['order_date'])); ?></td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
