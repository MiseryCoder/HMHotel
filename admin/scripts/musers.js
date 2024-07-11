//pangkuha sa mngmt page nung nasa table
function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/musers.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('get_users');
}




//dun sa button ng status kung active/inactive
function toggle_status(id, val) {
    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/musers.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Access approval Changed.');
            get_users();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}



function remove_user(room_id) {
    if (confirm("Are you sure you want to remove this user?")) {
        let data = new FormData();
        data.append('id', room_id);
        data.append('remove_user', '');

        //para maload ung query sa ajax/setting_crud.php. Sending data to
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/musers.php", true);

        //para maload ung laman nung sa database
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'User Removed!');
                get_users();
            } else {
                alert('error', 'Failed to Remove the User');
            }
        }
        xhr.send(data);
    }

}


function search_user(username) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/musers.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('search_user&name=' + username);
}

//pang load ulit nung nasa table:>
window.onload = function() {
    get_users();
}