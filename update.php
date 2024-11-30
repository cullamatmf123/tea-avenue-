<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
  

    $sql = 'UPDATE crud SET description = :description, quantity = :quantity WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['description' => $description, 'quantity' => $quantity, 'id' => $id]);

    header('Location: index.php');
    exit;
}

$sql = 'SELECT * FROM crud WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <form method="post">
        <label>Description <input type="text" name="description" value="<?php echo htmlspecialchars($user['description']); ?>" required></label><br>
        <label>Quantity <input type="text" name="quantity" value="<?php echo htmlspecialchars($user['quantity']); ?>" required></label><br>
        <input type="submit" value="Update">
    </form>
    <a href="index.php">Back to list</a>
</body>
</html>
