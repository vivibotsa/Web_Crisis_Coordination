
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>CrisisCoordination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
        }

        h1 {
            margin: 0 0 20px;
            font-size: 24px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .register-link {
            margin-top: 10px;
        }

        .register-link a {
            text-decoration: none;
            color: blue;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>CrisisCoordination</h1>

        <!-- Κουμπιά επιλογών για τον χρήστη -->
        <form action="login.php" method="get">
            <button type="submit" name="role" value="admin">Είσοδος Διαχειριστή</button>
            <button type="submit" name="role" value="diaswsths">Είσοδος Διασώστη</button>
            <button type="submit" name="role" value="politis">Είσοδος Πολίτη</button>
        </form>

        <!-- Λινκ εγγραφής κάτω από τα κουμπιά -->
        <div class="register-link">
            Δεν έχετε λογαριασμό; <a href="register.php">Εγγραφή</a>
        </div>
    </div>
</body>
</html>

