//pangkuha sa mngmt page nung nasa table
function booking_analytics(period = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        document.getElementById('total_bookings').textContent = data.total_bookings;
        document.getElementById('total_amt').textContent = '₱' + data.total_amt;

        document.getElementById('active_bookings').textContent = data.active_bookings;
        document.getElementById('active_amt').textContent = '₱' + data.active_amt;

        document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
        document.getElementById('cancelled_amt').textContent = '₱' + data.cancelled_amt;

        document.getElementById('req_refund').textContent = data.req_refund;
        document.getElementById('req_refund_amt').textContent = '₱' + data.req_refund_amt;
    }
    xhr.send('booking_analytics&period=' + period);
}

//user analytics
function user_analytics(period = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        document.getElementById('total_new_reg').textContent = data.total_new_reg;
        document.getElementById('total_queries').textContent = data.total_queries;
        document.getElementById('total_review').textContent = data.total_review;

    }
    xhr.send('user_analytics&period=' + period);
}


//pang load ulit nung nasa table:>
window.onload = function() {
    booking_analytics();
    user_analytics();
}