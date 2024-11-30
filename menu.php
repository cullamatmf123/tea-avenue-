<?php
// Start the session
session_start();

// Include the database connection
include('db.php');

// Fetch product data from the database
$sql = "SELECT * FROM products"; // Query to fetch all products
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Tea Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .menu-btn {
            padding: 8px 15px;
            border-radius: 20px;
            background-color: #e0e0e0;
            color: #333;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s;
        }

        .menu-btn:hover {
            background-color: #d0d0d0;
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

        /* Menu Section */
        .menu-section {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
        }

        .menu-section h2 {
            font-size: 2.5rem;
            margin-bottom: 40px;
            color: #444;
        }

        .menu-section .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            width: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            background-color: #fff;
            text-align: center;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #6c63ff;
            border: none;
            padding: 8px 20px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #5a54e1;
        }

        .mb-3 label {
            font-weight: normal;
        }

        footer {
            background-color: #444;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
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
            <a href="cart.php">Cart</a>
            <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                <a href="logout.php" class="ms-3">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            <?php else: ?>
                <a href="login.php" class="ms-3">Login</a> / <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Menu Section -->
    <section class="menu-section" style="background-color: white;">
        <h2>Our Menu</h2>
        <div class="container">
            <div class="row">
                <?php
                // Check if there are products in the database
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each product and display it
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['product_name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                    <form method="post" action="add_to_cart.php">
                                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity:</label>
                                            <input type="number" name="quantity" value="1" min="1" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">₱<?php echo number_format($row['price'], 2); ?></button>
                                    </form>
                                    <!-- Rating Display -->
                                    <div class="mt-3">
                                        <strong>Rating:</strong> <?php echo number_format($row['rating'], 1); ?> (<?php echo $row['total_ratings']; ?> reviews)
                                    </div>
                                    <!-- Product Description -->
                                    <p class="mt-2 text-muted"><?php echo $row['description']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No products found.</p>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>

</body>

</html>
