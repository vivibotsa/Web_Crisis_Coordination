updatevehicleposition:
<?php
header('Content-Type: application/json');

// Λήψη και έλεγχος δεδομένων
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id']) || !isset($data['lat']) || !isset($data['lng'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit();
}

$vehicle_id = $data['id'];
$lat = $data['lat'];
$lng = $data['lng'];

// Ενημέρωση στη βάση δεδομένων
require 'database.php'; // Υποθέτοντας ότι αυτό είναι το αρχείο σύνδεσης με τη βάση
$stmt = $conn->prepare("UPDATE vehicles SET lat = ?, lng = ? WHERE id = ?");
$stmt->bind_param("ddi", $lat, $lng, $vehicle_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update']);
}

$stmt->close();
$conn->close();
?>