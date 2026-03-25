<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Σύνδεση στη βάση δεδομένων
include("database.php");

// Ανάκτηση του ονόματος της κατηγορίας
$categoryId = $_GET['id'];
$categoryName = '';

// Ερώτημα για το όνομα της κατηγορίας
$categorySql = "SELECT category_name FROM categories WHERE id = ?";
$categoryStmt = $conn->prepare($categorySql);
if (!$categoryStmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$categoryStmt->bind_param('i', $categoryId);
$categoryStmt->execute();
$categoryStmt->bind_result($categoryName);
$categoryStmt->fetch();
$categoryStmt->close();

// Ανάκτηση των προϊόντων και των λεπτομερειών τους για την κατηγορία
$products = [];
$productsSql = "SELECT p.id, p.name, p.quantity, d.detail_name, d.detail_value 
                FROM products p 
                LEFT JOIN product_details d ON p.id = d.product_id 
                WHERE p.category_id = ? 
                ORDER BY p.id, d.id";
$productsStmt = $conn->prepare($productsSql);
if (!$productsStmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$productsStmt->bind_param('i', $categoryId);
$productsStmt->execute();
$productsResult = $productsStmt->get_result();

// Αναδιάταξη των προϊόντων και των λεπτομερειών τους
while ($row = $productsResult->fetch_assoc()) {
    $productId = $row['id'];
    if (!isset($products[$productId])) {
        $products[$productId] = [
            'id' => $productId,
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'details' => []
        ];
    }
    // Αποτροπή διπλότυπων λεπτομερειών
    $existingDetailNames = array_column($products[$productId]['details'], 'detail_name');
    if ($row['detail_name'] && !in_array($row['detail_name'], $existingDetailNames)) {
        $products[$productId]['details'][] = [
            'detail_name' => $row['detail_name'],
            'detail_value' => $row['detail_value']
        ];
    }
}
$productsStmt->close();

// Διαχείριση της προσθήκης νέου προϊόντος
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $productName = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
    $productQuantity = intval($_POST['product_quantity']);
    $detailNames = $_POST['detail_name'];
    $detailValues = $_POST['detail_value'];

    // Έλεγχος αν το προϊόν υπάρχει ήδη στην ίδια κατηγορία
    $sql = "SELECT id FROM products WHERE name = ? AND category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $productName, $categoryId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "Το προϊόν υπάρχει ήδη στην κατηγορία.";
    } else {
        $insertProductSql = "INSERT INTO products (name, category_id, quantity) VALUES (?, ?, ?)";
        $insertProductStmt = $conn->prepare($insertProductSql);
        if (!$insertProductStmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $insertProductStmt->bind_param('sii', $productName, $categoryId, $productQuantity);

        if ($insertProductStmt->execute()) {
            $newProductId = $insertProductStmt->insert_id;
            $_SESSION['message'] = "Το προϊόν προστέθηκε επιτυχώς.";

            // Εισαγωγή των λεπτομερειών του νέου προϊόντος
            if (!empty($detailNames) && !empty($detailValues)) {
                $insertDetailSql = "INSERT INTO product_details (product_id, detail_name, detail_value) VALUES (?, ?, ?)";
                $insertDetailStmt = $conn->prepare($insertDetailSql);
                if (!$insertDetailStmt) {
                    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                }

                foreach ($detailNames as $index => $detailName) {
                    $detailValue = $detailValues[$index];
                    $insertDetailStmt->bind_param('iss', $newProductId, $detailName, $detailValue);
                    $insertDetailStmt->execute();
                }

                $insertDetailStmt->close();
            }
        } else {
            $_SESSION['message'] = "Σφάλμα κατά την προσθήκη του προϊόντος: " . $insertProductStmt->error;
        }

        $insertProductStmt->close();
    }

    $stmt->close();
    $conn->close();

    header("Location: view_category.php?id=$categoryId");
    exit();
}

// Διαχείριση της τροποποίησης προϊόντων
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $productId = intval($_POST['product_id']);
    $newName = $_POST['new_name'];
    $newQuantity = intval($_POST['new_quantity']);

    $updateProductSql = "UPDATE products SET name = ?, quantity = ? WHERE id = ?";
    $updateProductStmt = $conn->prepare($updateProductSql);
    if (!$updateProductStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $updateProductStmt->bind_param('sii', $newName, $newQuantity, $productId);
    $updateProductStmt->execute();
    $updateProductStmt->close();

    header("Location: view_category.php?id=$categoryId");
    exit();
}

// Διαχείριση της διαγραφής προϊόντων
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productId = intval($_POST['product_id']);

    // Διαγραφή του προϊόντος από τον πίνακα products
    $deleteProductSql = "DELETE FROM products WHERE id = ?";
    $deleteProductStmt = $conn->prepare($deleteProductSql);
    $deleteProductStmt->bind_param('i', $productId);
    $deleteProductStmt->execute();
    $deleteProductStmt->close();

    // Διαγραφή των λεπτομερειών του προϊόντος από τον πίνακα product_details
    $deleteDetailsSql = "DELETE FROM product_details WHERE product_id = ?";
    $deleteDetailsStmt = $conn->prepare($deleteDetailsSql);
    $deleteDetailsStmt->bind_param('i', $productId);
    $deleteDetailsStmt->execute();
    $deleteDetailsStmt->close();

    header("Location: view_category.php?id=$categoryId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Προϊόντα Κατηγορίας: <?php echo htmlspecialchars($categoryName); ?></title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff;
    margin: 0;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

.container {
    background-color: white;
    padding: 20px;
    max-width: 600px; /* Μειώνουμε το πλάτος για να ταιριάζει καλύτερα */
    width: 100%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1, h2 {
    text-align: center;
    color: #333;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"], input[type="number"], input[type="submit"], button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"], button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover, button:hover {
    background-color: #45a049;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background-color: #f9f9f9;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

ul li a {
    color: #4CAF50;
    font-weight: bold;
    text-decoration: none;
}

ul li:hover {
    background-color: #e0f7fa;
}

button.delete {
    background-color: #e74c3c;
    color: white;
}

button.delete:hover {
    background-color: #c0392b;
}

.return-button {
    background-color: red;
    color: white;
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
    border: none;
    cursor: pointer;
    width: auto;
    margin-bottom: 20px;
}

.return-button:hover {
    background-color: darkred;
}

    </style>
</head>
<body>
    <div class="container">
        <a href="admin.php"><button class="return-button">Επιστροφή</button></a>

        <h1>Προϊόντα Κατηγορίας: <?php echo htmlspecialchars($categoryName); ?></h1>

        <!-- Φόρμα για προσθήκη προϊόντος -->
        <h2>Προσθήκη Προϊόντος</h2>
        <form action="view_category.php?id=<?php echo $categoryId; ?>" method="post">
            <label for="product_name">Όνομα προϊόντος:</label>
            <input type="text" id="product_name" name="product_name" required>
            
            <label for="product_quantity">Ποσότητα:</label>
            <input type="number" id="product_quantity" name="product_quantity" required>

            <div id="details-container">
                <label for="detail_name[]">Όνομα λεπτομέρειας προϊόντος:</label>
                <input type="text" name="detail_name[]" required>
                <label for="detail_value[]">Τιμή λεπτομέρειας προϊόντος:</label>
                <input type="text" name="detail_value[]" required><br><br>
            </div>

            <button type="button" onclick="addDetailField()">Πρόσθεσε παραπάνω λεπτομέρειες</button><br><br>

            <input type="submit" name="add_product" value="Προσθήκη Προϊόντος">
        </form>
        <hr>

        <!-- Λίστα προϊόντων με δυνατότητα τροποποίησης και διαγραφής -->
        <h2>Τροποποίηση Προϊόντων</h2>
        <?php if (empty($products)): ?>
            <p>Δεν υπάρχουν προϊόντα σε αυτή την κατηγορία.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <form action="view_category.php?id=<?php echo $categoryId; ?>" method="post">
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                            Ποσότητα: 
                            <input type="number" name="new_quantity" value="<?php echo $product['quantity']; ?>" required><br>
                            Όνομα:
                            <input type="text" name="new_name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="submit" name="update_product" value="Ενημέρωση Προϊόντος">
                            <button type="submit" name="delete_product" class="delete" onclick="return confirm('Είστε σίγουρος ότι θέλετε να διαγράψετε αυτό το προϊόν;')">Διαγραφή Προϊόντος</button>
                        </form>
                        <ul>
                            <?php foreach ($product['details'] as $detail): ?>
                                <li><?php echo htmlspecialchars($detail['detail_name']); ?>: <?php echo htmlspecialchars($detail['detail_value']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>

