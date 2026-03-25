<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy(); // Καταστροφή της συνεδρίας
    header("Location: login.php"); // Ανακατεύθυνση στο login
    exit();
}

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Πίνακας Διαχείρισης</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e3f2fd; /* Απαλό γαλάζιο χρώμα */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100vw;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            width: 100%;
            height: 100%;
            max-width: 100%;
            box-sizing: border-box; /* Συμπερίληψη των περιθωρίων στο συνολικό πλάτος */
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
            font-size: 2.5em;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 40px;
        }
        .button {
            background-color: #64b5f6; /* Απαλό γαλάζιο χρώμα κουμπιών */
            color: white;
            border: none;
            padding: 8px 16px; /* Μειωμένο padding για μικρότερα κουμπιά */
            text-decoration: none;
            font-size: 1em; /* Μικρότερη γραμματοσειρά */
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 50%; /* Μικρότερα κουμπιά */
            max-width: 250px;
        }
        .button:hover {
            background-color: #42a5f5; /* Σκούρο γαλάζιο κατά την αιώρηση */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Καλώς ήρθατε, διαχειριστή!</h1>
        <div class="buttons">
            <a href="warehouse_management.php" class="button">Διαχείριση Αποθήκης Βάσης</a>
            <a href="map_view.php" class="button">Προβολή Χάρτη</a>
            <a href="add_rescuer.php" class="button">Δημιουργία accounts διασωστών</a> <!-- Μόνο αυτό το κουμπί παραμένει -->
            <a href="create_announcements.php" class="button">Δημιουργία ανακοινώσεων</a>
            <a href="stats.php" class="button">Στατιστικά Εξυπηρέτησης</a> <!-- Κουμπί για ανακατεύθυνση στη νέα σελίδα -->
            <a href="logout.php" class="button">Αποσύνδεση</a>
        </div>
    </div>
</body>
</html>