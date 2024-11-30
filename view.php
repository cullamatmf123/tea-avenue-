<?php
session_start();
include('db.php'); // Include your database connection file

// Check if product id is provided in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Get product details
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found!";
        exit;
    }

    // Handle rating submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {
        $new_rating = $_POST['rating'];
        $current_ratings = $product['total_ratings'];
        $current_score = $product['rating'];

        // Update the average rating (simplified calculation)
        $updated_score = (($current_score * $current_ratings) + $new_rating) / ($current_ratings + 1);
        $updated_ratings = $current_ratings + 1;

        // Update the product in the database with new rating
        $update_sql = "UPDATE products SET rating = '$updated_score', total_ratings = '$updated_ratings' WHERE id = $product_id";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: view.php?id=" . $product_id); // Reload the page after rating
            exit;
        } else {
            echo "Error updating rating: " . $conn->error;
        }
    }
} else {
    echo "Product ID not provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Clean and modern product page layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }
        .product-image {
            flex: 1;
            max-width: 400px;
            text-align: center;
        }
        .product-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .product-details {
            flex: 1;
            max-width: 500px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .product-price {
            font-size: 1.5rem;
            color: #28a745;
            margin-top: 10px;
        }
        .product-rating {
            margin-top: 10px;
        }
        .product-rating span {
            font-size: 1.2rem;
            color: #ffc107;
        }
        .product-description {
            margin-top: 20px;
            font-size: 1rem;
            color: #555;
        }
        .back-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
        .rating-form {
            margin-top: 20px;
        }
        .rating-form input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-container">
            <!-- Product Image -->
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>
            
            <!-- Product Details -->
            <div class="product-details">
                <div class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></div>
                <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>

                <!-- Product Rating -->
                <div class="product-rating">
                    <strong>Rating:</strong> 
                    <span><?php echo number_format($product['rating'], 1); ?> / 5</span>
                    <br>
                    <small>(<?php echo $product['total_ratings']; ?> ratings)</small>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <strong>Description:</strong>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                </div>

                <!-- Rating Form -->
                <form class="rating-form" method="post">
                    <div>
                        <label for="rating">Rate this product:</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit Rating</button>
                </form>

                <!-- Back to Home Button -->
                <a href="index.php" class="back-btn">Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
