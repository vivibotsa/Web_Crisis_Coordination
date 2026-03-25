<?php
session_start();
include 'database.php';

// Έλεγχος αν το vehicle_id είναι ορισμένο στη συνεδρία
if (!isset($_SESSION['vehicle_id'])) {
    die('Το vehicle_id δεν έχει οριστεί.');
}

$vehicle_id = $_SESSION['vehicle_id'];

// Έλεγχος αν το αίτημα είναι POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Μη έγκυρη μέθοδος αιτήματος.');
}

// Ξεκινάμε τη συναλλαγή για να διασφαλίσουμε την ατομικότητα των ενημερώσεων
$conn->begin_transaction();

try {
    // Παίρνουμε όλα τα προϊόντα από το όχημα
    $vehicle_items_query = "SELECT product_id, quantity FROM vehicle_cargo WHERE vehicle_id = ?";
    $stmt = $conn->prepare($vehicle_items_query);
    $stmt->bind_param('i', $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Προετοιμασία των queries εκτός του βρόχου για καλύτερη απόδοση
    $update_stock_query = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_stock_query);

    $remove_from_vehicle_query = "DELETE FROM vehicle_cargo WHERE vehicle_id = ? AND product_id = ?";
    $stmt_remove = $conn->prepare($remove_from_vehicle_query);

    // Επεξεργασία των προϊόντων
    while ($item = $result->fetch_assoc()) {
        // Ενημέρωση της αποθήκης
        $stmt_update->bind_param('ii', $item['quantity'], $item['product_id']);
        if (!$stmt_update->execute()) {
            throw new Exception('Σφάλμα κατά την ενημέρωση της ποσότητας στην αποθήκη.');
        }

        // Αφαίρεση από το όχημα
        $stmt_remove->bind_param('ii', $vehicle_id, $item['product_id']);
        if (!$stmt_remove->execute()) {
            throw new Exception('Σφάλμα κατά την αφαίρεση των προϊόντων από το όχημα.');
        }
    }

    // Εφόσον δεν προέκυψε κανένα σφάλμα, κάνουμε commit
    $conn->commit();

    // Κλείσιμο των statements
    $stmt_update->close();
    $stmt_remove->close();
    $stmt->close();

    // Ανακατεύθυνση στη σελίδα διαχείρισης φορτίου
    header("Location: cargo_management.php");
    exit();

} catch (Exception $e) {
    // Κάνουμε rollback σε περίπτωση σφάλματος
    $conn->rollback();

    // Καταγραφή του σφάλματος
    error_log($e->getMessage());

    // Εμφάνιση μηνύματος σφάλματος στον χρήστη
    echo "Σφάλμα κατά την εκφόρτωση των προϊόντων: " . $e->getMessage();
}

// Κλείσιμο της σύνδεσης
$conn->close();
?>
