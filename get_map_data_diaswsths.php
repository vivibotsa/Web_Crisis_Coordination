<?php
include 'database.php';

header('Content-Type: application/json');

// Αρχικοποίηση των δεδομένων που θα επιστραφούν
$data = [
    'base' => null,
    'vehicles' => [],
    'requests' => [],
    'offers' => [],
    'categories' => [],
    'products' => []
];

// Φόρτωση δεδομένων για τη βάση
$base_query = "SELECT lat, lng FROM base_location WHERE id = 1";
$base_result = $conn->query($base_query);

if ($base_result) {
    $data['base'] = $base_result->fetch_assoc();
} else {
    echo json_encode(['error' => 'Error fetching base location data: ' . $conn->error]);
    exit();
}

// Φόρτωση δεδομένων για τα οχήματα
$vehicles_query = "SELECT username, lat, lng, `load`, status, tasks FROM vehicles";
$vehicles_result = $conn->query($vehicles_query);

if ($vehicles_result) {
    while ($row = $vehicles_result->fetch_assoc()) {
        $data['vehicles'][] = $row;
    }
} else {
    echo json_encode(['error' => 'Error fetching vehicles data: ' . $conn->error]);
    exit();
}

// Φόρτωση δεδομένων για αιτήματα και προσφορές
$requests_query = "
    SELECT ro.id, ro.type, ro.username, rp.latitude as lat, rp.longitude as lng, ro.item, ro.quantity, ro.phone, ro.status, ro.date_created, ro.date_taken, ro.vehicle
    FROM requests_offers ro
    JOIN register_polites rp ON ro.username = rp.username
";
$requests_result = $conn->query($requests_query);

if ($requests_result) {
    while ($row = $requests_result->fetch_assoc()) {
        if ($row['type'] === 'request') {
            $data['requests'][] = $row;
        } elseif ($row['type'] === 'offer') {
            $data['offers'][] = $row;
        }
    }
} else {
    echo json_encode(['error' => 'Error fetching requests and offers data: ' . $conn->error]);
    exit();
}

// Έλεγχος αν υπάρχουν δεδομένα προϊόντων στη βάση δεδομένων
$products_query = "SELECT id FROM products LIMIT 1";
$products_result = $conn->query($products_query);

if ($products_result->num_rows === 0) {
    // Αν δεν υπάρχουν δεδομένα, φορτώστε τα από το αρχείο JSON
    $json_data = file_get_contents('export.json'); // Βεβαιωθείτε ότι το αρχείο υπάρχει και η διαδρομή είναι σωστή
    $json_array = json_decode($json_data, true);

    if ($json_array && isset($json_array['products'])) {
        foreach ($json_array['products'] as $product) {
            $insert_query = "INSERT INTO products (name, category_id, quantity) VALUES ('{$product['name']}', {$product['category_id']}, {$product['quantity']})";
            $conn->query($insert_query);
        }
    } else {
        echo json_encode(['error' => 'Error loading data from JSON file']);
        exit();
    }
}

// Φόρτωση δεδομένων για κατηγορίες και προϊόντα από τη βάση δεδομένων
$categories_query = "SELECT * FROM categories";
$categories_result = $conn->query($categories_query);

if ($categories_result) {
    while ($row = $categories_result->fetch_assoc()) {
        $data['categories'][] = $row;
    }
} else {
    echo json_encode(['error' => 'Error fetching categories data: ' . $conn->error]);
    exit();
}

$products_query = "SELECT * FROM products";
$products_result = $conn->query($products_query);

if ($products_result) {
    while ($row = $products_result->fetch_assoc()) {
        $data['products'][] = $row;
    }
} else {
    echo json_encode(['error' => 'Error fetching products data: ' . $conn->error]);
    exit();
}

echo json_encode($data, JSON_PRETTY_PRINT);
$conn->close();
?>
