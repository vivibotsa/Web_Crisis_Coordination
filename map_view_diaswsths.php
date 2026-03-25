<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Χάρτης Διαχειριστή</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 500px;
            width: 600px;
            margin: 20px auto;
        }
        #confirmButton {
            display: none; /* Κρυφό μέχρι να μετακινηθεί η βάση */
            margin: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Καλώς ήρθες, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <a href="logout.php">Αποσύνδεση</a>

    <div class="button-container">
        <button onclick="updateDatabase()">Ανανέωση Δεδομένων</button>
    </div>
    <div>
        <label><input type="checkbox" id="requestsPending" checked> Αιτήματα Εκκρεμή</label>
        <label><input type="checkbox" id="requestsAccepted" checked> Αιτήματα Αναληφθέντα</label>
        <label><input type="checkbox" id="offersPending" checked> Προσφορές Εκρεμμείς</label>
        <label><input type="checkbox" id="offersAccepted" checked> Προσφορές Αναληφθέντες</label>
        <label><input type="checkbox" id="vehiclesActive" checked> Οχήματα με ενεργά tasks</label>
        <label><input type="checkbox" id="vehiclesInactive" checked> Οχήματα χωρίς tasks</label>
        <label><input type="checkbox" id="polylines" checked> Ευθείες Γραμμές</label>
    </div>

    <div id="map"></div>
    <button id="confirmButton" onclick="confirmBaseLocation()">Επιβεβαίωση Αλλαγής Τοποθεσίας</button>

    <!-- Add filter toggles -->
    

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([38.246242, 21.735085], 13);
        var newBaseLocation = null; // Για αποθήκευση της νέας τοποθεσίας
        var markers = [];
        var polylines = [];

        // Προσθήκη βασικού χάρτη από το OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var icons = {
            request_pending: L.icon({ iconUrl: 'request_pending_icon.png', iconSize: [25, 25], iconAnchor: [12, 25], popupAnchor: [0, -25] }),
            request_accepted: L.icon({ iconUrl: 'request_accepted_icon.png', iconSize: [25, 25], iconAnchor: [12, 25], popupAnchor: [0, -25] }),
            offer_pending: L.icon({ iconUrl: 'offer_pending_icon.png', iconSize: [25, 25], iconAnchor: [12, 25], popupAnchor: [0, -25] }),
            offer_accepted: L.icon({ iconUrl: 'offer_accepted_icon.png', iconSize: [25, 25], iconAnchor: [12, 25], popupAnchor: [0, -25] }),
            vehicle: L.icon({ iconUrl: 'vehicle_icon.png', iconSize: [30, 41], iconAnchor: [15, 41], popupAnchor: [0, -41] })
        };

        // Προσθήκη του marker της βάσης με δυνατότητα drag
        var baseMarker = L.marker([38.246242, 21.735085], {draggable: true}).addTo(map)
            .bindPopup('Βάση διασωστών').openPopup();

        // Όταν ο marker σταματά να σύρεται, αποθηκεύουμε την τοποθεσία και εμφανίζουμε το κουμπί
        baseMarker.on('dragend', function(event) {
            newBaseLocation = event.target.getLatLng(); // Αποθήκευση της νέας τοποθεσίας
            document.getElementById("confirmButton").style.display = 'block'; // Εμφάνιση κουμπιού επιβεβαίωσης
        });

        // Λειτουργία για αποστολή της νέας τοποθεσίας στον server όταν επιβεβαιωθεί
        function confirmBaseLocation() {
            if (newBaseLocation) {
                fetch('update_base_location.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'lat=' + newBaseLocation.lat + '&lng=' + newBaseLocation.lng
                })
                .then(response => response.text())
                .then(data => {
                    alert('Η τοποθεσία της βάσης ενημερώθηκε με επιτυχία.');
                    document.getElementById("confirmButton").style.display = 'none'; // Απόκρυψη κουμπιού επιβεβαίωσης
                })
                .catch(error => {
                    console.error('Σφάλμα κατά την ενημέρωση της τοποθεσίας:', error);
                });
            }
        }

        // Καθαρισμός των polylines
        function clearPolylines() {
            polylines.forEach(function(polyline) {
                map.removeLayer(polyline);
            });
            polylines = [];
        }

        // Καθαρισμός markers
        function clearMarkers() {
            markers.forEach(function(marker) {
                map.removeLayer(marker);
            });
            markers = [];
        }

        // Λειτουργία φόρτωσης δεδομένων από τη βάση
        function loadMapData(showRequestsPending, showRequestsTaken, showOffersPending, showOffersTaken, showVehiclesActive, showVehiclesInactive, showPolylines) {
            clearMarkers(); // Καθαρισμός των παλιών markers
            clearPolylines(); // Καθαρισμός των παλιών polylines
            fetch('get_map_data.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error loading data:', data.error);
                        return;
                    }

                    // Προσθήκη markers για αιτήματα και προσφορές
                    var userRequestsOffers = {};
                    data.requests.forEach(function(request) {
                        if (!userRequestsOffers[request.username]) {
                            userRequestsOffers[request.username] = {
                                requests: [],
                                offers: []
                            };
                        }
                        userRequestsOffers[request.username].requests.push(request);
                    });

                    data.offers.forEach(function(offer) {
                        if (!userRequestsOffers[offer.username]) {
                            userRequestsOffers[offer.username] = {
                                requests: [],
                                offers: []
                            };
                        }
                        userRequestsOffers[offer.username].offers.push(offer);
                    });

                    Object.keys(userRequestsOffers).forEach(function(username) {
                        var userData = userRequestsOffers[username];
                        var combinedItems = '';

                        // Συγκέντρωση αιτημάτων
                        userData.requests.forEach(function(request) {
                            if ((showRequestsPending && request.status === 'pending') || (showRequestsTaken && request.status === 'accepted')) {
                                var markerIcon = request.status === 'pending' ? icons.request_pending : icons.request_accepted;
                                combinedItems += '<b>Αίτημα:</b> ' + request.item + ' - <b>Ποσότητα:</b> ' + request.quantity + '<br>' +
                                                 '<b>Ημερομηνία Καταχώρησης:</b> ' + request.date_created + '<br>' +
                                                 '<b>Ημερομηνία Ανάληψης:</b> ' + (request.date_taken || 'Μη αναληφθεί') + '<br>' +
                                                 '<b>Όχημα:</b> ' + (request.vehicle || 'Κανένα') + '<br><br>';
                                var lat = request.lat;
                                var lng = request.lng;
                                var marker = L.marker([lat, lng], {icon: markerIcon}).addTo(map)
                                    .bindPopup('<b>' + username + '</b><br>Τηλέφωνο: ' + request.phone + '<br>' + combinedItems);
                                markers.push(marker);
                            }
                        });

                        // Συγκέντρωση προσφορών
                        userData.offers.forEach(function(offer) {
                            if ((showOffersPending && offer.status === 'pending') || (showOffersTaken && offer.status === 'accepted')) {
                                var markerIcon = offer.status === 'pending' ? icons.offer_pending : icons.offer_accepted;
                                combinedItems += '<b>Προσφορά:</b> ' + offer.item + ' - <b>Ποσότητα:</b> ' + offer.quantity + '<br>' +
                                                 '<b>Ημερομηνία Καταχώρησης:</b> ' + offer.date_created + '<br>' +
                                                 '<b>Ημερομηνία Ανάληψης:</b> ' + (offer.date_taken || 'Μη αναληφθεί') + '<br>' +
                                                 '<b>Όχημα:</b> ' + (offer.vehicle || 'Κανένα') + '<br><br>';
                                var lat = offer.lat;
                                var lng = offer.lng;
                                var marker = L.marker([lat, lng], {icon: markerIcon}).addTo(map)
                                    .bindPopup('<b>' + username + '</b><br>Τηλέφωνο: ' + offer.phone + '<br>' + combinedItems);
                                markers.push(marker);
                            }
                        });
                    });

                    // Προσθήκη markers για οχήματα
                    data.vehicles.forEach(function(vehicle) {
                        var vehicleTasks = JSON.parse(vehicle.tasks);
                        if ((showVehiclesActive && vehicleTasks.length > 0) || (showVehiclesInactive && vehicleTasks.length === 0)) {
                            var vehicleMarker = L.marker([vehicle.lat, vehicle.lng], {icon: icons.vehicle}).addTo(map)
                                .bindPopup('<b>' + vehicle.username + '</b><br>Φορτίο: ' + vehicle.load + '<br>Κατάσταση: ' + vehicle.status + '<br>Ενεργά tasks: ' + vehicleTasks.length);
                            markers.push(vehicleMarker);

                            // Προσθήκη ευθειών γραμμών αν ενεργοποιηθούν
                            if (showPolylines && vehicleTasks.length > 0) {
                                vehicleTasks.forEach(function(task) {
                                    var polyline = L.polyline([[vehicle.lat, vehicle.lng], [task.lat, task.lng]], {color: 'blue'}).addTo(map);
                                    polylines.push(polyline);
                                });
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                });
        }

        // Φόρτωση δεδομένων από τα φίλτρα
        document.getElementById('requestsPending').addEventListener('change', applyFilters);
        document.getElementById('requestsAccepted').addEventListener('change', applyFilters);
        document.getElementById('offersPending').addEventListener('change', applyFilters);
        document.getElementById('offersAccepted').addEventListener('change', applyFilters);
        document.getElementById('vehiclesActive').addEventListener('change', applyFilters);
        document.getElementById('vehiclesInactive').addEventListener('change', applyFilters);
        document.getElementById('polylines').addEventListener('change', applyFilters);

        function applyFilters() {
            var showRequestsPending = document.getElementById('requestsPending').checked;
            var showRequestsAccepted = document.getElementById('requestsAccepted').checked;
            var showOffersPending = document.getElementById('offersPending').checked;
            var showOffersAccepted = document.getElementById('offersAccepted').checked;
            var showVehiclesActive = document.getElementById('vehiclesActive').checked;
            var showVehiclesInactive = document.getElementById('vehiclesInactive').checked;
            var showPolylines = document.getElementById('polylines').checked;

            loadMapData(showRequestsPending, showRequestsAccepted, showOffersPending, showOffersAccepted, showVehiclesActive, showVehiclesInactive, showPolylines);
        }

        // Ανανέωση δεδομένων στη βάση
        function updateDatabase() {
            fetch('update_database.php')
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    alert('Η βάση δεδομένων ενημερώθηκε με επιτυχία');
                    applyFilters(); // Φόρτωση δεδομένων μετά την ενημέρωση
                })
                .catch(error => {
                    console.error('Error updating database:', error);
                    alert('Παρουσιάστηκε σφάλμα κατά την ενημέρωση της βάσης δεδομένων');
                });
        }

        // Αρχική φόρτωση δεδομένων
        loadMapData(true, true, true, true, true, true, true);
    </script>
</body>
</html>
