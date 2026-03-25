<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Επιτυχία Δημιουργίας Ανακοίνωσης</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            padding: 20px;
        }
        .success-message {
            color: green;
            font-size: 1.5em;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container form {
            display: inline-block;
            margin: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 1em;
        }
        .logout-button {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="success-message">Η ανακοίνωση δημιουργήθηκε με επιτυχία!</div>

    <div class="button-container">
        <!-- Κουμπί για δημιουργία νέας ανακοίνωσης -->
        <form action="create_announcements.php" method="get">
            <input type="submit" value="Δημιουργία Νέας Ανακοίνωσης">
        </form>

        <!-- Κουμπί αποσύνδεσης -->
        <form action="admin.php" method="post">
            <input type="submit" value="Επιστροφή" class="logout-button">
        </form>
    </div>
</body>
</html>
