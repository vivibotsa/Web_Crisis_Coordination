<?php
include 'database.php';

$request_id = $_POST['request_id'];
$rescuer_username = $_SESSION['username'];

$update_query = "UPDATE requests_offers SET vehicle = '$rescuer_username', date_taken = NOW() WHERE id = $request_id";

if ($conn->query($update_query) === TRUE) {
    echo "Αίτημα αναλήφθηκε επιτυχώς.";
} else {
    echo "Σφάλμα:Έχεις αναλάβει ήδη 4 task! " . $conn->error;
}

$conn->close();
?>