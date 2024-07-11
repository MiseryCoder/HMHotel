function get_systemlogs(page = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/systemlogs.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = data.table_data;
        document.getElementById('table-pagination').innerHTML = data.pagination;
    }

    xhr.send('get_systemlogs&page=' + page);
}

function change_page(page) {
    get_systemlogs(page);
}

// Load initial data
window.onload = function() {
    get_systemlogs();
}