<style>
    .nav-pills a {
        text-decoration: none;
        color: white;
    }

    .nav-pills a:hover {
        color: white;
    }

    #dashboard-menu {
        z-index: 1111;
    }

    /* Hide the scroll bar within the navigation bar */
    .navbar::-webkit-scrollbar {
        width: 0.5em;
    }

    .navbar::-webkit-scrollbar-track {
        background-color: transparent;
    }

    .navbar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0);
    }

    .navbar {
        z-index: 1000;
    }

    .modal {
        z-index: 2000;
        /* Ensure the z-index of the modal is higher than the navigation bar */
    }
</style>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php

//eto ung magchecheck ng booking pag hindi dumating si guests tas nagbook magiging no show ung status tsaka checked out nmaan pagtapos na
date_default_timezone_set("Asia/Manila");
$login_type = ""; // Default value

$dateToday = date("Y-m-d H:i:s");
// $sql = "SELECT * FROM booking_order AS bo INNER JOIN booking_details AS bd ON bo.booking_id = bd.booking_id";
// $result = $con->query($sql);

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $id = $row['booking_id'];
//         $checkin_date = $row['check_in'];
//         $checkout_date = $row['check_out'];
//         $expiration_time = $row['expires_time'];
//         $expiration_date = $row['check_out'];
//         $arrival = $row['arrival'];
//         $booking_status = $row['booking_status'];

//         if($row['room_name'] != 'Banquet Hall' || $row['room_name'] != 'Functio Hall'){
//             if (($booking_status == 'Booked' || $booking_status == 'Reserved') && strtotime($expiration_time) <= time() && strtotime($expiration_date) <= strtotime(date("Y-m-d", time()))) {
//                 // Arrival is 0 and check-in date has passed
//                 $status = "No show";
//                 $update_sql = "UPDATE booking_order SET booking_status`='$status' WHERE booking_id`='$id'";
//                 $con->query($update_sql);
//             } elseif ($arrival == 1 && strtotime($checkout_date) < strtotime($dateToday) && $booking_status != "Checked-Out") {
//                 // Arrival is 1 and check-out date has passed
//                 $status = "Checked-Out";
//                 $update_sql = "UPDATE booking_order SET booking_status`='$status' WHERE booking_id`='$id'";
//                 $con->query($update_sql);
//             }
//         }

//     }
// }


// gettingall the rooms for the select tag and input the room types
$roomss = $con->query("SELECT * FROM rooms LIMIT 1");
$room_ress = [];
foreach ($roomss->fetch_all(MYSQLI_ASSOC) as $rows) {
    $room_ress = $rows['room_id'];
}


$calendar_nav = "";
$dashboard_nav = "";
$booking_nav = "";
$bookings_nav = "";
$booking_rec = "";
$rooms_nav = "";
$users_nav = "";
$FaF_nav = "";
$feedbacks = "";
$carousel_nav = "";
$settings_nav = "";
$userq_nav = "";
$ratings_nav = "";
$settings = "";

$btnPR = "";

$dateToday = date("Y-m-d H:i:s");
$sql2 = "SELECT * FROM management_users WHERE `m_id`='$_SESSION[mngmtID]'";
$result2 = $con->query($sql2);



if ($result2->num_rows >= 1) {
    while ($row2 = $result2->fetch_assoc()) {
        $login_type = $row2['m_type'];

        if ($login_type == "Management") {
            echo <<< HTML
                        <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
                            <h4 class="mb-0">HM Hotel</h4>
                            <a href="logout.php" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal"><i class="bi bi-box-arrow-right"></i></a>
                        </div>

                        <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
                        <nav class="navbar navbar-expand-lg navbar-dark " data-spy="scroll" style="overflow-y: auto; overflow-x: hidden; max-height: calc(100vh - 56px);">
                                <div class="container-fluid flex-lg-column align-items-stretch">
                                    <h4 class="mt-2 text-light">$login_type</h4>
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mngmtdropdown" aria-controls="filterdropdown" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="mngmtdropdown">
                                        <ul class="nav nav-pills flex-column">
                                            <li class="nav-item">
                                                <a id="Dactive" class="nav-link" href="Full_calendar.php?room=$room_ress">Calendar</a>
                                            </li>
                                            <li class="nav-item" >
                                                <a id="Dashactive" class="nav-link" href="dashboard.php">Dashboard</a>
                                            </li>
                        
                                            <li class="nav-item">
                                                <!-- <a id="Bactive" class="nav-link" href="#">Booking</a> -->
                                                <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookingLinks">
                                                    <span id="Bactive">Bookings</span>
                                                    <span>
                                                        <i class="bi bi-caret-down-fill"></i>
                                                    </span>
                                                </button>
                        
                                                <div class="collapse show px-3 small mb-1" id="bookingLinks">
                                                    <ul class="nav nav-pills flex-column rounded border border-secondary">
                                                        <li class="nav-item">
                                                            <a id="CNactive" class="nav-link" href="CreateNew_bookings.php">Create New Bookings</a>
                                                        </li>
                                                        <li class="nav-item <?php echo $bookings_nav ?>">
                                                            <a id="Nactive" class="nav-link" href="new_bookings.php">Bookings<span class="ms-1 badge bg-danger" id="noti_number">0</span></a>
                                                        </li>
                                                        <!-- <li class="nav-item">
                                                            <a id="Resactive" class="nav-link" href="res_bookings.php">Reserved Bookings</a>
                                                        </li>-->
                                                        <li class="nav-item <?php echo $booking_rec ?>">
                                                            <a id="BRactive" class="nav-link" href="booking_records.php">Booking Records</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                        
                                            <li class="nav-item">
                                                <!-- <a id="Bactive" class="nav-link" href="#">Booking</a> -->
                                                <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#roomsLinks">
                                                    <span id="ROactive">Rooms</span>
                                                    <span>
                                                        <i class="bi bi-caret-down-fill"></i>
                                                    </span>
                                                </button>
                        
                                                <div class="collapse px-3 small mb-1" id="roomsLinks">
                                                    <ul class="nav nav-pills flex-column rounded border border-secondary">
                                                        <li class="nav-item">
                                                            <a id="RSactive" class="nav-link" href="room_stats.php">Room Status</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="Factive" class="nav-link" href="features_facilities.php">Features & Amenities</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="Ractive" class="nav-link" href="rooms.php">Rooms & Facilities Settings</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                        
                                            <li class="nav-item">
                                                <!-- <a id="Bactive" class="nav-link" href="#">Booking</a> -->
                                                <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#userLinks">
                                                    <span id="USSactive">Users Settings</span>
                                                    <span>
                                                        <i class="bi bi-caret-down-fill"></i>
                                                    </span>
                                                </button>
                        
                                                <div class="collapse px-3 small mb-1" id="userLinks">
                                                    <ul class="nav nav-pills flex-column rounded border border-secondary">
                                                        <li class="nav-item">
                                                            <a id="Uactive" class="nav-link" href="users.php">Guests Users</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="MUactive" class="nav-link" href="management_users.php">Management Users</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                        
                                            <li class="nav-item">
                                                <!-- <a id="Bactive" class="nav-link" href="#">Booking</a> -->
                                                <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#FeedsLinks">
                                                    <div>
                                                        <span id="Feedactive">
                                                            Feedbacks 
                                                        </span>
                                                    
                                                    </div>
                        
                                                    <span>
                                                        <i class="bi bi-caret-down-fill"></i>
                                                    </span>
                                                </button>
                        
                                                <div class="collapse px-3 small mb-1" id="FeedsLinks">
                                                    <ul class="nav nav-pills flex-column rounded border border-secondary">
                                                        <li class="nav-item">
                                                            <a id="USactive" class="nav-link" href="user_queries.php">User Queries</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="RRactive" class="nav-link" href="rate_review.php">Ratings & Reviews</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a id="Bactive" class="nav-link" href="#">Booking</a> -->
                                                <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#setLinks">
                                                    <span id="Setactive">Settings</span>
                                                    <span>
                                                        <i class="bi bi-caret-down-fill"></i>
                                                    </span>
                                                </button>
                        
                                                <div class="collapse px-3 small mb-1" id="setLinks">
                                                    <ul class="nav nav-pills flex-column rounded border border-secondary">
                                                        <li class="nav-item">
                                                            <a id="Cactive" class="nav-link" href="carousel.php">Carousel Settings</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="Sactive" class="nav-link" href="settings.php">Page Settings</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="SLactive" class="nav-link" href="systemlogs.php">System Logs</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    HTML;
        } else if ($login_type == "Front Desk") {
            echo <<< HTML
                        <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
                            <h4 class="mb-0">HM Hotel</h4>
                            <a href="logout.php" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal"><i class="bi bi-box-arrow-right"></i></a>
                        </div>
                        
                        <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
                            <nav class="navbar navbar-expand-lg navbar-dark " data-spy="scroll" style="overflow-y: auto; overflow-x: hidden; max-height: calc(100vh - 56px);">
                                <div class="container-fluid flex-lg-column align-items-stretch">
                                    <h4 class="mt-2 text-light">$login_type</h4>
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mngmtdropdown" aria-controls="filterdropdown" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="mngmtdropdown">
                                        <ul class="nav nav-pills flex-column">
                                            <li class="nav-item">
                                                <a id="Dactive" class="nav-link" href="Full_calendar.php?room=$room_ress">Calendar</a>
                                            </li>
                                            
                                            <li class="nav-item">
                                                <a id="RSactive" class="nav-link" href="room_stats.php">Room Status</a>
                                            </li>

                                            <li class="nav-item">
                                                <a id="CNactive" class="nav-link" href="CreateNew_bookings.php">Create New Bookings</a>
                                            </li>
                                            <li class="nav-item">
                                                <a id="Nactive" class="nav-link" href="res_bookings.php">Bookings<span class="ms-1 badge bg-danger" id="noti_number">0</span></a>
                                            </li>                             
                                            
                                            <li class="nav-item">
                                                <a id="BRactive" class="nav-link" href="booking_records.php">Booking Records</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    HTML;
        } else if ($login_type == "Finance") {
            echo <<< HTML
                        <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
                            <h4 class="mb-0">HM Hotel</h4>
                            <a href="logout.php" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal"><i class="bi bi-box-arrow-right"></i></a>
                        </div>

                        <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
                        <nav class="navbar navbar-expand-lg navbar-dark " data-spy="scroll" style="overflow-y: auto; overflow-x: hidden; max-height: calc(100vh - 56px);">
                                <div class="container-fluid flex-lg-column align-items-stretch">
                                    <h4 class="mt-2 text-light">$login_type</h4>
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mngmtdropdown" aria-controls="filterdropdown" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="mngmtdropdown">
                                        <ul class="nav nav-pills flex-column">
                                            <li class="nav-item" >
                                                <a id="Dashactive" class="nav-link" href="dashboard.php">Dashboard</a>
                                            </li>
                        

                                            <li class="nav-item <?php echo $bookings_nav ?>">
                                                <a id="Nactive" class="nav-link" href="new_bookings.php">Bookings<span class="ms-1 badge bg-danger" id="noti_number">0</span></a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a id="Resactive" class="nav-link" href="res_bookings.php">Reserved Bookings</a>
                                            </li>-->
                                            <li class="nav-item">
                                                <a id="Reactive" class="nav-link" href="refund_bookings.php">Refund Bookings</a>
                                            </li> 
                                            <li class="nav-item <?php echo $booking_rec ?>">
                                                <a id="BRactive" class="nav-link" href="booking_records.php">Booking Records</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    HTML;
        } else {
            echo "error";
        }
    }
}




?>








<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <a href="logout.php" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>

<script>
    function checkLoginToBook(room_id, checkin, checkout) {
        if (room_id) {
            window.location.href = 'confirm_booking.php?room_id=' + room_id + '&checkin=' + checkin + '&checkout=' + checkout;
        } else {
            alert('error', 'Please Login to Book a Room!');
        }
    }

    function checkUpgradeToBook(room_id, checkin, checkout, book_id) {
        if (room_id) {
            window.location.href = 'confirm_room_upgrade.php?room_id=' + room_id + '&checkin=' + checkin + '&checkout=' + checkout +'&book_id=' + book_id;
        } else {
            alert('error', 'Please Login to Book a Room!');
        }
    }
</script>

<script>
    function checkLoginToBookfacility(room_id, checkin) {
        if (room_id) {
            window.location.href = 'confirm_facility.php?room_id=' + room_id + '&checkin=' + checkin + '&checkout=';
        } else {
            alert('error', 'Please Login to Book a Room!');
        }
    }
</script>