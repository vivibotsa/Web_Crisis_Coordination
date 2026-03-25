<?php
include("database.php");    
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryName = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_STRING);

    // Έλεγχος αν η κατηγορία υπάρχει ήδη
    $sql = "SELECT * FROM categories WHERE category_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Η κατηγορία υπάρχει ήδη κοιτάξτε παρακάτω.";
    } else {
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $categoryName);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Η κατηγορία προστέθηκε επιτυχώς.";
        } else {
            $_SESSION['message'] = "Σφάλμα κατά την προσθήκη της κατηγορίας: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}

header("Location: admin.php");
exit();
?>