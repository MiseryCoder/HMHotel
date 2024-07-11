<?php
require('include/conn.php');
require('include/essentials.php');

date_default_timezone_set("Asia/Manila");

//session nasa include/essential.php
mngmtLogin();

$room_type = '';
$room_type_l = '';
$room_price = 0;
$first_room = 0;
$room_no = 0;

// gettingall the rooms for the select tag and input the room types
$room = $con->query("SELECT * FROM `rooms` WHERE `removed` = 0 AND `status` = 1");
$room_res = [];
foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {

    $room_type .= "<option value='" . $row['room_id'] . "'>" . $row['type'] . "</option>";

    $room_res[$row['room_id']] = $row;
}


if (isset($_GET['room'])) {
    $room_no = $_GET['room'];
} else {
    $room_no = 0;
}

if ($room_no == '99999') {
    $first_room = "booking_order.room_id IN (SELECT DISTINCT room_id FROM booking_order)";
} else {
    $first_room = "booking_order.room_id = '$room_no'";
}



// getting all the rooms for the select tag and input the room types
$room2 = $con->query("SELECT * FROM `rooms` WHERE `room_id` = '$room_no'");
$room_res2 = [];
foreach ($room2->fetch_all(MYSQLI_ASSOC) as $row) {

    $room_res2[$row['room_id']] = $row;
    $room_type_l = $row['type'];
    $room_price = $row['price'];
}



$schedules = $con->query("SELECT * FROM booking_details 
            INNER JOIN booking_order ON booking_details.booking_id = booking_order.booking_id  
            WHERE $first_room");
$sched_res = [];
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
    $row['sdate'] = date("Y-m-d H:i:s", strtotime($row['check_in']));
    $row['edate'] = date("Y-m-d H:i:s", strtotime($row['check_out']));
    $row['status'] = $row['booking_status'];
    $sched_res[$row['booking_id']] = $row;
}


//lagay sa session ung data para pag pumunta na sa ajax/confirm.php makukuha nya ung data
$_SESSION['room'] = [
    "room_id" => $first_room,
    "name" => !empty($room_type_l) ? $room_type_l : "",
    "price" => $room_price,
    "payment" => null,
    "available" => null,
];



//get room numbers room number
$roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                WHERE rnd.room_id = '$room_no'");

$roomno_data = "";

while ($roomno_row = mysqli_fetch_assoc($roomno_q)) {
    $roomno_data .= "<option value='" . $roomno_row['room_nos'] . "'>
                    $roomno_row[room_nos]                            
                </option>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        #Dactive {
            font-weight: bolder;
            color: #198754;
        }

        #Dactive:hover {
            color: #198754;
        }

        .center-select {
            display: flex;
            justify-content: center;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }

        #calendar button {

            background-color: #198754;
            /* Replace with your desired color */

            color: #ffffff;
            /* Replace with your desired text color */

            /* Remove the shadow */
            box-shadow: none;

            /* Remove the border */
            border: none;

        }

        @media only screen and (max-width: 900px) {
            #calendar button {}
        }

        @media only screen and (max-width: 768px) {
            #calendar button {
                font-size: 10px;
                /* Adjust the font size for smaller screens */
            }
        }




        #calendar button:focus {
            border: 2px solid #000;
            /* Replace with your desired border color */
        }

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }

        .legend-tooltip {
            position: relative;
            display: inline-block;
        }

        .legend-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            background-color: #212529;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            top: 100%;
            left: 70%;
            transform: translateX(-50%);
            white-space: nowrap;
            z-index: 1000;
            /* Set a higher z-index value */
        }
    </style>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <link rel="icon" type="image" href="../img/logo.png">
    <link rel="stylesheet" href="../css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="./include/fullcalendar/lib/main.min.css">
    <script src="./include/fullcalendar/lib/main.min.js"></script>

    <title>HM Hotel | Calendar</title>


</head>

<body>
    <?php
    require('include/Mnavigation.php');

    //pagshinutdown ang website
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `about_details`"));
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="container m-0 p-0">
                    <div class="row">
                        <div class="col-lg-9 col-md-12">
                            <!-- calendar -->
                            <form id="room_select_form">
                                <div class="row mb-2 justify-content-end mt-2">
                                    <div class="form-group">

                                        <select class="shadow-none form-select w-100" id="room_select" name="room">
                                            <?php echo $room_type ?>
                                        </select>

                                    </div>
                                </div>
                            </form>
                            <div id="calendar"></div>
                        </div>



                        <!-- Legend and Tooltip -->
                        <div class="col-lg-3 col-md-12 px-4">
                            <div class="card border-0 shadow-sm rounded-3 mb-3">
                                <div class="card-body">
                                    <h6 class="mb-6">Legend:</h6>

                                    <div class="legend-tooltip" data-tooltip="An act of Reserving">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: #198754; margin-right: 5px;"></span>Booked<br>
                                    </div><br>

                                    <div class="legend-tooltip" data-tooltip="Confirmation of Booked">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: black; margin-right: 5px;"></span>Reserved<br>
                                    </div><br>

                                    <div class="legend-tooltip" data-tooltip="Guest arrive at Hotel">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: #ffc107; margin-right: 5px;"></span>Checked In<br>
                                    </div><br>

                                    <div class="legend-tooltip" data-tooltip="Guest leaving at Hotel">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: #C107FF; margin-right: 5px;"></span>Checked Out<br>
                                    </div><br>

                                    <div class="legend-tooltip" data-tooltip="Guest does not show up ">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: #0dcaf0; margin-right: 5px;"></span>No Show<br>
                                    </div><br>

                                    <div class="legend-tooltip" data-tooltip="An act of completely stop Booking">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: #dc3545; margin-right: 5px;"></span>Cancelled<br>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Legend and Tooltip -->


                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body">
                                    <?php
                                    $date = date("Y-m-d H:i:s");
                                    $nxt_day = date("Y-m-d H:i:s", strtotime($date . " +1 day"));
                                    $lastday = date("Y-m-t", strtotime($date));
                                    

                                    $room_types = array(); // Array to store unique room types
                                    $room_quantities = array(); // Array to store unique room types
                                    $card_counter = 0; // Counter for cards printed in the current row

                                    // Fetch all room data from the database
                                    $room = $con->query("SELECT * FROM `rooms`");

                                    echo <<<data
                                            <h6 class="text-center fw-bold">Room Analytics</h6>
                                            <table class="table table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Room Name</th>
                                                        <th>Available</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            data;

                                    // Loop through each room and create rows for each room type
                                    foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
                                        $room_type = $row['type'];
                                        $room_quan = $row['quantity'];

                                        // Check if the room type has already been processed
                                        if (!in_array($room_type, $room_types)) {
                                            $room_types[] = $room_type; // Add the room type to the array of processed types

                                            // Use a prepared statement to avoid SQL injection
                                            $stmt = $con->prepare("
                                            SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
                                            WHERE (booking_status='Booked' OR booking_status='Reserved' OR booking_status='Checked-In')
                                            AND room_id = ?
                                            AND check_out > '$date' AND check_in < '$nxt_day'

                                            ");

                                            // Bind the room_id parameter
                                            $stmt->bind_param('i', $row['room_id']);

                                            // Execute the query
                                            $stmt->execute();

                                            // Get the result
                                            $occupied_result = $stmt->get_result();
                                            $occupied_row = $occupied_result->fetch_assoc();
                                            $room_occupied = $occupied_row['total_bookings'];
                                            $room_available = $room_quan - $room_occupied;

                                            $availability_text = ($room_available <= 0) ? "Fully Booked" : $room_available;

                                            // Close the statement
                                            $stmt->close();

                                            echo <<<data
                                                <tr class="text-center">
                                                    <td>$room_type</td>
                                                    <td>$availability_text</td>
                                                </tr>
                                            data;
                                        }
                                    }

                                    echo <<<data
                                                </tbody>
                                            </table>
                                            data;
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Room Type</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Booking Status</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Check-In Date</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">Check-out Date</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

    <!-- json encode of calendar -->
    <script>
        var scheds = <?= json_encode($sched_res) ?>;

        var calendar;
        var Calendar = FullCalendar.Calendar;
        var events = [];
        $(function() {
            if (!!scheds) {
                Object.keys(scheds).map(k => {
                    var row = scheds[k];
                    events.push({
                        id: row.booking_id,
                        title: row.user_name + ' - ' + row.booking_status,
                        title2: row.booking_status, // Add title2 property to store booking_status
                        start: row.check_in,
                        end: row.check_out
                    });
                });
            }

            var date = new Date();
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();

            calendar = new Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,list'
                },

                selectable: true,
                themeSystem: 'bootstrap',
                // Random default events
                events: events,
                eventClick: function(info) {
                    var _details = $('#event-details-modal')
                    var id = info.event.id
                    if (!!scheds[id]) {
                        _details.find('#title').text(scheds[id].room_name)
                        _details.find('#description').text(scheds[id].booking_status)
                        _details.find('#name').text(scheds[id].user_name)
                        _details.find('#start').text(scheds[id].sdate)
                        _details.find('#end').text(scheds[id].edate)
                        _details.find('#edit,#delete').attr('data-id', id)
                        _details.modal('show')
                    } else {
                        alert("Event is undefined");
                    }
                },
                eventDidMount: function(info) {
                    const event = info.event;
                    if (!event || !event.extendedProps) {
                        // Handle the case where the event or extendedProps is null
                        return;
                    }

                    const bookingStatus = event.extendedProps.title2;
                    const eventTitleElement = info.el.querySelector('.fc-event-main, .fc-list-event-time');

                    if (!eventTitleElement) {
                        // Handle the case where eventTitleElement is null
                        return;
                    }

                    if (bookingStatus === 'No show') {
                        eventTitleElement.style.backgroundColor = '#0dcaf0';
                        eventTitleElement.style.color = '#000';
                    } else if (bookingStatus === 'Booked') {
                        eventTitleElement.style.backgroundColor = '#198754';
                        eventTitleElement.style.color = '#fff';
                    } else if (bookingStatus === 'Checked-In') {
                        eventTitleElement.style.backgroundColor = '#ffc107';
                        eventTitleElement.style.color = '#000';
                    } else if (bookingStatus === 'Checked-Out') {
                        eventTitleElement.style.backgroundColor = '#C107FF';
                        eventTitleElement.style.color = '#fff';
                    } else if (bookingStatus === 'Reserved') {
                        eventTitleElement.style.backgroundColor = '#000';
                        eventTitleElement.style.color = '#fff';
                    } else {
                        eventTitleElement.style.backgroundColor = '#dc3545';
                        eventTitleElement.style.color = '#fff';
                    }
                },

                editable: true
            });

            calendar.render();
        });
    </script>

    <?php require('include/scripts.php'); ?>


    <!-- ajax -->
    <script>
        //for the dropdown
        $("#room_select").change(function() {
            $("#room_select_form").submit();
        });


        $("#room_select option[value='<?php echo $room_no; ?>']").attr('selected', 'selected');


        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        var radiobtnOnline = document.getElementById("OnlinePayment");
        var radiobtnCash = document.getElementById("Cash");
        var radiobtn5050 = document.getElementById("fiftyFifty");
        var selectedRadiobtn = document.querySelector('input[name="flexRadioDefault"]:checked');



        //radio button ng payment
        function PaymentMethod() {
            var divideValue;
            var pay_button = document.getElementById("pay_button");;
            var selectedRadio = document.querySelector('input[name="flexRadioDefault"]:checked');


            if (selectedRadio && selectedRadio.id === "fiftyFifty") {
                check_availability(2); // Pass the divide value as 2
            } else {
                check_availability(1); // Pass the divide value as 1
            }

        }

        //diable ung room no dropdown pag naka select si "booked" sa booking status
        function toggleRoomDropdown(status) {
            var roomDropdown = document.getElementById("roomN");
            if (status === "Booked") {
                roomDropdown.disabled = true;
            } else {
                roomDropdown.disabled = false;
            }
        }

        //check kung available b aung room
        function check_availability(divideValue) {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            booking_form.elements['pay_button'].setAttribute('disabled', true);

            var selectedRadio;
            if (radiobtnOnline.checked) {
                selectedRadio = 'online';
            } else if (radiobtnCash.checked) {
                selectedRadio = 'cash';
            } else if (radiobtn5050.checked) {
                selectedRadio = 'fiftyFifty';
            }

            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);


                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);


                //para maload ung laman nung sa database
                xhr.onload = function() {
                    let data = JSON.parse(this.responseText);
                    var paymentAmount;

                    if (divideValue === 2) {
                        paymentAmount = data.payment / 2;
                    } else {
                        paymentAmount = data.payment;
                    }

                    if (data.status == 'check_in_out_equal') {
                        pay_info.innerText = "You cannot Check-out on the same day!";

                    } else if (data.status == 'check_out_earlier') {
                        pay_info.innerText = "Check-out date is Earlier than Check-in Date!";

                    } else if (data.status == 'check_in_earlier') {
                        pay_info.innerText = "Check-in date is Earlier than today's Date!";

                    } else if (data.status == 'unavailable') {
                        pay_info.innerText = "Room not available for this check-in Date!";
                    } else {
                        pay_info.innerHTML = "No. of Days: " + data.days + "<br>Total Amount to Pay: ₱" + paymentAmount;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        booking_form.elements['pay_button'].removeAttribute('disabled');

                    }

                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }

                xhr.send(data);
            }
        }
    </script>


</body>

<script>
    function loadDoc() {
        setInterval(function() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("noti_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "include/notifications/bookings.php", true);
            xhttp.send();
        }, 1000);
    }
    loadDoc();
</script>

</html>