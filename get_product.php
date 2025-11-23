<?php
session_start();
include 'functions/products.php';

if (!isset($_GET['pcode'])) {
    echo json_encode(['error' => 'Product code missing']);
    exit;
}

$pcode = $_GET['pcode'];

// Get latest product data
$conn = Connect();
$query = "SELECT * FROM product WHERE p_code = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $pcode);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$product) {
    echo json_encode(['error' => 'Product not found']);
    exit;
}

// Return JSON
echo json_encode([
    'desc' => $product['p_descript'],
    'price' => $product['p_price'],
    'stocks' => $product['p_qoh']
]);