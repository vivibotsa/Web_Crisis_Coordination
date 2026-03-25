<?php
session_start();
header('Content-Type: application/json');

// Σύνδεση με τη βάση δεδομένων
include 'database.php';

// Έλεγχος αν υπάρχει το rescuer_id στο αίτημα
if (!isset($_POST['rescuer_id'])) {
    echo json_encode(['error' => 'Rescuer ID is missing']);
    exit();
}

$rescuer_id = $_SESSION['id'];  // Παίρνουμε το ID από το session
// Προετοιμασία του query για ανάκτηση των tasks
$query = "SELECT t.id, t.item, t.quantity, t.date_created, p.username, p.phone 
          FROM tasks t
          JOIN users p ON t.user_id = p.id
          WHERE t.rescuer_id = ? AND t.status = 'accepted'";

$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(['error' => 'Database query failed']);
    exit();
}

$stmt->bind_param("i", $rescuer_id);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];

// Ανάκτηση των αποτελεσμάτων
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Επιστροφή δεδομένων σε JSON μορφή
echo json_encode($tasks);

// Κλείσιμο του statement και της σύνδεσης
$stmt->close();
$conn->close();
?>
