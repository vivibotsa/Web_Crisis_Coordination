<?php
// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Σύνδεση με τη βάση δεδομένων
include 'database.php'; 

// Έλεγχος αν έχει σταλεί η φόρμα
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Λήψη των δεδομένων από τη φόρμα
    $announcement_id = $_POST['announcement_id'];
    $user_id = $_SESSION['id']; // Το ID του συνδεδεμένου χρήστη
    
    // Έλεγχος αν το announcement_id είναι έγκυρος ακέραιος αριθμός
    if (!filter_var($announcement_id, FILTER_VALIDATE_INT)) {
        echo "Μη έγκυρο ID ανακοίνωσης.";
        exit();
    }

    // Δυναμική λήψη του item_id από τη φόρμα (ή κάποια άλλη πηγή)
    $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : 1; // Συμπλήρωσε εδώ το κατάλληλο item_id

    // Προετοιμασία του query
    $query = "INSERT INTO announcement_items (announcement_id, register_polites_id, item_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Έλεγχος αν η προετοιμασία του query ήταν επιτυχής
    if (!$stmt) {
        // Καταγραφή σφάλματος και εμφάνιση γενικού μηνύματος στον χρήστη
        error_log("Σφάλμα κατά την προετοιμασία του query: " . $conn->error);
        echo "Σφάλμα κατά την υποβολή της προσφοράς.";
        exit();
    }

    $stmt->bind_param("iii", $announcement_id, $user_id, $item_id);

    // Εκτέλεση του query
    if ($stmt->execute()) {
        // Αν επιτυχεί η προσθήκη, ανακατεύθυνση στη σελίδα ανακοινώσεων με μήνυμα επιτυχίας
        header("Location: anakoinoseis_prosfores_politis.php?success=1");
        exit();
    } else {
        // Καταγραφή σφάλματος και εμφάνιση γενικού μηνύματος στον χρήστη
        error_log("Σφάλμα κατά την εκτέλεση του query: " . $stmt->error);
        echo "Σφάλμα κατά την υποβολή της προσφοράς.";
    }
}
?>