<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "milk_tea_shop");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productId'], $data['rating'])) {
    $productId = (int)$data['productId'];
    $rating = (int)$data['rating'];

    $sql = "UPDATE products SET 
            rating = (rating * total_ratings + $rating) / (total_ratings + 1),
            total_ratings = total_ratings + 1
            WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

$conn->close();
?>
