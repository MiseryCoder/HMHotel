<?php
require('include/conn.php');
require('include/essentials.php');

//session nasa include/essential.php
mngmtLogin();
$date = date("Y-m-d");
$lastday = date("Y-m-t", strtotime($date));
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
    <title>HM Hotel | Confirm Upgrade Bookings</title>
</head>

<style>
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


<?php

/*
        Check room id from url if present or not
        Shutdown mode is active or not
        user is login or not
    */


//filter and get room and user data

$checkin_default = "";
$checkout_default = "";

$data = filteration($_GET);

$room_res = select("SELECT * FROM `rooms` WHERE `room_id`=? AND `status`=? AND `removed`=?", [$data['room_id'], 1, 0], 'iii');

$checkin_default = $data['checkin'];
$checkout_default = $data['checkout'];

if (mysqli_num_rows($room_res) == 0) {
    redirect('rooms.php');
}


//for room data to
$room_data = mysqli_fetch_assoc($room_res);

//eto para sa user data
$user_res = select("SELECT *
    FROM `booking_order` AS bo
    INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
    WHERE bo.`booking_id` = ?", [$data['book_id']], 'i');
$booking_data = mysqli_fetch_assoc($user_res);


//for room no
$room_no_query = mysqli_query($con, "SELECT r.room_nos
FROM `room_no` AS r
LEFT JOIN `room_no_data` AS rnd ON r.id = rnd.room_no_id
LEFT JOIN `booking_order` AS bo ON rnd.room_id = bo.room_id
                                  AND bo.check_out > '{$booking_data['check_in']}' AND bo.check_in < '{$booking_data['check_out']}'
WHERE bo.room_id = {$data['room_id']}
   OR bo.booking_status NOT IN ('Booked', 'Reserved', 'Checked-In') limit 1");

$roomno_data = "";

while ($roomno_row = mysqli_fetch_assoc($room_no_query)) {
    $roomno_data = $roomno_row['room_nos'];
}


$_SESSION['room'] = [
    "room_id" => $room_data['room_id'],
    "name" => $room_data['type'],
    "price" => $room_data['price'],
    "payment" => null,
    "available" => null,
];





//check if nag extended na sya nung una o hindi

$extension = "";
$final_price = "";
if ($booking_data['num_of_extensions'] > 0) {
    $final_price = $booking_data['extended_price'];
} else {
    $final_price = 0;
}


$room_identify = "";
//check kung room upgrade ba sya o room change lang
if ($booking_data['price'] == $room_data['price']) {
    $room_identify = "<div class='col-12 px-4'>
                            <p class='fw-bold alert alert-warning'>
                                <i class='bi bi-exclamation-traaingle-fill'></i>
                                Room Change
                                <br>
                            </p>
                        </div>";
} else {
    $room_identify = "<div class='col-12 px-4'>
                            <p class='fw-bold alert alert-warning'>
                                <i class='bi bi-exclamation-traaingle-fill'></i>
                                Room Upgrade
                                <br>
                            </p>
                        </div>";
}

?>


<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <div class="d-flex justify-content-between">

                    <h3 class="mb-3 text-success fw-bold">Confirm Upgrade Bookings</h3>
                </div>

                <div class="row">
                    <!-- content -->

                    <div class="col-lg-7 col-md-12 px-4">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <form action="booking_response.php" method="POST" id="booking_form">
                                    <h6 class="mb-3">BOOKING DETAILS</h6>
                                    <div class="row">

                                        <input hidden name="book_id" value="<?php echo $data['book_id'] ?>">
                                        <input hidden name="room_id" value="<?php echo $data['room_id'] ?>">
                                        <input hidden name="change_payment">
                                        <input hidden name="change_room_type">
                                        <input hidden name="room_no" value="<?php echo $roomno_data ?>">

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name</label>
                                            <input name="name" type="text" value="<?php echo $booking_data['user_name'] ?>" class="form-control shadow-none" required disabled>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input name="phonenum" type="text" value="<?php echo $booking_data['phonenum'] ?>" class="form-control shadow-none" required disabled>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Email</label>
                                            <input name="email" type="email" value="<?php echo $booking_data['email'] ?>" class="form-control shadow-none" required disabled>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Check-in</label>
                                            <!-- Set the min attribute to disable past dates -->
                                            <input type="date" onchange="chk_avail_filter()" value="<?php echo $checkin_default ?>" class="form-control shadow-none" name="checkin" id="checkin" required min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Check-out</label>
                                            <!-- Set the min attribute to disable past dates -->
                                            <input type="date" onchange="chk_avail_filter()" value="<?php echo $checkout_default ?>" class="form-control shadow-none" name="checkout" id="checkout" required min="<?php echo date('Y-m-d'); ?>">
                                        </div>


                                    </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 px-4">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <h3>Billing Breakdown</h3>
                                <?php echo $room_identify ?>
                                <div class="spinner-border text-success mb-3 d-none" id="info_loader" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div style="padding: 10px; max-width: 300px; margin: 0 auto;">
                                    <h6 class="text-danger fw-bold" id="pay_info">
                                        Pick a Payment Method and Provide check-in & check-out date!<br><br>
                                        <span class="text-secondary">Room Type: <span style="float: right;"><?php echo $room_data['type'] ?></span><br>
                                            <span class="text-secondary">Price: <span style="float: right;">₱<?php echo $room_data['price'] ?></span><br>

                                                Discounts: <span style="float: right;"> 0% </span><br>
                                                Booking Fees: <span class="text-secondary" style="float: right;">FREE</span> <br>
                                                Total Amout to Pay: <span style="float: right;"> ₱<?php echo $room_data['price'] ?></span>
                                    </h6>
                                    </h6>
                                </div>
                                <button name="upgradebtn" id="pay_button" class="btn btn-success w-100 shadow-none mb-1" disabled>Upgrade Now</button>

                            </div>
                        </div>
                    </div>

                    </form>

                </div>
            </div>
        </div>


        <!-- JavaScript Bundle with Popper -->


        <!-- alertbox lang to -->

        <?php require('include/scripts.php'); ?>

        <script src="../jquery/jquery-3.5.1.min.js"></script>
        <script src="../css/swiper/swiper-bundle.min.js"></script>
        <script src="../css/bootstrap/bootstrap.js"></script>

        <script>
            let booking_form = document.getElementById('booking_form');
            let info_loader = document.getElementById('info_loader');
            let pay_info = document.getElementById('pay_info');

            var radiobtnOnline = document.getElementById("OnlinePayment");
            var radiobtnCash = document.getElementById("Cash");
            var radiobtn5050 = document.getElementById("fiftyFifty");
            var selectedRadiobtn = document.querySelector('input[name="flexRadioDefault"]:checked');




            function chk_avail_filter() {
                let checkin_val = booking_form.elements['checkin'].value;
                let checkout_val = booking_form.elements['checkout'].value;

                // Check if either check-in or check-out values are not empty
                if (checkin_val !== '' && checkout_val !== '') {
                    check_availability(1);
                }
            }

            // Call chk_avail_filter on page load if both check-in and check-out have values
            window.onload = function() {
                let checkin_val = booking_form.elements['checkin'].value;
                let checkout_val = booking_form.elements['checkout'].value;

                if (checkin_val !== '' && checkout_val !== '') {
                    chk_avail_filter();
                }

                // Call check_availability on page load
                check_availability(1);
            };

            //diable ung room no dropdown pag naka select si "booked" sa booking status

            //check kung available b aung room
            function check_availability(divideValue) {
                let checkin_val = booking_form.elements['checkin'].value;
                let checkout_val = booking_form.elements['checkout'].value;
                booking_form.elements['pay_button'].setAttribute('disabled', true);


                if (checkin_val != '' && checkout_val != '') {
                    pay_info.classList.add('d-none');
                    pay_info.classList.replace('text-dark', 'text-danger');
                    info_loader.classList.remove('d-none');

                    let data = new FormData();

                    data.append('check_room_upgrade', '');
                    data.append('check_in', checkin_val);
                    data.append('check_out', checkout_val);


                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/confirm_booking.php", true);


                    //para maload ung laman nung sa database
                    xhr.onload = function() {
                        let data = JSON.parse(this.responseText);
                        var paymentAmount = data.payment - <?php echo $booking_data['discounted_amt'] ?>;




                        if (data.status == 'check_in_out_equal') {
                            pay_info.innerText = "You cannot Check-out on the same day!";

                        } else if (data.status == 'check_out_earlier') {
                            pay_info.innerText = "Check-out date is Earlier than Check-in Date!";

                        } else if (data.status == 'check_in_earlier') {
                            pay_info.innerText = "Check-in date is Earlier than today's Date!";

                        } else if (data.status == 'unavailable') {
                            pay_info.innerText = "Room not available for this check-in Date!";
                        } else {
                            pay_info.innerHTML =
                                "Previous Bill <br>" +
                                "Room Type: <span class='indented' style='float: right;'><?php echo $booking_data['room_name'] ?></span><br>" +
                                "Room Price: <span class='indented' style='float: right;'>₱<?php echo $booking_data['price'] ?></span><br>" +
                                "Paid Amount: <span class='indented' style='float: right;'>₱<?php echo $booking_data['discounted_amt'] ?></span><br>" +
                                "pending payment:<span class='indented' style='float: right;'>₱<?php echo $final_price ?></span>" +
                                "<hr>New Hotel Bill<br>Room Type: <span class='indented' style='float: right;'><?php echo $room_data['type'] ?></span><br>" +
                                "Room Number: <span style='float: right;'><?php echo $roomno_data ?></span><br>" +
                                "Room Price: <span style='float: right;'>₱<?php echo $room_data['price'] ?></span><br>" +
                                "Check-In: <span class='indented' style='float: right;'>" + data.checkin + "</span><br>" +
                                "Check-Out: <span class='indented' style='float: right;'>" + data.checkout + "</span><br>" +
                                "No. of Days: <span class='indented' style='float: right;'>" + data.days + "</span>" +
                                "<br> Booking Fees: <span class='text-success' style='float: right;'> FREE </span>" +
                                "<br>Total Amount:<span class='indented' style='float: right;'>₱" + data.payment + "</span><hr>" +
                                "<br>Total to Pay:<span class='indented' style='float: right;'>₱" + paymentAmount + "</span>";

                            pay_info.classList.replace('text-danger', 'text-dark');
                            booking_form.elements['upgradebtn'].removeAttribute('disabled');

                            booking_form.elements['change_payment'].value = paymentAmount;
                            booking_form.elements['change_room_type'].value = '<?php echo $room_data['type'] ?>';


                        }

                        pay_info.classList.remove('d-none');
                        info_loader.classList.add('d-none');
                    }

                    xhr.send(data);
                }
            }
        </script>


        <script>
            var swiper = new Swiper(".swiper-container", {
                effect: "fade",
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                }
            });
        </script>
</body>

</html>