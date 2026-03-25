<?php
session_start();
include 'database.php'; // Σύνδεση με τη βάση δεδομένων

// Ενεργοποίηση της εμφάνισης σφαλμάτων για έλεγχο
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Έλεγχος αν ο χρήστης είναι διαχειριστής
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Λήψη δεδομένων από τη φόρμα
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Κρυπτογράφηση του κωδικού πρόσβασης
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Ξεκινάμε τη συναλλαγή για την εισαγωγή διασώστη και ανάθεση οχήματος
    $conn->begin_transaction();

    try {
        // Εισαγωγή στον πίνακα rescuers
        $stmt = $conn->prepare("INSERT INTO rescuers (username, password, role) VALUES (?, ?, 'diaswsths')");
        $stmt->bind_param("ss", $username, $hashed_password);

        if (!$stmt->execute()) {
            throw new Exception("Σφάλμα κατά την εισαγωγή του διασώστη.");
        }

        // Παίρνουμε το ID του διασώστη που μόλις εισάγαμε
        $rescuer_id = $conn->insert_id;

        // Αναζήτηση ενός διαθέσιμου οχήματος
        $vehicle_stmt = $conn->prepare("SELECT id FROM vehicles WHERE status = 'inactive' LIMIT 1");
        $vehicle_stmt->execute();
        $vehicle_result = $vehicle_stmt->get_result();
        
        if ($vehicle_result->num_rows > 0) {
            $vehicle = $vehicle_result->fetch_assoc();
            $vehicle_id = $vehicle['id'];

            // Ανάθεση του οχήματος στον διασώστη
            $assign_vehicle_stmt = $conn->prepare("UPDATE vehicles SET rescuer_id = ?, status = 'active' WHERE id = ?");
            $assign_vehicle_stmt->bind_param("ii", $rescuer_id, $vehicle_id);

            if (!$assign_vehicle_stmt->execute()) {
                throw new Exception("Σφάλμα κατά την ανάθεση οχήματος.");
            }

            $assign_vehicle_stmt->close();
        }

        // Αν όλα πήγαν καλά, καταχωρούμε τις αλλαγές στη βάση
        $conn->commit();

        // Ανακατεύθυνση στη σελίδα επιτυχίας
        header("Location: register_rescuer_success.php");
        exit();
    } catch (Exception $e) {
        // Αν προκύψει κάποιο σφάλμα, κάνουμε rollback στη συναλλαγή
        $conn->rollback();
        $error_message = $e->getMessage();
    }

    $stmt->close();
    $vehicle_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Δημιουργία Νέου Διασώστη</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 1.8em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="password"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .button {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            font-size: 1em;
            color: white;
            background-color: #4CAF50;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Δημιουργία Νέου Διασώστη</h1>

        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form action="add_rescuer.php" method="post">
            <label for="username">Όνομα χρήστη:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Κωδικός πρόσβασης:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Αποθήκευση">
        </form>

        <a href="admin.php" class="button">Επιστροφή στην Αρχική Διαχειριστή</a>
    </div>
</body>
</html>
