//pangkuha sa mngmt page nung nasa table
function get_bookings(search = '') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/refund_bookings.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search=' + search);
}



function refund_booking(id) {
    if (confirm("Refund money for this Booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('refund_booking', '');

        //para maload ung query sa ajax/setting_crud.php. Sending data to
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/refund_bookings.php", true);

        //para maload ung laman nung sa database
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'Booking Refunded!');
                get_bookings();
            } else {
                alert('error', 'Server Down!');
            }
        }
        xhr.send(data);
    }
}




//pang load ulit nung nasa table:>
window.onload = function() {
    get_bookings();
}