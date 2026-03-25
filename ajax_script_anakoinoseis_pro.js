// Συνάρτηση για την αποδοχή προσφοράς
function acceptOffer(offerId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "accept_offer.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert("Η προσφορά έγινε αποδεκτή με επιτυχία.");
                // Εδώ μπορείς να προσθέσεις επιπλέον ενέργειες, όπως ανανέωση της σελίδας ή ενημέρωση της διεπαφής
            } else {
                alert("Σφάλμα: " + response.error);
            }
        }
    };
    
    // Αποστολή των δεδομένων σε μορφή JSON
    var data = JSON.stringify({ offer_id: offerId });
    xhr.send(data);
}