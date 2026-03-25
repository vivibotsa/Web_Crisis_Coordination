<?php
session_start();
include("database.php");

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος ως διαχειριστής
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Προβολή Ανακοινώσεων</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Προβολή Ανακοινώσεων</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Ανακοίνωσης</th>
                    <th>Τίτλος</th>
                    <th>Περιγραφή</th>
                    <th>Είδη</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ανάκτηση όλων των ανακοινώσεων από τη βάση δεδομένων
                $sql = "SELECT * FROM announcements";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";

                        // Ανάκτηση των ειδών που σχετίζονται με την ανακοίνωση
                        $announcement_id = $row['id'];
                        $item_sql = "SELECT p.name FROM announcement_items ai JOIN products p ON ai.item_id = p.id WHERE ai.announcement_id = ?";
                        $item_stmt = $conn->prepare($item_sql);
                        $item_stmt->bind_param("i", $announcement_id);
                        $item_stmt->execute();
                        $item_result = $item_stmt->get_result();

                        echo "<td>";
                        while ($item_row = $item_result->fetch_assoc()) {
                            echo htmlspecialchars($item_row['name']) . "<br>";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Δεν βρέθηκαν ανακοινώσεις.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>