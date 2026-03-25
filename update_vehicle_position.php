<?php
// Συμπερίληψη του αρχείου σύνδεσης με τη βάση δεδομένων
include 'database.php';

// Έλεγχος αν έχουν σταλεί τα δεδομένα lat και lng μέσω POST
if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    // Εκτύπωση των συντεταγμένων για να δούμε αν φτάνουν σωστά στο PHP
    echo "Λήφθηκαν νέες συντεταγμένες: Lat = $lat, Lng = $lng";

    // SQL για ενημέρωση της τοποθεσίας της βάσης
    $sql = "UPDATE base_location SET lat = ?, lng = ? WHERE id = 1";

    // Προετοιμασία του query και εκτέλεση με τα δεδομένα
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("dd", $lat, $lng); // d: double
        if ($stmt->execute()) {
            echo "Η τοποθεσία της βάσης ενημερώθηκε με επιτυχία.";
        } else {
            echo "Σφάλμα κατά την ενημέρωση της τοποθεσίας: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Σφάλμα κατά την προετοιμασία του query: " . $conn->error;
    }
} else {
    echo "Λείπουν οι συντεταγμένες της τοποθεσίας.";
}


// Κλείσιμο της σύνδεσης με τη βάση δεδομένων
$conn->close();
?>
