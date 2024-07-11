//sa id ni form to ../setting.php
let carousel_s_form = document.getElementById('carousel_s_form');

//eto ung sa modal para sa about us tsaka title ng webpage
let carousel_picture_inp = document.getElementById('carousel_picture_inp');


//pagpinindot na ung save sa modal ni team member
carousel_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_image();
})

//para maadd na sa database ung name and picture ng team member
function add_image() {
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image', '');

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);

    //para maload ung laman nung sa database
    xhr.onload = function() {

        var myModal = document.getElementById('carousel-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG,PNG images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image Should be less than 8MB!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image Upload Failed. Server Down!');
        } else {
            alert('success', 'New Image added!');
            carousel_picture_inp.value = '';
            get_carousel();
        }
    }
    xhr.send(data);
}

//pangkuha sa database para sa pictures and name
function get_carousel() {

    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        document.getElementById('carousel-data').innerHTML = this.responseText;
    }
    xhr.send('get_carousel');
}

function rem_image(val) {
    //para maload ung query sa ajax/setting_crud.php. Sending data to
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //para maload ung laman nung sa database
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Image Removed!');
        } else {
            alert('error', 'Server Down')
        }
        get_carousel();
    }

    xhr.send('rem_image=' + val);
}
//para maview sa pages ung nasa database
window.onload = function() {
    get_carousel();

}