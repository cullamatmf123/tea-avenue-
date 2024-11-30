<?php
session_start();

// Initialize cart if not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "<h1>Your Cart is Empty</h1>";
    echo "<a href='menu.php'>Go to Menu</a>";
    exit;
}

// Handle quantity updates or item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_name'] === $_POST['product_name']) {
                $item['quantity'] = intval($_POST['quantity']);
                if ($item['quantity'] <= 0) {
                    // Remove item if quantity is 0 or less
                    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cart_item) use ($item) {
                        return $cart_item['product_name'] !== $item['product_name'];
                    });
                }
                break;
            }
        }
    }

    if (isset($_POST['remove_item'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) {
            return $item['product_name'] !== $_POST['product_name'];
        });
    }
    header("Location: cart.php");
    exit;
}
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

        /* Welcome Section */
        .welcome-section {
            text-align: center;
            padding: 100px 20px;
            margin-top: 20px;
            background-color: white;
        }

        .welcome-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #444;
        }

        .welcome-section p {
            font-size: 1.2rem;
            color: #555;
        }

        .cta-btn {
            padding: 12px 20px;
            background: linear-gradient(to right, #6c63ff, #888888);
            color: #fff;
            border: none;
            border-radius: 30px;
            margin-top: 20px;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .cta-btn:hover {
            background: linear-gradient(to right, #5a54e1, #555555);
        }

        /* Footer */
        footer {
            background-color: #444;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Next Icon Button */
        .next-icon-btn {
            position: absolute;
            top: 100px;
            right: 20px;
            background-color: #6c63ff;
            color: white;
            border-radius: 50%;
            padding: 15px;
            font-size: 24px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .next-icon-btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            background-color: #5a54e1;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav>
        <h1>Tea Avenue</h1>
        <div>
            <a href="index.php" class="home-btn">Home</a>
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
        <h1>Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                foreach ($_SESSION['cart'] as $item):
                    if (isset($item['product_name'], $item['price'], $item['quantity'])) {
                        $total = $item['price'] * $item['quantity'];
                        $grand_total += $total;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['product_name']); ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" style="width: 70px;">
                            <button type="submit" name="update_quantity" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>₱<?php echo number_format($total, 2); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['product_name']); ?>">
                            <button type="submit" name="remove_item" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php
                    }
                endforeach;
                ?>
            </tbody>
        </table>
        <h3>Total: ₱<?php echo number_format($grand_total, 2); ?></h3>
        <a href="menu.php" class="btn btn-secondary">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-success">Checkout</a>
    </div>

    <!-- Next Icon Button -->
    <a href="checkout.php" class="next-icon-btn">
        <i class="bi bi-arrow-right"></i>
    </a>

</body>

</html>
