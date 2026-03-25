<?php
// Ξεκινάμε τη συνεδρία
session_start();
// Καθαρισμός οποιασδήποτε προηγούμενης συνεδρίας
session_unset();
session_destroy();

// Διαγραφή του session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Σύνδεση στη βάση δεδομένων
include 'database.php'; // Υποθέτουμε ότι αυτό το αρχείο περιέχει τη σύνδεση στη βάση

// Αρχικοποίηση μηνύματος λάθους (αν υπάρχει)
$error_message = '';

// Έλεγχος αν η φόρμα υποβλήθηκε
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Λήψη των δεδομένων από τη φόρμα και καθαρισμός τους
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Πρώτα ελέγχουμε αν είναι στον πίνακα register_polites (Πολίτες)
    $stmt = $conn->prepare("SELECT * FROM register_polites WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Έλεγχος αν βρέθηκε ο χρήστης στον πίνακα πολιτών
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Επιτυχής σύνδεση, ορίζουμε τις μεταβλητές της συνεδρίας
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id']; 
            
            // Ανακατεύθυνση στη σωστή σελίδα ανάλογα με τον ρόλο του χρήστη
            switch ($_SESSION['role']) {
                case 'admin':
                    header('Location: admin.php');
                    exit();
                case 'diaswsths':
                    header('Location: diaswsths.php');
                    exit();
                case 'politis':
                    header('Location: politis.php');
                    exit();
                default:
                    $error_message = "Λάθος ρόλος.";
            }
        } else {
            // Λανθασμένος κωδικός πρόσβασης
            $error_message = "Λάθος κωδικός πρόσβασης.";
        }
    } else {
        // Έλεγχος στον πίνακα διασωστών
        $stmt = $conn->prepare("SELECT * FROM rescuers WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $rescuer = $result->fetch_assoc();
            if (password_verify($password, $rescuer['password'])) {
                // Επιτυχής σύνδεση για τον διασώστη
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $rescuer['username'];
                $_SESSION['role'] = 'diaswsths'; 
                $_SESSION['id'] = $rescuer['id'];

                // Ανακατεύθυνση στη σελίδα για διασώστες
                header('Location: diaswsths.php');
                exit();
            } else {
                $error_message = "Λάθος κωδικός πρόσβασης.";
            }
        } else {
            $error_message = "Λάθος όνομα χρήστη.";
        }
    }

    $stmt->close();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Είσοδος </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        label, input {
            margin-top: 10px;
            display: block;
            width: 100%;
            padding: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Είσοδος <?php echo !empty($role) ? '- ' . ucfirst($role) : ''; ?></h2>


    <!-- Φόρμα εισόδου -->
    <form action="login.php" method="POST">
        <label for="username">Όνομα χρήστη:</label>
        <input type="text" id="username" name="username" minlength="4" maxlength="15" required>

        <label for="password">Κωδικός:</label>
        <input type="password" id="password" name="password" minlength="4" maxlength="15" required>

        <input type="submit" value="Είσοδος">
    </form>

    <!-- Εμφάνιση μηνύματος λάθους -->
    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <button onclick="window.location.href='index.php'" style="margin-top: 10px;">Επιστροφή</button>
    </div>
</body>
</html>