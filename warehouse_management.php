<?php
session_start();

// Έλεγχος αν ο χρήστης είναι διαχειριστής
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Σύνδεση στη βάση δεδομένων
require_once 'database.php';

// Ανάκτηση κατηγοριών για το φιλτράρισμα με `prepared statements`
$sql_categories = "SELECT * FROM categories";
$stmt_categories = $conn->prepare($sql_categories);
$stmt_categories->execute();
$result_categories = $stmt_categories->get_result();

$categories = [];
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}
$stmt_categories->close();

// Ανάκτηση των προϊόντων με φιλτράρισμα κατηγορίας αν έχει επιλεγεί
$category_filter = '';
$selected_categories = [];
if (isset($_POST['category']) && !empty($_POST['category'])) {
    // Μετατροπή των επιλεγμένων κατηγοριών σε ακέραιους αριθμούς για ασφαλή χρήση
    $selected_categories = array_map('intval', $_POST['category']);
    // Δημιουργία του SQL IN statement για `prepared statements`
    $in  = str_repeat('?,', count($selected_categories) - 1) . '?';
    $category_filter = "WHERE p.category_id IN ($in)";
}

// Ανάκτηση προϊόντων με τοποθεσία (βάση ή όχημα) και ποσότητα > 0
$sql_products = "SELECT p.name, p.quantity, c.category_name, v.vehicle_id, 
                 IFNULL(v.vehicle_id, 'Βάση') AS location 
                 FROM products p 
                 JOIN categories c ON p.category_id = c.id 
                 LEFT JOIN vehicle_cargo v ON p.id = v.product_id 
                 $category_filter
                 AND p.quantity > 0";
                 
// Προετοιμασία της SQL δήλωσης
$stmt_products = $conn->prepare($sql_products);

// Ανάθεση τιμών στις μεταβλητές με το `bind_param` αν έχουν επιλεγεί κατηγορίες
if (!empty($selected_categories)) {
    $stmt_products->bind_param(str_repeat('i', count($selected_categories)), ...$selected_categories);
}

$stmt_products->execute();
$result_products = $stmt_products->get_result();

// Έλεγχος για σφάλματα στη SQL
if (!$result_products) {
    error_log("Query Failed: " . mysqli_error($conn));
    die("Προέκυψε σφάλμα κατά την εκτέλεση του ερωτήματος.");
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Προβολή κατάστασης αποθήκης</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .filter-form {
            text-align: center;
            margin-bottom: 20px;
        }
        .table-container {
            display: flex;
            justify-content: center;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            background-color: white;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #64b5f6;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<h1>Προβολή κατάστασης αποθήκης</h1>

<!-- Φόρμα φιλτραρίσματος κατηγοριών -->
<div class="filter-form">
    <form action="view_warehouse_status.php" method="post">
        <label for="category">Επιλέξτε Κατηγορία:</label>
        <select name="category[]" id="category" multiple>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php if (isset($_POST['category']) && in_array($category['id'], $selected_categories)) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Φιλτράρισμα</button>
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Όνομα Είδους</th>
                <th>Κατηγορία</th>
                <th>Ποσότητα</th>
                <th>Τοποθεσία</th> <!-- Νέα στήλη για τη θέση του προϊόντος -->
            </tr>
        </thead>
        <tbody>
            <?php if ($result_products->num_rows > 0): ?>
                <?php while ($product = $result_products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                        <td><?php echo ($product['location'] === 'Βάση') ? 'Βάση' : 'Όχημα #' . htmlspecialchars($product['vehicle_id']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Δεν βρέθηκαν διαθέσιμα προϊόντα.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
// Κλείσιμο των statements και της σύνδεσης
$stmt_products->close();
$conn->close();
?>

</body>
</html>