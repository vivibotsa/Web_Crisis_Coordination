<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Σύνδεση με τη βάση δεδομένων
include 'database.php';

// Αρχικοποίηση μεταβλητών για χρονική περίοδο
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01');
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t');

// Ερώτημα στη βάση για τα στατιστικά (αντλεί δεδομένα από requests_offers)
$query = "
    SELECT 
        SUM(CASE WHEN type = 'request' THEN 1 ELSE 0 END) AS new_requests,
        SUM(CASE WHEN type = 'offer' THEN 1 ELSE 0 END) AS new_offers
    FROM requests_offers 
    WHERE date_created BETWEEN ? AND ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc(); // Παίρνουμε τα αποτελέσματα ως πίνακα
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Στατιστικά Εξυπηρέτησης</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Εισαγωγή βιβλιοθήκης Chart.js -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e3f2fd;
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
            box-sizing: border-box;
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
            font-size: 2.5em;
        }
        .stats-container {
            margin-top: 50px;
            padding: 20px;
            background-color: #f1f8e9;
            border-radius: 8px;
        }
        .button {
            background-color: #64b5f6;
            color: white;
            border: none;
            padding: 8px 16px;
            text-decoration: none;
            font-size: 1em;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 50%;
            max-width: 250px;
        }
        /* Προσαρμογή για μακρύτερο γράφημα */
        #statsChart {
            width: 600px !important; /* Μεγαλύτερο πλάτος */
            height: 300px !important; /* Ανάλογη αύξηση στο ύψος */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Στατιστικά Εξυπηρέτησης</h1>
        <div class="stats-container">
            <form method="post" action="stats.php">
                Από: <input type="date" name="start_date" value="<?php echo $startDate; ?>" required>
                Έως: <input type="date" name="end_date" value="<?php echo $endDate; ?>" required>
                <button type="submit" class="button">Φόρτωση Στατιστικών</button>
            </form>

            <!-- Καμβάς για το γράφημα -->
            <canvas id="statsChart"></canvas>

            <!-- JavaScript για τη δημιουργία του γραφήματος -->
            <script>
            var ctx = document.getElementById('statsChart').getContext('2d');
            var statsChart = new Chart(ctx, {
                type: 'bar', // Μπορείς να επιλέξεις και 'line' για γραμμή
                data: {
                    labels: ['Νέα Αιτήματα', 'Διεκπεραιωμένα Αιτήματα', 'Νέες Προσφορές', 'Διεκπεραιωμένες Προσφορές'],
                    datasets: [{
                        label: 'Στατιστικά Εξυπηρέτησης',
                        data: [<?php echo $stats['new_requests']; ?>, 0, <?php echo $stats['new_offers']; ?>, 0], // Προσθέτουμε 0 για placeholder διεκπεραιωμένων
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            </script>

        </div>
        <a href="admin.php" class="button">Επιστροφή στο προφίλ</a>
    </div>
</body>
</html>