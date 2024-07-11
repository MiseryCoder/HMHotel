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
    <title>HM Hotel | Reserved Bookings</title>
</head>

<style>
    .Ractive {
        font-weight: bolder;
        color: #198754;
    }

    .Ractive:hover,
    {
    color: #198754;
    }

    #Nactive {
        font-weight: bolder;
        color: #198754;
    }

    #Nactive:hover {
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
                                                                    <a class="nav-link text-success Ractive" href="res_bookings.php">Reserved</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link Factive" href="checkin_booking.php">Checked-in</a>
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
                                                                <a class="nav-link text-success Ractive" href="res_bookings.php">Reserved</a>
                                                            </li>
                                        
                                                            <li class="nav-item">
                                                                <a class="nav-link text-success Factive" href="checkin_booking.php">Checked-in</a>
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
                                        echo <<< HTML
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
                            <h5 class="modal-title">Assign Room</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="booking_id">
                            <input type="hidden" name="room_id">
                            <input type="hidden" name="amount_price">
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
                            <span class="d-flex badge rounded-pill bg-success mb-3 text-wrap justify-content-center align-items-center lh-base ">
                                Note: Assign The room when the guests arrived at the hotel.
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                            <button type="submit" class="btn btn-success shadow-none">SUBMIT</button>
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

        <script src="scripts/res_bookings.js" data-room-nos="<?php echo htmlentities($room_nos_json); ?>"></script>
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
</body>

</html>