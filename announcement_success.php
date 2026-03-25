<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Ανακοινώσεων και Προσφορών</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Ανακοινώσεις</h1>
    <table>
        <thead>
            <tr>
                <th>Τίτλος</th>
                <th>Περιγραφή</th>
                <th>Ημερομηνία</th>
                <th>Ενέργεια</th>
            </tr>
        </thead>
        <tbody id="announcements-body">
            <!-- Τα δεδομένα θα φορτωθούν εδώ μέσω AJAX -->
        </tbody>
    </table>

    <h2>Οι Προσφορές Μου</h2>
    <table>
        <thead>
            <tr>
                <th>Ανακοίνωση</th>
                <th>Κατάσταση</th>
                <th>Ημερομηνία</th>
                <th>Ενέργεια</th>
            </tr>
        </thead>
        <tbody id="offers-body">
            <!-- Τα δεδομένα θα φορτωθούν εδώ μέσω AJAX -->
        </tbody>
    </table>
</div>

<script>
    // Φόρτωση ανακοινώσεων μέσω AJAX
    function loadAnnouncements() {
        fetch('fetch_announcements.php')
        .then(response => response.json())
        .then(data => {
            const announcementsBody = document.getElementById('announcements-body');
            announcementsBody.innerHTML = '';
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.title}</td>
                    <td>${row.description}</td>
                    <td>${row.date_created}</td>
                    <td>
                        <form action='submit_offer.php' method='POST'>
                            <input type='hidden' name='announcement_id' value='${row.id}'>
                            <button type='submit'>Υποβολή Προσφοράς</button>
                        </form>
                    </td>
                `;
                announcementsBody.appendChild(tr);
            });
        });
    }

    // Φόρτωση προσφορών μέσω AJAX
    function loadOffers() {
        fetch('fetch_offers.php')
        .then(response => response.json())
        .then(data => {
            const offersBody = document.getElementById('offers-body');
            offersBody.innerHTML = '';
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.announcement_id}</td>
                    <td>${row.status === 'pending' ? 'Σε εκκρεμότητα' : (row.status === 'rescuer_assigned' ? 'Διασώστης Ανατέθηκε' : 'Ολοκληρωμένη')}</td>
                    <td>${row.date_submitted ? row.date_submitted : 'N/A'}</td>
                    <td>${row.status === 'pending' || row.status === 'rescuer_assigned' ? 
                        `<form action='cancel_offers.php' method='POST'>
                            <input type='hidden' name='offer_id' value='${row.id}'>
                            <button type='submit'>Ακύρωση Προσφοράς</button>
                        </form>` : ''}</td>
                `;
                offersBody.appendChild(tr);
            });
        });
    }

    // Κλήση των συναρτήσεων για τη φόρτωση δεδομένων κατά την εκκίνηση της σελίδας
    document.addEventListener('DOMContentLoaded', () => {
        loadAnnouncements();
        loadOffers();
    });
</script>

</body>
</html>
