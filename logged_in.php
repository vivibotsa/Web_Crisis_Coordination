<?php
include 'database.php';
session_start();

// Ελέγχουμε αν το vehicle_id έχει σταλεί από τη φόρμα
if (!isset($_POST['vehicle_id'])) {
    die('Το vehicle_id δεν έχει οριστεί.');
}

// Παίρνουμε το ID του οχήματος από τη φόρμα
$vehicle_id = $_POST['vehicle_id'];

// Επεξεργαζόμαστε τα προϊόντα που θέλει να φορτώσει ο διασώστης
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        // Ελέγχουμε ότι η ποσότητα είναι έγκυρος θετικός αριθμός
        if (filter_var($quantity, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) !== false) {
            // Μείωση της ποσότητας στην αποθήκη
            $update_stock_query = "UPDATE products SET quantity = quantity - ? WHERE id = ? AND quantity >= ?";
            $stmt = $conn->prepare($update_stock_query);
            if ($stmt) {
                $stmt->bind_param('iii', $quantity, $product_id, $quantity);
                if (!$stmt->execute()) {
                    die('Σφάλμα κατά την ενημέρωση της αποθήκης: ' . $stmt->error);
                }

                // Προσθήκη της ποσότητας στο όχημα
                $add_to_vehicle_query = "INSERT INTO vehicle_cargo (vehicle_id, product_id, quantity)
                                         VALUES (?, ?, ?)
                                         ON DUPLICATE KEY UPDATE quantity = quantity + ?";
                $stmt = $conn->prepare($add_to_vehicle_query);
                if ($stmt) {
                    $stmt->bind_param('iiii', $vehicle_id, $product_id, $quantity, $quantity);
                    if (!$stmt->execute()) {
                        die('Σφάλμα κατά την ενημέρωση του φορτίου οχήματος: ' . $stmt->error);
                    }
                } else {
                    die('Σφάλμα κατά την προετοιμασία του ερωτήματος φορτίου: ' . $conn->error);
                }
            } else {
                die('Σφάλμα κατά την προετοιμασία του ερωτήματος αποθήκης: ' . $conn->error);
            }
        }
    }
}

// Ανακατεύθυνση πίσω στη σελίδα διαχείρισης φορτίου
header("Location: cargo_management.php");
exit();
