<?php
session_start();
if (!isset($_GET['order_id'])) {
    header('Location: menu.php');
    exit;
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Thank You for Your Order!</h1>
        <p class="text-center">Your order ID is <strong><?php echo $order_id; ?></strong>.</p>
        <div class="text-center">
            <a href="menu.php" class="btn btn-primary">Back to Menu</a>
        </div>
    </div>
</body>
</html>
