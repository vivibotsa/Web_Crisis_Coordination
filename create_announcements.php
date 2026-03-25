<?php
session_start();
include 'database.php'; // Σύνδεση με τη βάση δεδομένων

// Παίρνουμε τα δεδομένα του request
$data = json_decode(file_get_contents('php://input'), true);
$task_id = $data['task_id'];

// Αλλαγή κατάστασης του task σε "completed"
$query = "UPDATE requests_offers SET status = 'completed' WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $task_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Σφάλμα κατά την ολοκλήρωση του task']);
}

$stmt->close();
?>
