<?php
session_start();
include("database.php");

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος ως διαχειριστής
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Μεταβλητή για αποθήκευση μηνύματος
$message = '';

// Επεξεργασία φόρμας
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $items = isset($_POST['items']) ? $_POST['items'] : []; // Έλεγχος αν τα είδη υπάρχουν

    // Προσθήκη νέας ανακοίνωσης
    $sql = "INSERT INTO announcements (title, description) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $title, $description);
        if ($stmt->execute()) {
            $announcement_id = $stmt->insert_id;

            // Προσθήκη ειδών στην ανακοίνωση
            $item_sql = "INSERT INTO announcement_items (announcement_id, item_id) VALUES (?, ?)";
            if ($item_stmt = $conn->prepare($item_sql)) {
                foreach ($items as $item_id) {
                    $item_stmt->bind_param("ii", $announcement_id, $item_id);
                    $item_stmt->execute();
                }
                // Ανακατεύθυνση στη σελίδα επιβεβαίωσης
                header("Location: announcement_success.php");
                exit();
            } else {
                $message = "Σφάλμα κατά την προετοιμασία της εισαγωγής ειδών.";
            }
        } else {
            $message = "Σφάλμα κατά την δημιουργία της ανακοίνωσης.";
        }
        $stmt->close();
    } else {
        $message = "Σφάλμα κατά την προετοιμασία της εισαγωγής ανακοίνωσης.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Δημιουργία Ανακοίνωσης</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
            text-align: left;
        }
        .message {
            text-align: left;
            color: green;
        }
        form {
            display: block;
            margin-top: 20px;
        }
        label, input, textarea {
            margin-top: 10px;
            display: block;
            width: 100%;
            padding: 10px;
        }
        select {
            width: 100%;
            height: 150px; /* Προσαρμόστε το ύψος εδώ */
            padding: 5px;
            box-sizing: border-box;
        }
        input[type="submit"], .logout-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            padding: 10px 20px;
        }
        .logout-button {
            background-color: #f44336;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Δημιουργία Νέας Ανακοίνωσης</h1>

        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Φόρμα Δημιουργίας Ανακοίνωσης -->
        <form action="create_announcements.php" method="post">
            <label for="title">Τίτλος Ανακοίνωσης:</label>
            <input type="text" name="title" required>
            
            <label for="description">Περιγραφή:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="items">Επιλογή Ειδών:</label>
            <select name="items[]" multiple size="10"> <!-- Προσθέσαμε το "size" για να δείξουμε περισσότερα στοιχεία -->
                <?php
                // Ανάκτηση όλων των προϊόντων για επιλογή
                $result = $conn->query("SELECT id, name FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Δημιουργία Ανακοίνωσης">
        </form>

        <!-- Κουμπί αποσύνδεσης -->
        <form action="admin.php" method="post">
            <input type="submit" value="Επιστροφή" class="logout==-button">
        </form>
    </div>
</body>
</html>
