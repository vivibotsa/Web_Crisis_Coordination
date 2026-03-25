<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

$user_id = $_SESSION['id'];
$offers_query = "SELECT * FROM announcement_items WHERE register_polites_id = ?";
$stmt = $conn->prepare($offers_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$offers_result = $stmt->get_result();

$offers = [];
while ($offer_row = $offers_result->fetch_assoc()) {
    $offers[] = $offer_row;
}

header('Content-Type: application/json');
echo json_encode($offers);
