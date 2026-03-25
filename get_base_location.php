<?php
include("database.php");

// Ανάκτηση όλων των προϊόντων
$result = $conn->query("SELECT id, name FROM products");
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>