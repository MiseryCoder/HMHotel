//pangkuha sa mngmt page nung nasa table
function get_bookings(search = '') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/res_bookings.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings_checkout&search=' + search);
}

function download(id) {
    window.location.href = 'generate_pdf.php?gen_pdf&id=' + id;
}


//pang load ulit nung nasa table:>
window.onload = function() {
    get_bookings();
}