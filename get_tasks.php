<?php
session_start();
if (isset($_SESSION['username'])) {
    // Επιστρέφεις το username του διασώστη
    echo json_encode(['username' => $_SESSION['username']]);
} else {
    echo json_encode(['error' => 'User not logged in']);
}
?>
