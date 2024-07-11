let general_data, contacts_data;

//sa id ni form to ../setting.php
let general_s_form = document.getElementById('general_s_form');
let contacts_s_form = document.getElementById('contacts_s_form');
let team_s_form = document.getElementById('team_s_form');

//eto ung sa modal para sa about us tsaka title ng webpage
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');
let site_mission_inp = document.getElementById('site_mission_inp');
let site_vision_inp = document.getElementById('site_vision_inp');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');



//pangkuha to ng data sa database -> for website title & about us
function get_general() {
    //sa mismong site to > sa General setting
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');
    let site_mission = document.getElementById('site_mission');
    let site_vision = document.getElementById('site_vision');

    //sa shutdown toggle
    let shutdown_toggle = document.getElementById('shutdown-toggle');
    let payment_toggle = document.getElementById('payment-toggle');



    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        general_data = JSON.parse(this.responseText);

        //sa mismong site (General settings). Ung sa text to para maload
        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;
        site_mission.innerText = general_data.site_mission;
        site_vision.innerText = general_data.site_vision;

        //ung sa modal na input
        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;
        site_mission_inp.value = general_data.site_mission;
        site_vision_inp.value = general_data.site_vision;

        //ung satoggle button para magupdate value based sa nakalagay sa database
        if (general_data.shutdown == 0) {
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0;
        } else {
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1;
        }

        if (general_data.Online_payment == 0) {
            payment_toggle.checked = false;
            payment_toggle.value = 0;
        } else {
            payment_toggle.checked = true;
            payment_toggle.value = 1;
        }
    }
    xhr.send('get_general');
}

//pagpinindot ung save sa modal
general_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value, site_mission_inp.value, site_vision_inp.value); //pangsend ng value sa upd_general function
})

//update for about and website title
function upd_general(site_title_val, site_about_val, site_mission_val, site_vision_val) {
    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('general-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {

            alert('success', 'Changes saved!');
            get_general();
        } else {
            alert('error', 'No changes made!');
        }
    }
    xhr.send('site_title=' + site_title_val + '&site_about=' + site_about_val + '&site_mission=' + site_mission_val + '&site_vision=' + site_vision_val + '&upd_general');
}


//kung on or off muna ung transaction sa website
function upd_shutdown(val) {
    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database sa include/script.php
    xhr.onload = function() {
        if (this.responseText == 1 && general_data.shutdown == 0) {

            alert('error', 'Website`s Reservations has been shutdown!');
        } else {
            alert('success', 'Reservations is now running again');
        }
        get_general();
    }
    xhr.send('upd_shutdown=' + val);
}


//kung on or off muna ung Online transaction sa website
function upd_payment(val) {
    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database sa include/script.php
    xhr.onload = function() {
        if (this.responseText == 1 && general_data.Online_payment == 0) {

            alert('success', 'Online Payment is now running again');
        } else {
            alert('error', 'Website`s Online payment is turned off!');
        }
        get_general();
    }
    xhr.send('upd_payment=' + val);
}


//pangkuha to ng data sa database -> for contacts
function get_contacts() {

    let contacts_p_id = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'ig', 'tw'];
    let iframe = document.getElementById('iframe');

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        contacts_data = JSON.parse(this.responseText);
        contacts_data = Object.values(contacts_data);

        for (i = 0; i < contacts_p_id.length; i++) {
            document.getElementById(contacts_p_id[i]).innerHTML = contacts_data[i + 1];
        }

        iframe.src = contacts_data[9];

        contacts_inp(contacts_data);
    }
    xhr.send('get_contacts');
}


//panlagay ng mga data sa modal, inputs
function contacts_inp(data) {
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'ig_inp', 'tw_inp', 'iframe_inp'];

    for (i = 0; i < contacts_inp_id.length; i++) {
        document.getElementById(contacts_inp_id[i]).value = data[i + 1];
    }
}

//pagpinindot na ung save sa contacts
contacts_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    upd_contacts();
})


//pang update sa contacts
function upd_contacts() {
    let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'ig', 'tw', 'iframe'];
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'ig_inp', 'tw_inp', 'iframe_inp'];

    let data_str = "";

    for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';

    }
    data_str += "upd_contacts";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        var myModal = document.getElementById('contacts-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Changes saved!');
            get_contacts();
        } else {
            alert('error', 'No changes made!');
        }

    }
    xhr.send(data_str);
}

//pagpinindot na ung save sa modal ni team member
team_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_member();
})

//para maadd na sa database ung name and picture ng team member
function add_member() {
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('team-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG,PNG images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image Should be less than 2MB!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image Upload Failed. Server Down!');
        } else {
            alert('success', 'New member added!');
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members();
        }
    }
    xhr.send(data);
}

//pangkuha sa database para sa pictures and name
function get_members() {

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('team-data').innerHTML = this.responseText;
    }
    xhr.send('get_members');
}

function rem_member(val) {
    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Member Removed!');
        } else {
            alert('error', 'Server Down')
        }
        get_members();
    }

    xhr.send('rem_member=' + val);
}
//para maview sa pages ung nasa database
window.onload = function() {
    get_general();
    get_contacts();
    get_members();

}