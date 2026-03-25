// Φόρτωση ανακοινώσεων μέσω AJAX
function loadAnnouncements() {
    fetch('fetch_announcements.php')
    .then(response => response.json())
    .then(data => {
        const announcementsBody = document.getElementById('announcements-body');
        announcementsBody.innerHTML = '';
        if (data.length === 0) {
            announcementsBody.innerHTML = '<tr><td colspan="4">Δεν υπάρχουν ανακοινώσεις διαθέσιμες.</td></tr>';
        } else {
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
        }
    })
    .catch(error => {
        console.error('Σφάλμα κατά τη φόρτωση των ανακοινώσεων:', error);
    });
}

// Φόρτωση προσφορών μέσω AJAX
function loadOffers() {
    fetch('fetch_offers.php')
    .then(response => response.json())
    .then(data => {
        const offersBody = document.getElementById('offers-body');
        offersBody.innerHTML = '';
        if (data.length === 0) {
            offersBody.innerHTML = '<tr><td colspan="4">Δεν υπάρχουν προσφορές διαθέσιμες.</td></tr>';
        } else {
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.announcement_title}</td>
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
        }
    })
    .catch(error => {
        console.error('Σφάλμα κατά τη φόρτωση των προσφορών:', error);
    });
}
