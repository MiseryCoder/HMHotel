let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form = document.getElementById('facility_s_form');
let roomnumber_s_form = document.getElementById('roomnumber_s_form');


//room number
roomnumber_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_roomnumber();
});

function add_roomnumber() {
    let data = new FormData();
    data.append('name', roomnumber_s_form.elements['roomnumber_name'].value);
    data.append('add_roomnumber', '');

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('roomnumber-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {

            alert('success', 'New Room Number added!');
            roomnumber_s_form.elements['roomnumber_name'].value = '';
            get_roomnumber();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

function get_roomnumber() {

    //para maload ung query sa features_facilities.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('roomnumber-data').innerHTML = this.responseText;
    }
    xhr.send('get_roomnumber');
}


function rem_roomnumber(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Room Number removed!');
            get_roomnumber();
        } else if (this.responseText == 'room added') {
            alert('error', 'Cannot Delete! This Room Number is being used in a room!');
        } else {
            alert('error', 'Server down!');
        }
    }

    xhr.send('rem_roomnumber=' + val);
}


//feature
feature_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_feature();
});

function add_feature() {
    let data = new FormData();
    data.append('name', feature_s_form.elements['feature_name'].value);
    data.append('add_feature', '');

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('feature-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {

            alert('success', 'New feature added!');
            feature_s_form.elements['feature_name'].value = '';
            get_features();
        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

function get_features() {

    //para maload ung query sa features_facilities.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('features-data').innerHTML = this.responseText;
    }
    xhr.send('get_features');
}


function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Feature removed!');
            get_features();
        } else if (this.responseText == 'room added') {
            alert('error', 'Cannot Delete! This Feature is being used in a room!');
        } else {
            alert('error', 'Server down!');
        }
    }

    xhr.send('rem_feature=' + val);
}

//facility

facility_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_facility();
});

function add_facility() {
    let data = new FormData();
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc', facility_s_form.elements['facility_desc'].value);
    data.append('add_facility', '');

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('facility-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only SVG images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 1MB!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image upload failes. Server Down!');
        } else {
            alert('success', 'New facility added!');
            facility_s_form.reset();
            get_facilities();
        }

    }
    xhr.send(data);
}

function get_facilities() {

    //para maload ung query sa features_facilities.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('facilities-data').innerHTML = this.responseText;
    }
    xhr.send('get_facilities');
}



function rem_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Facility removed!');
            get_facilities();
        } else if (this.responseText == 'room added') {
            alert('error', 'Facility is added in room!');
        } else {
            alert('error', 'Server down!');
        }
    }

    xhr.send('rem_facility=' + val);
}



window.onload = function() {
    get_features();
    get_facilities();
    get_roomnumber();

}