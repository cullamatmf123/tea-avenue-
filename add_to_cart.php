<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize the cart session if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $product_name = $_POST['product_name'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    // Validate inputs
    if ($quantity < 1) {
        header("Location: menu.php?error=invalid_quantity");
        exit;
    }

    // Check if the product already exists in the cart
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_name'] === $product_name) {
            $item['quantity'] += $quantity; // Update the quantity
            $product_exists = true;
            break;
        }
    }

    // If the product is not in the cart, add it
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'product_name' => $product_name,
            'price' => $price,
            'quantity' => $quantity,
        ];
    }

    // Redirect back to the menu
    header("Location: menu.php?success=added_to_cart");
    exit;
}
?>
