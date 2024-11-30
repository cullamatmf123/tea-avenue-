<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = 'DELETE FROM crud WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

header('Location: index.php');
exit;
?>
