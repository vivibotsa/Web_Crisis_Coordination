<?php
// database connection
include 'database.php';

// Αρχικοποίηση μεταβλητών
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d', strtotime('-30 days'));
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');

// Query για τα στατιστικά
$query = "SELECT 
            SUM(CASE WHEN type = 'request' AND status = 'new' THEN 1 ELSE 0 END) AS new_requests,
            SUM(CASE WHEN type = 'request' AND status = 'completed' THEN 1 ELSE 0 END) AS completed_requests,
            SUM(CASE WHEN type = 'offer' AND status = 'new' THEN 1 ELSE 0 END) AS new_offers,
            SUM(CASE WHEN type = 'offer' AND status = 'completed' THEN 1 ELSE 0 END) AS completed_offers
          FROM request_offer_stats 
          WHERE created_at BETWEEN ? AND ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Κλείσιμο σύνδεσης
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Στατιστικά Εξυπηρέτησης</title>
</head>
<body>

<h2>Στατιστικά Εξυπηρέτησης</h2>

<!-- Φόρμα για επιλογή ημερομηνιών -->
<form method="POST" action="">
    Από: <input type="date" name="start_date" value="<?php echo $startDate; ?>" required>
    Έως: <input type="date" name="end_date" value="<?php echo $endDate; ?>" required>
    <button type="submit">Φόρτωση Στατιστικών</button>
</form>

<!-- Εμφάνιση στατιστικών -->
<h3>Αποτελέσματα για την περίοδο από <?php echo $startDate; ?> έως <?php echo $endDate; ?>:</h3>
<ul>
    <li>Νέα Αιτήματα: <?php echo $data['new_requests']; ?></li>
    <li>Διεκπεραιωμένα Αιτήματα: <?php echo $data['completed_requests']; ?></li>
    <li>Νέες Προσφορές: <?php echo $data['new_offers']; ?></li>
    <li>Διεκπεραιωμένες Προσφορές: <?php echo $data['completed_offers']; ?></li>
</ul>

</body>
</html>