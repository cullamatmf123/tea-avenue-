<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Get the logged-in user's details
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Assuming you store this in the session during login

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php?error=empty_cart");
    exit();
}

// Calculate the total price
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Insert the order into the `orders` table
$query = "INSERT INTO orders (username, user_id, total_price, order_date, status) VALUES (?, ?, ?, NOW(), 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("sid", $username, $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id; // Get the last inserted order ID

// Create a table for order items if not exists
$query_create_order_items = "
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
)";
$conn->query($query_create_order_items);

// Insert order items into the `order_items` table
$query_items = "INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)";
$stmt_items = $conn->prepare($query_items);

foreach ($_SESSION['cart'] as $item) {
    $stmt_items->bind_param("isid", $order_id, $item['product_name'], $item['quantity'], $item['price']);
    $stmt_items->execute();
}

// Clear the cart session
unset($_SESSION['cart']);

// Redirect to the order history page
header("Location: order_history.php?success=checkout_complete");
exit();
?>
