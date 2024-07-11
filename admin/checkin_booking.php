<?php
require('include/conn.php');
require('include/essentials.php');

//session nasa include/essential.php
mngmtLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <link rel="icon" type="image" href="../img/logo.png">
    <link rel="stylesheet" href="../css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <title>HM Hotel | Check-in Bookings</title>
</head>

<style>
    .CbActive {
        font-weight: bolder;
        color: #198754;
    }

    .CbAactive:hover,
    {
    color: #198754;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<body>

    <!-- Navigation start -->
    <?php
    require('include/Mnavigation.php');
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `about_details`"));

    $room_type = '';
    $room_type_l = '';
    $room_no = 0;
    $r_type = '';
    $price = '';

    // gettingall the rooms for the select tag and input the room types
    $room = $con->query("SELECT * FROM `rooms`");
    $room_res = [];
    foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
        $r_type = $row['type'];
        $room_res[$row['room_id']] = $row;
        $price = $row['price'];
    }



    // gettingall the rooms for the select tag and input the room types
    $room2 = $con->query("SELECT * FROM `rooms` WHERE `room_id` = '$room_no'");
    $room_res2 = [];
    foreach ($room2->fetch_all(MYSQLI_ASSOC) as $row) {

        $room_res2[$row['room_id']] = $row;
        $room_type_l = $row['type'];
        $room_price = $row['price'];
    }

    //get room numbers room number
    $roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
    INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
    INNER JOIN `rooms` rooms ON rnd.room_id = rooms.room_id
    WHERE rooms.type = '$r_type'");

    $roomno_data = "";

    while ($roomno_row = mysqli_fetch_assoc($roomno_q)) {
        $roomno_data .= "<option value='{$roomno_row['room_nos']}|{$r_type}'>
                        {$roomno_row['room_nos']}                           
                    </option>";
    }



    //for room types
    $room_type = "";


    $room = $con->query("SELECT * FROM `rooms` WHERE `removed` = 0 AND `status` = 1 AND `room_ntype` = 'Room' AND `price` >= $price");

    $room_res = [];
    foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
        $room_type .= "<option value='" . $row['room_id'] . "'>" . $row['type'] . "</option>";
    }

    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <!--<div class="container">-->

                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <?php
                        $sql2 = "SELECT * FROM management_users WHERE `m_id`='$_SESSION[mngmtID]'";
                        $result2 = $con->query($sql2);

                        if ($result2->num_rows >= 1) {
                            while ($row2 = $result2->fetch_assoc()) {
                                $login_type = $row2['m_type'];
                                if ($login_type == "Management") {
                                    echo <<< HTML
                                                        <a class="navbar-brand logo" href="#">
                                                            <b>BOOK STATUS</b>
                                                        </a>
                                                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                                            <span class="navbar-toggler-icon"></span>
                                                        </button>
                                                        <div class="collapse navbar-collapse justify-content-ceter" id="navbarSupportedContent">
                                                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link PBactive" href="new_bookings.php">Pencil Booking</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link Ractive" href="res_bookings.php">Reserved</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link text-success Factive" href="checkin_booking.php"><b>Checked-in</b></a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link AMactive" href="checkout_booking.php">Checked-out</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link Aactive" href="cancelled.php">Cancelled</a>
                                                                </li>
                                                            </ul>
                            
                                                        </div>
                                                    HTML;
                                } else if ($login_type == "Front Desk") {
                                    echo <<< HTML
                                                    <a class="navbar-brand logo" href="#">
                                                        <b>BOOK STATUS</b>
                                                    </a>
                                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>
                                                    <div class="collapse navbar-collapse justify-content-ceter" id="navbarSupportedContent">
                                                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                                                            <li class="nav-item">
                                                                <a class="nav-link Ractive" href="res_bookings.php">Reserved</a>
                                                            </li>
                                        
                                                            <li class="nav-item">
                                                                <a class="nav-link text-success fw-bold Factive" href="checkin_booking.php">Checked-in</a>
                                                            </li>
                        
                                                            <li class="nav-item">
                                                                <a class="nav-link AMactive" href="checkout_booking.php">Checked-out</a>
                                                            </li>
                        
                                                            <li class="nav-item">
                                                                <a class="nav-link Aactive" href="cancelled.php">Cancelled</a>
                                                            </li>
                                                        </ul>
                        
                                                    </div>
                                                HTML;
                                } else if ($login_type == "Finance") {
                                    echo <<<HTML
                                                    <h3 class="mb-3 text-success fw-bold">Pencil Bookings</h3>
                                                HTML;
                                }
                            }
                        }
                        ?>
                    </div>
                </nav>

                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search for Name, OrderID or phone #">
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Booking Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Assign Room Number modal -->

    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">

            <div class="modal-content">
                <form id="assign_room_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Room</h5>
                    </div>
                    <div class="modal-body">
                        <label class="form-label fw-bold">Room type</label>


                        <select name="type" class="shadow-none form-select w-100" id="room_select" name="room">
                            <label class="form-label fw-bold">Room Type</label>
                            <option value="Standard Room">Standard Room</option>
                            <option value="Deluxe Room">Deluxe Room</option>
                            <option value="Suite Room">Suite Room</option>
                            <option value="Bedroom Suite">Bedroom Suite</option>
                            <option value="Presidential Suite">Presidential Suite</option>
                            <option value="Banquet Hall">Banquet Hall</option>
                            <option value="Function Hall">Function Hall</option>
                        </select>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Room Number</label>

                            <select name="room_no" class="form-select shadow-none" id="roomN">
                                <?php
                                $res = selectAll('room_no');
                                while ($opt = mysqli_fetch_assoc($res)) {
                                    $room_nos[] = $opt['room_nos'];
                                    echo "<option value='$row[id]'>$opt[room_nos]</option>";
                                }
                                $room_nos_json = json_encode($room_nos);
                                ?>
                            </select>
                        </div>
                    </div>


                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    <input type="hidden" name="amount_price">
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-success shadow-none">SUBMIT</button>
                    </div>
            </div>
            </form>
        </div>
    </div>



    <div class="modal fade" id="checkout-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">

            <div class="modal-content">
                <form id="checkout_room_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Clear for Check-out</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="amount_price">
                        <span class="d-flex badge rounded-pill bg-success mb-3 text-wrap fs-6 justify-content-center align-items-center lh-base ">
                            Note: Make sure that the Guests are paid and no extra fees upon check out
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-success shadow-none">Check-out</button>
                    </div>
            </div>
            </form>
        </div>
    </div>


    <!-- JavaScript Bundle with Popper -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

    <!-- alertbox lang to -->

    <?php require('include/scripts.php'); ?>

    <script src="scripts/checkin_booking.js" data-room-nos="<?php echo htmlentities($room_nos_json); ?>"></script>
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