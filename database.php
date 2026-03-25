<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit();
    } 
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Καλώς ήρθες, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Αυτό είναι το προστατευμένο περιεχόμενο.</p>
 <!-- Εμφανίζει τον σύνδεσμο μόνο αν ο χρήστης είναι διαχειριστής -->
 <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="add_rescuer.php">Δημιουργία Νέου Διασώστη</a>
        <br>
    <?php endif; ?>

    <a href="logout.php">Αποσύνδεση</a>
</body>
</html>