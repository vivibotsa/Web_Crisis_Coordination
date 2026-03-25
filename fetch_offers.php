<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'database.php'; 

$query = "SELECT * FROM announcements";
$result = $conn->query($query);

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}

header('Content-Type: application/json');
echo json_encode($announcements);