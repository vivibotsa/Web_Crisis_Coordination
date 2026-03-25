<script>
// Δημιουργία χάρτη
var map = L.map('map').setView([38.246242, 21.735085], 13);

// Προσθήκη βασικού χάρτη από το OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Φόρτωση δεδομένων από τη βάση
function loadMapData() {
    fetch('get_map_data.php')
        .then(response => response.json())
        .then(data => {
            
            if (data.error) {
                console.error('Error fetching data:', data.error);
                return;
            }

            // Προσθήκη marker για τη βάση
            if (data.base) {
                var baseMarker = L.marker([data.base.lat, data.base.lng], {draggable: true}).addTo(map)
                    .bindPopup('Βάση διασωστών')
                    .openPopup();

                baseMarker.on('dragend', function(event) {
                    var position = event.target.getLatLng();
                    updateBaseLocation(position.lat, position.lng);
                });
            }

            // Προσθήκη custom icon για τα οχήματα
            var vehicleIcon = L.icon({
                iconUrl: 'vehicle_icon.png',
                iconSize: [38, 38],
                iconAnchor: [22, 22],
                popupAnchor: [-3, -26]
            });

            // Προσθήκη markers για οχήματα
            data.vehicles.forEach(function(vehicle) {
                L.marker([vehicle.lat, vehicle.lng], {icon: vehicleIcon}).addTo(map)
                    .bindPopup(`<b>${vehicle.username}</b><br>Φορτίο: ${vehicle.load}<br>Κατάσταση: ${vehicle.status}<br>Ενεργά tasks: ${vehicle.tasks}`);
            });

            // Προσθήκη custom icons για αιτήματα και προσφορές
            data.requests.forEach(function(request) {
                var iconUrl;
                if (request.status === 'available') {
                    iconUrl = request.type === 'request' ? 'request_accepted_icon.png' : 'offer_accepted_icon.png';
                } else if (request.status === 'pending') {
                    iconUrl = request.type === 'request' ? 'request_pending_icon.png' : 'offer_pending_icon.png';
                }

                var customIcon = L.icon({
                    iconUrl: iconUrl,
                    iconSize: [38, 38],
                    iconAnchor: [22, 22],
                    popupAnchor: [-3, -26]
                });

                L.marker([request.lat, request.lng], {icon: customIcon}).addTo(map)
                    .bindPopup(`<b>${request.username}</b><br>Τηλέφωνο: ${request.phone}<br>Ημερομηνία Καταχώρησης: ${request.date_created}<br>Είδος: ${request.item}<br>Ποσότητα: ${request.quantity}<br>Ημερομηνία Ανάληψης: ${request.date_taken ? request.date_taken : 'Μη αναληφθεί'}<br>Όχημα: ${request.vehicle ? request.vehicle : 'Κανένα'}`);
            });

            // Εμφάνιση κατηγοριών και προϊόντων (προαιρετικά)
            data.categories.forEach(function(category) {
                console.log(`Κατηγορία: ${category.category_name}`);
            });

            data.products.forEach(function(product) {
                console.log(`Προϊόν: ${product.name}, Κατηγορία ID: ${product.category_id}, Ποσότητα: ${product.quantity}`);
            });
        })
        .catch(error => console.error('Error fetching map data:', error));
}

function updateBaseLocation(lat, lng) {
    fetch('update_base_location.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `lat=${lat}&lng=${lng}`
    })
    .then(response => response.text())
    .then(data => {
        console.log('Η τοποθεσία της βάσης ενημερώθηκε με επιτυχία');
    })
    .catch(error => console.error('Error updating base location:', error));
}

// Αρχική φόρτωση δεδομένων
loadMapData();
</script>