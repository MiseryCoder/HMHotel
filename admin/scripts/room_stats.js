//pangkuha sa mngmt page nung nasa table
function get_bookings(search = '') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_stats.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search=' + search);
}

let house_room_form = document.getElementById('house_room_form');

function update_res(id) {
    house_room_form.elements['room_id'].value = id;
}

house_room_form.addEventListener('submit', function(e) {
    e.preventDefault();


    let data = new FormData();
    data.append('room_id', house_room_form.elements['room_id'].value);
    data.append('rstatus', house_room_form.elements['rstatus'].value);
    data.append('house_room', '');

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_stats.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('house-edit');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'Room Status updated.');
            house_room_form.reset();
            get_bookings();
        } else {
            alert('error', 'Changes are not applied');
        }
    }
    xhr.send(data);
});




//pang load ulit nung nasa table:>
window.onload = function() {
    get_bookings();
}