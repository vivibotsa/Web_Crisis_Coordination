<?php
include 'database.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Παίρνουμε το username του διασώστη από το POST αίτημα
$data = json_decode(file_get_contents('php://input'), true);
$rescuer_username = $data['rescuer_username'];

// Αρχικοποίηση των δεδομένων που θα επιστραφούν
$response = [
    'vehicles' => [],
    'requests' => [],
    'offers' => []
];

$requests_query = "
    SELECT GROUP_CONCAT(ro.id SEPARATOR ', ') as ids,
           ro.username, 
           rp.latitude as lat, 
           rp.longitude as lng, 
           GROUP_CONCAT(ro.item SEPARATOR ', ') as items, 
           GROUP_CONCAT(ro.quantity SEPARATOR ', ') as quantities, 
           GROUP_CONCAT(ro.date_created SEPARATOR ', ') as dates, 
           GROUP_CONCAT(ro.status SEPARATOR ', ') as statuses, 
           GROUP_CONCAT(ro.phone SEPARATOR ', ') as phones,
           GROUP_CONCAT(ro.vehicle SEPARATOR ', ') as vehicles,
           v.username as vehicle_username, 
           r.username as rescuer_username
    FROM requests_offers ro
    JOIN register_polites rp ON ro.username = rp.username
    LEFT JOIN vehicles v ON ro.vehicle = v.id
    LEFT JOIN rescuers r ON ro.rescuer_id = r.id
    WHERE (ro.status = 'pending' OR (ro.status = 'accepted' AND r.username = ?))  -- Προσθήκη της συνθήκης για τον διασώστη
    AND ro.type = 'request'
    GROUP BY ro.username, rp.latitude, rp.longitude
";

// Προσθήκη του rescuer_username στη μέθοδο bind_param για το requests_query
$requests_stmt = $conn->prepare($requests_query);
$requests_stmt->bind_param("s", $rescuer_username);  // Δέσμευση της παραμέτρου
$requests_stmt->execute();
$requests_result = $requests_stmt->get_result();


while ($row = $requests_result->fetch_assoc()) {
    $response['requests'][] = $row;
}

$requests_stmt->close();

// Φόρτωση των προσφορών που είναι είτε Pending είτε έχουν αναληφθεί από τον συγκεκριμένο διασώστη (Accepted)
$offers_query = "
    SELECT GROUP_CONCAT(ro.id SEPARATOR ', ') as ids,  
           ro.username, 
           rp.latitude as lat, 
           rp.longitude as lng, 
           GROUP_CONCAT(ro.item SEPARATOR ', ') as items, 
           GROUP_CONCAT(ro.quantity SEPARATOR ', ') as quantities, 
           GROUP_CONCAT(ro.date_created SEPARATOR ', ') as dates, 
           GROUP_CONCAT(ro.status SEPARATOR ', ') as statuses,  
           GROUP_CONCAT(ro.phone SEPARATOR ', ') as phones,
           GROUP_CONCAT(ro.vehicle SEPARATOR ', ') as vehicles,
           v.username as vehicle_username, 
           r.username as rescuer_username
    FROM requests_offers ro
    JOIN register_polites rp ON ro.username = rp.username
    LEFT JOIN vehicles v ON ro.vehicle = v.id
    LEFT JOIN rescuers r ON ro.rescuer_id = r.id
    WHERE (ro.status = 'pending' OR (ro.status = 'accepted' AND r.username = ?))
    AND ro.type = 'offer'
    GROUP BY ro.username, rp.latitude, rp.longitude
";

$offers_stmt = $conn->prepare($offers_query);
$offers_stmt->bind_param("s", $rescuer_username);
$offers_stmt->execute();
$offers_result = $offers_stmt->get_result();

while ($row = $offers_result->fetch_assoc()) {
    $response['offers'][] = $row;
}

$offers_stmt->close();

// Φόρτωση των δεδομένων για το όχημα του διασώστη
$vehicles_query = "
    SELECT v.id as vehicle_id, v.username, v.lat, v.lng, v.load, v.status, v.tasks, r.username as rescuer_username
    FROM vehicles v
    JOIN rescuers r ON v.rescuer_id = r.id
    WHERE r.username = ?
";
$vehicles_stmt = $conn->prepare($vehicles_query);
$vehicles_stmt->bind_param("s", $rescuer_username);
$vehicles_stmt->execute();
$vehicles_result = $vehicles_stmt->get_result();

while ($row = $vehicles_result->fetch_assoc()) {
    $response['vehicles'][] = $row;
}

$vehicles_stmt->close();



// Επιστροφή των δεδομένων σε μορφή JSON
echo json_encode($response, JSON_PRETTY_PRINT);
$conn->close();
?>
