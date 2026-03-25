<?php
    include("database.php"); //gia na syndethoume me th vash
?>

<!DOCTYPE html>
<html lang="el">
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 50%;
        }
    </style>
    <title>Πλατφόρμα συντονισμού εθελοντών</title>
</head>
<body>
    <center>
    <h1>Εγγραφή</h1><br>
    <h3>Παρακαλώ συμπληρώστε τα παρακάτω στοιχεία.</h3>
    
    <form action="register.php" method="POST">

    <label for="username">Όνομα χρήστη:</label>
    <input type="text" id="username" name="username" minlength="4" maxlength="15" required>
    <br><br>

    <label for="password">Κωδικός:</label>
    <input type="password" id="password" name="password" minlength="4" maxlength="15" required>
    <br><br>

    <label for="fullname">Oνοματεπώνυμο:</label>
    <input type="text" id="fullname" name="fullname" minlength="8" maxlength="30" required>
    <br><br>

    <label for="phone">Τηλέφωνο:</label>
    <input type="digit" id="phone" name="phone" minlength="10" maxlength="10" required>
    <br><br>

    <div id="map"></div>
    <input type="hidden" id="latitude" name="latitude">
    <input type="hidden" id="longitude" name="longitude">

    <a href="poliths.php">
    <button>Εγγραφή</button></a>
    <br><br>

    Έχετε ήδη λογαριασμό;
    <a href="login.php"<button>Είσοδος</button></a>

    </form>
    </center>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([38.246242, 21.7350847], 13); // Default center point (e.g., Patras, Greece)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
    <script type = "text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
        $password=filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
        $fullname = filter_input(INPUT_POST, "fullname", FILTER_SANITIZE_SPECIAL_CHARS);
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        if(empty($username)){
            echo"Παρακαλώ πρόσθεσε ένα username";
        }
        elseif(empty($password)){
            echo"Παρακαλώ πρόσθεσε έναν κωδικό";
        }
        elseif(empty($phone)){
            echo"Παρακαλω πρόσθεσε τον αριθμό τηλεφώνου σου";
        }
        elseif (empty($latitude) || empty($longitude)) {
            echo "Παρακαλώ πρόσθεσε την τοποθεσία σου";
        }
        elseif(empty($fullname)){
            echo"Παρακαλώ πρόσθεσε το ονοματεπώνυμο σου";
        }
        else{// Check if the username already exists in the database
        $check_query = "SELECT * FROM register_polites WHERE username='$username'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            echo "Το username χρησιμοποιείται ήδη!";
        }
          else {
            // Το username δεν χρησιμοποιείται, προχωράμε στην εισαγωγή
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO register_polites (username, password,fullname,phone,latitude, longitude) 
                    VALUES ('$username', '$hash','$fullname','$phone','$latitude', '$longitude')";
              try {
                mysqli_query($conn, $sql);
                echo "Η εγγραφή σου πραγματοποιήθηκε με επιτυχία!";
                header("Location: logged_in.php");
                exit(); // Σταματά την εκτέλεση του υπόλοιπου κώδικα
            } catch (mysqli_sql_exception $e) {
                echo "Σφάλμα κατά την εγγραφή: " . $e->getMessage();
            }
               }
}
    }
    
    mysqli_close($conn);
?>