<?php
require('../include/conn.php');

$room_type_choice = $_POST['room_type_choice']; // Corrected variable name

// Replace this query with your actual query to fetch room numbers based on the selected room type
$query = "SELECT r.room_nos 
FROM room_no r
INNER JOIN room_no_data rnd ON r.id = rnd.room_no_id 
INNER JOIN rooms ON rnd.room_id = rooms.room_id 
WHERE rooms.room_id = $room_type_choice";

$res = $con->query($query); // Use $con instead of selectAll

$room_no_options = '<option value="">Select a Room Number</option>';
foreach ($res->fetch_all(MYSQLI_ASSOC) as $row2) {
    $room_no_options .= "<option value='" . $row2['room_id'] . "'>" . $row2['room_nos'] . "</option>";
}

echo $room_no_options;

