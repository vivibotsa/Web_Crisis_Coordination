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
    <h1>Καλώς ήρθες</h1>
    
    <a href="logout.php">Αποσύνδεση</a>
</body>
</html>
