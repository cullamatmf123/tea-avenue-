<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "milk_tea_shop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details if an ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Fetch the product details
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid product ID.";
    exit();
}

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {
    $new_rating = $_POST['rating'];
    
    // Fetch current total ratings, current rating, and rating count
    $query = "SELECT rating, rating_count, total_ratings FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($current_rating, $rating_count, $total_ratings);
    $stmt->fetch();

    // Calculate the new total ratings and new average rating
    $new_total_ratings = $total_ratings + $new_rating;
    $new_avg_rating = $new_total_ratings / ($rating_count + 1);
    
    // Update the rating, total ratings, and rating count in the database
    $update_rating = "UPDATE products SET rating = ?, total_ratings = ?, rating_count = rating_count + 1 WHERE id = ?";
    $stmt = $conn->prepare($update_rating);
    $stmt->bind_param("dii", $new_avg_rating, $new_total_ratings, $product_id);
    $stmt->execute();
    
    // Redirect back to the product page after submission
    header("Location: product_details.php?id=$product_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General body styling */
        body {
            background-color: #f4f7fc;
            font-family: Arial, sans-serif;
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center */
            margin: 0;
        }

        /* Product details container styling */
        .product-details {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 700px;
            width: 100%;
        }

        /* Header and content styling */
        .product-details h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        .product-details img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .product-details p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 15px;
        }

        /* Rating stars styling */
        .rating-stars {
            font-size: 1.5rem;
            color: #ffd700;
            margin-top: 10px;
        }

        .rating-stars span {
            cursor: pointer;
        }

        .rating-stars .gray {
            color: #ccc;
        }

        .rating-stars .gold {
            color: #ffd700;
        }

        /* Rating form container styling to center it */
        .form-container {
            margin-top: 30px;
            text-align: center; /* Center form elements */
        }

        /* Centering the select dropdown */
        .form-container select,
        .form-container button {
            width: 60%;
            margin: 10px auto; /* This will center the form elements */
        }

        /* Button styling */
        .btn-submit {
            padding: 12px;
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            display: block; /* Ensure the button stays on a new line */
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Back to Home Text Styling */
        .back-to-home {
            font-size: 1.2rem;
            color: #007bff;
            margin-top: 20px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-to-home:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #444;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- Product Details Section -->
    <section class="product-details">
        <div class="container">
            <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <?php
                // Define the image path and check if the file exists
                $image_path = 'images/' . htmlspecialchars($product['image']);
                if (!file_exists($image_path)) {
                    $image_path = 'images/default.jpg'; // Default image if the product image is missing
                }
            ?>
            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid">
            <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <p><strong>Rating:</strong> <?php echo number_format($product['rating'], 1); ?> (<?php echo $product['rating_count']; ?> votes)</p>

            <!-- Rating Stars -->
            <div class="rating-stars">
                <?php
                    $current_rating = isset($product['rating']) ? $product['rating'] : 0;
                    for ($i = 1; $i <= 5; $i++) {
                        $star_class = ($i <= $current_rating) ? 'gold' : 'gray';
                        echo "<span class='star' onclick='setRating($i, {$product['id']})' style='color:$star_class'>&#9733;</span>";
                    }
                ?>
            </div>

            <!-- Rating Form -->
            <form method="POST" action="" class="form-container">
                <div class="mb-3">
                    <label for="rating" class="form-label">Submit your rating:</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="" disabled selected>Select Rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Submit Rating</button>
            </form>

            <!-- Back to Home Text (centered) -->
            <a href="index.php" class="back-to-home">Back to Home</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Tea Avenue. All rights reserved.</p>
    </footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
