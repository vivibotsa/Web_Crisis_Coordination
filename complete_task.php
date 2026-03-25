<?php
// cargo_management.php

include 'database.php'; // Σύνδεση με τη βάση δεδομένων
session_start();

if (!isset($_SESSION['id'])) {
    die('Δεν είστε συνδεδεμένος. Παρακαλώ συνδεθείτε.');
}

// Παίρνουμε τα στοιχεία του οχήματος
$vehicle_query = "SELECT * FROM vehicles WHERE rescuer_id = ?";
$stmt = $conn->prepare($vehicle_query);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$vehicle_result = $stmt->get_result();

// Έλεγχος αν βρέθηκε όχημα
if ($vehicle_result->num_rows > 0) {
    $vehicle = $vehicle_result->fetch_assoc();
} else {
    die('Δεν βρέθηκε όχημα για τον χρήστη.');
}

// Αποθηκεύουμε το vehicle_id στη συνεδρία
$_SESSION['vehicle_id'] = $vehicle['id'];

// Παίρνουμε τη θέση της βάσης
$base_query = "SELECT * FROM base_location LIMIT 1";
$base_result = mysqli_query($conn, $base_query);
$base = mysqli_fetch_assoc($base_result);

// Συνάρτηση για υπολογισμό απόστασης (haversine formula)
function haversine($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371000; // Ακτίνα της γης σε μέτρα
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earth_radius * $c;
    return $distance;
}

// Υπολογίζουμε την απόσταση του οχήματος από τη βάση
$distance = haversine($vehicle['lat'], $vehicle['lng'], $base['lat'], $base['lng']);

// Αν η απόσταση είναι μικρότερη από 100 μέτρα, επιτρέπουμε φόρτωση/εκφόρτωση
$can_load = $distance <= 100;

// Παίρνουμε τα προϊόντα από την αποθήκη της βάσης
$products_query = "SELECT * FROM products WHERE quantity > 0 ORDER BY id ASC";
$products_result = mysqli_query($conn, $products_query);

// Παίρνουμε τα είδη που έχει φορτώσει το όχημα (JOIN με products για να πάρουμε το όνομα του προϊόντος)
$vehicle_items_query = "
    SELECT vc.quantity, p.name 
    FROM vehicle_cargo vc 
    JOIN products p ON vc.product_id = p.id 
    WHERE vc.vehicle_id = ?";
$stmt = $conn->prepare($vehicle_items_query);
$stmt->bind_param("i", $vehicle['id']);
$stmt->execute();
$vehicle_items_result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Διαχείριση Φορτίου</title>
</head>
<body>
    <h1>Διαχείριση Φορτίου</h1>

    <h2>Είδη στο Όχημα</h2>
    <ul>
        <?php while ($item = $vehicle_items_result->fetch_assoc()): ?>
            <li><?= $item['name'] ?> - Ποσότητα: <?= $item['quantity'] ?></li>
        <?php endwhile; ?>
    </ul>

    <?php if ($can_load): ?>
        <h2>Είδη στην Αποθήκη Βάσης</h2>
        <form action="load_items.php" method="POST">
            <!-- Κρυφό πεδίο για το vehicle_id -->
            <input type="hidden" name="vehicle_id" value="<?= $vehicle['id'] ?>" /> <!-- Προσθέτουμε το vehicle_id στη φόρμα -->
            <ul>
                <!-- Προϊόντα από τη βάση δεδομένων -->
                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                    <li>
                        <?= $product['name'] ?> - Διαθέσιμη Ποσότητα: <?= $product['quantity'] ?>
                        <input type="number" name="quantity[<?= $product['id'] ?>]" min="0" max="<?= $product['quantity'] ?>" />
                    </li>
                <?php endwhile; ?>
            </ul>
            <ul id="products-list">
                <!-- Τα προϊόντα από το JSON θα φορτωθούν εδώ μέσω AJAX -->
            </ul>
            <button type="submit">Φόρτωση</button>
        </form>

        <form action="unload_items.php" method="POST">
            <button type="submit">Εκφόρτωση Όλων των Ειδών</button>
        </form>
    <?php else: ?>
        <p>Πρέπει να είστε εντός 100 μέτρων από τη βάση για να φορτώσετε ή να εκφορτώσετε είδη.</p>
    <?php endif; ?>

    <script>
        // Φόρτωση προϊόντων από το JSON μέσω AJAX
        fetch('export.json')
            .then(response => response.json())
            .then(data => {
                const jsonProducts = data.items;
                const productsList = document.getElementById('products-list');
                jsonProducts.forEach(product => {
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `${product.name} - Κατηγορία: ${product.category}
                        <input type="number" name="quantity[${product.id}]" min="0" />`;
                    productsList.appendChild(listItem);
                });
            })
            .catch(error => console.error('Error:', error));
    </script>
</body>
</html>
