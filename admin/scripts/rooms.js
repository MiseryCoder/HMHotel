let add_room_form = document.getElementById('add_room_form');

add_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_rooms();
});

//pang add ng rooms
function add_rooms() {
    let data = new FormData();
    data.append('add_room', '');
    data.append('room_category', add_room_form.elements['room_category'].value);
    data.append('type', add_room_form.elements['type'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('desc', add_room_form.elements['desc'].value);


    let room_nos = [];
    let roomNosCollection = add_room_form.elements['room_nos'];

    // Check if roomNosCollection is iterable
    if (roomNosCollection.length !== undefined) {
        // Convert the collection to an array and then use forEach
        Array.from(roomNosCollection).forEach(el => {
            if (el.checked) {
                room_nos.push(el.value);
            }
        });
    } else {
        // Handle the case where it's not iterable (e.g., it's a single element)
        if (roomNosCollection.checked) {
            room_nos.push(roomNosCollection.value);
        }
    }



    // With this block
    let features = [];
    let featuresCollection = add_room_form.elements['features'];

    // Check if featuresCollection is iterable
    if (featuresCollection.length !== undefined) {
        // Convert the collection to an array and then use forEach
        Array.from(featuresCollection).forEach(el => {
            if (el.checked) {
                features.push(el.value);
            }
        });
    } else {
        // Handle the case where it's not iterable (e.g., it's a single element)
        if (featuresCollection.checked) {
            features.push(featuresCollection.value);
        }
    }

    let facilities = [];
    let facilitiesCollection = add_room_form.elements['facilities'];

    // Check if facilitiesCollection is iterable
    if (facilitiesCollection.length !== undefined) {
        // Convert the collection to an array and then use forEach
        Array.from(facilitiesCollection).forEach(el => {
            if (el.checked) {
                facilities.push(el.value);
            }
        });
    } else {
        // Handle the case where it's not iterable (e.g., it's a single element)
        if (facilitiesCollection.checked) {
            facilities.push(facilitiesCollection.value);
        }
    }



    data.append('room_nos', JSON.stringify(room_nos));
    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('add-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {

            alert('success', 'New Room added!');
            add_room_form.reset();
            get_all_rooms();

        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

//pangkuha sa mngmt page nung nasa table
function get_all_rooms() {
    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('room-data').innerHTML = this.responseText
    }
    xhr.send('get_all_rooms');
}

//pang edit nung details sa room na in-add
let edit_room_form = document.getElementById('edit_room_form');

function edit_details(id) {
    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        let data = JSON.parse(this.responseText);

        edit_room_form.elements['type'].value = data.roomdata.type;
        edit_room_form.elements['room_category'].value = data.roomdata.room_ntype;
        edit_room_form.elements['area'].value = data.roomdata.area;
        edit_room_form.elements['price'].value = data.roomdata.price;
        edit_room_form.elements['quantity'].value = data.roomdata.quantity;
        edit_room_form.elements['adult'].value = data.roomdata.adult;
        edit_room_form.elements['children'].value = data.roomdata.children;
        edit_room_form.elements['desc'].value = data.roomdata.description;
        edit_room_form.elements['room_id'].value = data.roomdata.room_id;

        edit_room_form.elements['room_nos'].forEach(el => {
            if (data.room_nos.includes(Number(el.value))) {
                el.checked = true;
            }
        });

        edit_room_form.elements['features'].forEach(el => {
            if (data.features.includes(Number(el.value))) {
                el.checked = true;
            }
        });

        edit_room_form.elements['facilities'].forEach(el => {
            if (data.facilities.includes(Number(el.value))) {
                el.checked = true;
            }
        });

    }
    xhr.send('get_room=' + id);
}

edit_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit_edit_rooms();
});


//pang edit ng rooms
function submit_edit_rooms() {
    let data = new FormData();
    data.append('edit_room', '');
    data.append('room_id', edit_room_form.elements['room_id'].value);
    data.append('room_category', edit_room_form.elements['room_category'].value);
    data.append('type', edit_room_form.elements['type'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['children'].value);
    data.append('desc', edit_room_form.elements['desc'].value);


    let room_nos = [];

    edit_room_form.elements['room_nos'].forEach(el => {
        if (el.checked) {
            room_nos.push(el.value);
        }
    });

    let features = [];

    edit_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];

    edit_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('room_nos', JSON.stringify(room_nos));
    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('edit-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {

            alert('success', 'Room Data Edited!');
            edit_room_form.reset();
            get_all_rooms();

        } else {
            alert('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

//pang load nung nasa table
window.onload = function() {
    get_all_rooms();
}

//dun sa button ng status kung active/inactive
function toggle_status(id, val) {
    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText) {
            alert('success', 'Status toggled!');
            get_all_rooms();
        } else {
            alert('success', 'Server Down!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

let add_image_form = document.getElementById('add_image_form');

add_image_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_image();
});

//para maadd na sa database ung name and picture ng mga rooms
function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);
    data.append('add_image', '');

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG, PNG or WEBP images are allowed!', 'image-alert');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image Should be less than 8MB!', 'image-alert');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image Upload Failed. Server Down!', 'image-alert');
        } else {
            alert('success', 'New Image added!', 'image-alert');
            room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText);
            add_image_form.reset();
        }
    }
    xhr.send(data);
}

function room_images(id, rname) {
    document.querySelector("#room-images .modal-title").innerText = rname;
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = '';

    //para maload ung query sa ajax/features_facilities.php Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('room-image-data').innerHTML = this.responseText;
    }
    xhr.send('get_room_images=' + id);

}

function rem_image(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('rem_image', '');

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Image Removed!', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } else {
            alert('error', 'Image Removal Failed', 'image-alert');
        }
    }
    xhr.send(data);
}


function thumb_image(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('thumb_image', '');

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Image Thumbnail Checked!', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } else {
            alert('error', 'Setting Thumbnail Failed', 'image-alert');
        }
    }
    xhr.send(data);
}


function remove_room(room_id) {
    if (confirm("Are you sure you want to delete this room?")) {
        let data = new FormData();
        data.append('room_id', room_id);
        data.append('remove_room', '');

        //para maload ung query sa ajax/setting_crud.php. Sending data to
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);

        //para maload ung laman nung sa database
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'Room Removed!');
                get_all_rooms();
            } else {
                alert('error', 'Failed to Remove the Room');
            }
        }
        xhr.send(data);
    }

}

//pang load ulit nung nasa table:>
window.onload = function() {
    get_all_rooms();
}