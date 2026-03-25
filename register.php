<?php
session_start();
session_regenerate_id(true); // Αναγέννηση του ID της συνεδρίας για μεγαλύτερη ασφάλεια


// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'politis') {
    // Αν δεν είναι συνδεδεμένος ή δεν έχει το σωστό ρόλο, ανακατεύθυνση στη σελίδα σύνδεσης
    header("Location: login.php");
    exit();
}

// Καθαρισμός του cache για να μην μπορεί ο χρήστης να επιστρέψει σε αυτή τη σελίδα μέσω του back button
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Δημιουργία CSRF token αν δεν υπάρχει ήδη
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Πολίτης - Διαχείριση</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .logout {
            background-color: #f44336; /* Κόκκινο χρώμα για αποσύνδεση */
        }
        .logout:hover {
            background-color: #e53935;
        }
    </style>
    <script>
        // Συνάρτηση επιβεβαίωσης αποσύνδεσης
        function confirmLogout() {
            return confirm("Είστε σίγουροι ότι θέλετε να αποσυνδεθείτε;");
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Καλώς ήρθατε, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

        <!-- Κουμπί για Διαχείριση Αιτημάτων -->
        <form action="aitimata_politis.php" method="get">
            <button type="submit">Διαχείριση Αιτημάτων</button>
        </form>

        <!-- Κουμπί για Διαχείριση Ανακοινώσεων και Προσφορών -->
        <form action="anakoinoseis_prosfores_politis.php" method="get">
            <button type="submit">Διαχείριση Ανακοινώσεων και Προσφορών</button>
        </form>

        <!-- Κουμπί Αποσύνδεσης με μήνυμα επιβεβαίωσης -->
        <form action="logout.php" method="post" onsubmit="return confirmLogout()">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" class="logout">Αποσύνδεση</button>
        </form>
    </div>
</body>
</html>