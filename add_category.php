<?php
include 'database.php';
session_start(); 

// Παίρνουμε το request_id από το POST αίτημα
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['request_id'])) {
    echo json_encode(['success' => false, 'error' => 'Request ID not received']);
    exit();
}

$request_id = $data['request_id'];

// Παίρνουμε το όνομα χρήστη του συνδεδεμένου διασώστη
if (isset($_SESSION['username'])) {
    $rescuer_username = $_SESSION['username'];
} else {
    echo json_encode(['success' => false, 'error' => 'No rescuer username in session']);
    exit();
}

// Βρίσκουμε το vehicle_id και το rescuer_id του διασώστη από το όνομα χρήστη
$query_vehicle = "SELECT id, rescuer_id FROM vehicles WHERE rescuer_id = (SELECT id FROM rescuers WHERE username = ?)";
$stmt_vehicle = $conn->prepare($query_vehicle);
$stmt_vehicle->bind_param("s", $rescuer_username);
$stmt_vehicle->execute();
$result_vehicle = $stmt_vehicle->get_result();

if ($result_vehicle->num_rows > 0) {
    $vehicle = $result_vehicle->fetch_assoc();
    $vehicle_id = $vehicle['id'];
    $rescuer_id = $vehicle['rescuer_id'];

    if (!$vehicle_id || !$rescuer_id) {
        echo json_encode(['success' => false, 'error' => 'Vehicle or rescuer not found']);
        exit();
    }

    // Έλεγχος αν το όχημα μπορεί να αναλάβει ακόμα ένα task
    if (canTakeMoreTasks($vehicle_id, $conn)) {
        // Ενημέρωση του αιτήματος με το vehicle_id και rescuer_id
        $query_update = "UPDATE requests_offers 
                         SET vehicle = ?, rescuer_id = ?, status = 'accepted', date_taken = NOW() 
                         WHERE id = ? AND status = 'pending'";
        $stmt_update = $conn->prepare($query_update);
        $stmt_update->bind_param("iii", $vehicle_id, $rescuer_id, $request_id);

        if ($stmt_update->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database update failed']);
        }

        $stmt_update->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Το όχημα έχει ήδη αναλάβει 4 tasks.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Vehicle not found']);
}

$stmt_vehicle->close();
$conn->close();

// Συνάρτηση που ελέγχει πόσα tasks έχει αναλάβει το όχημα
function canTakeMoreTasks($vehicle_id, $conn) {
    $query = "SELECT COUNT(*) as task_count FROM requests_offers WHERE vehicle = ? AND status = 'accepted'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return ($row['task_count'] < 4);
}
