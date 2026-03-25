<?php
include 'database.php';

header('Content-Type: application/json');

// SQL για να πάρετε τη τοποθεσία της βάσης
$sql = "SELECT lat, lng FROM base_location WHERE id = 1";
$result = $conn->query($sql);

if ($result) {
    $base = $result->fetch_assoc();
    echo json_encode(['base' => $base]);
} else {
    echo json_encode(['error' => 'Error fetching base location']);
}

$conn->close();
?>
