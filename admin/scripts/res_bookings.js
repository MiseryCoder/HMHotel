//pangkuha sa mngmt page nung nasa table
function get_bookings(search = '') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/res_bookings.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search=' + search);
}

let assign_room_form = document.getElementById('assign_room_form');
var room_no = document.getElementById('roomN');
let room_nos = JSON.parse(document.currentScript.getAttribute('data-room-nos'));

function assign_room(id, room_id, amount) {
    assign_room_form.elements['booking_id'].value = id;
    assign_room_form.elements['room_id'].value = room_id;
    assign_room_form.elements['amount_price'].value = amount;

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/res_bookings.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        let data = JSON.parse(this.responseText);


        room_no.innerHTML = ""; // Clear the existing options

        data.room_nos.forEach(roomNumber => {
            let option = document.createElement("option");
            option.text = roomNumber;
            option.value = roomNumber;
            room_no.add(option);
        });
    }
    xhr.send('get_room=' + room_id);
}

assign_room_form.addEventListener('submit', function(e) {
    e.preventDefault();


    let data = new FormData();
    data.append('room_no', assign_room_form.elements['room_no'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('amount_price', assign_room_form.elements['amount_price'].value);
    data.append('assign_room', '');

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/res_bookings.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'Room Number Alloted! Booking Finalized!');
            assign_room_form.reset();
            get_bookings();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
});


function cancel_booking(id) {
    if (confirm("Are you sure, you want to cancel this Booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('cancel_booking', '');

        //para maload ung query sa ajax/setting_crud.php. Sending data to
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/res_bookings.php", true);

        //para maload ung laman nung sa database
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'Booking Cancelled!');
                get_bookings();
            } else {
                alert('error', 'Server Dowwn!');
            }
        }
        xhr.send(data);
    }
}




//pang load ulit nung nasa table:>
window.onload = function() {
    get_bookings();
}