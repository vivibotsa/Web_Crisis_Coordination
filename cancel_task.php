<?php
// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Σύνδεση με τη βάση δεδομένων
include 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offer_id = $_POST['offer_id'];

    // Ενημέρωση της κατάστασης της προσφοράς σε "cancelled"
    $query = "UPDATE announcement_items SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offer_id); // Χρησιμοποιούμε το μοναδικό offer_id
    
    if ($stmt->execute()) {
        // Επιστροφή στη σελίδα προσφορών με μήνυμα επιτυχίας
        header("Location: anakoinoseis_prosfores_politis.php?cancelled=1");
        exit();
    } else {
        echo "Σφάλμα κατά την ακύρωση της προσφοράς.";
    }
}
?>