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
    <title>HM Hotel | Confirm New Bookings</title>
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

if (mysqli_num_rows($room_res) == 0) {
    redirect('checkin_booking.php');
}

$room_data = mysqli_fetch_assoc($room_res);

$_SESSION['room'] = [
    "room_id" => $room_data['room_id'],
    "name" => $room_data['type'],
    "price" => $room_data['price'],
    "payment" => null,
    "available" => null,
];



$user_res = select("SELECT *
    FROM `booking_order` AS bo
    INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
    WHERE bo.`booking_id` = ?", [$data['book_id']], 'i');


$booking_data = mysqli_fetch_assoc($user_res);

// Fetch room numbers
$roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                WHERE rnd.room_id = '$room_data[room_id]'");


$room_numbers = ""; // Initialize room numbers variable

if ($roomno_q && mysqli_num_rows($roomno_q) > 0) {
    // Fetch the associative array for room numbers
    $roomno_row = mysqli_fetch_assoc($roomno_q);

    // Check if 'room_nos' exists in the fetched row
    if (isset($roomno_row['room_nos'])) {
        $room_numbers .= "<option value='" . $roomno_row['room_nos'] . "'>" . $roomno_row['room_nos'] . "</option>";
    }
}


$room_type = "";

$room_data_price = $con->real_escape_string($room_data['price']); // Sanitize the input

$room = $con->query("SELECT * FROM `rooms` WHERE `removed` = 0 AND `status` = 1 AND `room_ntype` = 'Room' AND `price` >= $room_data_price");

$room_res = [];
foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
    $room_type .= "<option value='" . $row['room_id'] . "'>" . $row['type'] . "</option>";
}




// Assuming $booking_data['check_in'] is a date string in Y-m-d format
$checkin_date_str = $booking_data['check_in'];
$checkin_date = new DateTime($checkin_date_str);
$formatted_checkin_date = $checkin_date->format('M-d-Y');


// Assuming $booking_data['check_out'] is a date string in Y-m-d format
$checkout_date_str = $booking_data['check_out'];
$checkout_date = new DateTime($checkout_date_str);
$formatted_checkout_date = $checkout_date->format('M-d-Y');



?>


<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <div class="d-flex justify-content-between">

                    <h3 class="mb-3 text-success fw-bold">Extend Booking</h3>
                </div>

                <div class="row">
                    <!-- content -->

                    <div class="col-lg-7 col-md-12 px-4">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body">
                                <form action="booking_response.php" method="POST" id="booking_form">
                                    <h6 class="mb-3">BOOKING DETAILS</h6>
                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <b><label class="form-label">Name: </label></b> <?php echo $booking_data['user_name'] ?> <br>
                                            <b><label class="form-label">Phone Number: </label> </b><?php echo $booking_data['phonenum'] ?> <br>
                                            <b><label class="form-label">Email: </label> </b><?php echo $booking_data['email'] ?> <br>

                                            <input hidden name="booking_id" value="<?php echo $data['book_id'] ?>">

                                            <input hidden name="no_extension">
                                            <input hidden name="extended_total_amt">
                                            <input hidden name="checkin_final">
                                            <input hidden name="checkout_final">

                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">

                                <h6 class="mb-3">Extension</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Number of Extension Days: </label>
                                        <input name="extend_days" type="number" class="form-control shadow-none" id="extendDays" value="" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <button type="button" class="w-100 btn btn-success mb-3" onclick="extendBooking()" id="extendButton">Extend</button>
                                        <button type="button" class="w-100 btn btn-secondary mb-3" onclick="resetDates()">Reset Dates</button>
                                    </div>
                                    <div class="col-12 px-4">
                                        <p class="fw-bold alert alert-warning">
                                            <i class="bi bi-exclamation-traaingle-fill"></i>
                                                If the Room is not Available for Extension, please Re-book the Guest or Change room.
                                            <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-5 col-md-12 px-4">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Check-in</label>
                                        <!-- Set the min attribute to disable past dates -->
                                        <input type="date" onchange="chk_avail_filter()" value="<?php echo date('Y-m-d', strtotime($booking_data['check_in'])); ?>" class="form-control shadow-none" name="checkin" id="checkin" required min="<?php echo date('Y-m-d'); ?>" disabled>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Check-out</label>
                                        <!-- Set the min attribute to disable past dates -->
                                        <input type="date" onchange="chk_avail_filter()" value="<?php echo date('Y-m-d', strtotime($booking_data['check_out'])); ?>" class="form-control shadow-none" name="checkout" id="checkout" required min="<?php echo date('Y-m-d'); ?>" disabled>
                                    </div>
                                </div>
                                <h3>Billing Breakdown</h3>
                                <div class="spinner-border text-success mb-3 d-none" id="info_loader" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div style="padding: 10px; max-width: 300px; margin: 0 auto;">
                                    <h6 class="text-danger fw-bold" id="pay_info">
                                        Pick a Payment Method and Provide check-in & check-out date!<br><br>
                                        <span class="text-secondary">Room Type: <span style="float: right;"><?php echo $room_data['type'] ?></span><br>
                                            <span class="text-secondary">Room No: <span style="float: right;"><?php echo $room_numbers ?></span><br>
                                                <span class="text-secondary">Price: <span style="float: right;">₱<?php echo $room_data['price'] ?></span><br>

                                                    Discounts: <span style="float: right;"> 0% </span><br>
                                                    Booking Fees: <span class="text-secondary" style="float: right;">FREE</span> <br>
                                                    Total Amout to Pay: <span style="float: right;"> ₱<?php echo $room_data['price'] ?></span>
                                    </h6>
                                    </h6>
                                </div>
                                <button name="extendbtn" type="submit" id="pay_button" class="btn btn-success w-100 shadow-none mb-1" disabled>Extend</button>

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

            //for reset data
            function resetDates() {
                // Get the original check-in and check-out values
                let originalCheckin = '<?php echo date('Y-m-d', strtotime($booking_data['check_in'])); ?>';
                let originalCheckout = '<?php echo date('Y-m-d', strtotime($booking_data['check_out'])); ?>';

                // Set the original values to the input fields
                booking_form.elements['checkin'].value = originalCheckin;
                booking_form.elements['checkout'].value = originalCheckout;

                // Reset extended days to 0
                document.getElementById('extendDays').value = 0;

                // Trigger availability check
                chk_avail_filter();
            }


            $(document).ready(function() {
                // Add change event listener to the select element
                $('#roomTypeSelect').change(function() {
                    // Get the selected room_id from the selected option
                    var selectedRoomId = $(this).val();

                    // Update the room_id in the session using AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'change_room.php', // Replace with the actual PHP script to update the session
                        data: {
                            room_id: selectedRoomId
                        },
                        success: function(response) {
                            console.log('Session updated successfully');
                        },
                        error: function(error) {
                            console.error('Error updating session:', error);
                        }
                    });
                });
            });





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

            document.getElementById('extendButton').disabled = true;

            // Add an event listener to the input field
            document.getElementById('extendDays').addEventListener('input', function() {
                // Enable or disable the "Extend" button based on whether the input is empty
                document.getElementById('extendButton').disabled = this.value === '';
            });

            //extend booking
            function extendBooking() {
                let extendDays = document.getElementById('extendDays').value;
                let checkinDate = new Date(booking_form.elements['checkout'].value);

                if (!isNaN(extendDays) && extendDays > 0) {
                    // Calculate the new check-out date
                    let newCheckoutDate = new Date(checkinDate);
                    newCheckoutDate.setDate(checkinDate.getDate() + parseInt(extendDays));

                    // Update the check-out input field
                    booking_form.elements['checkout'].value = formatDate(newCheckoutDate);

                    // Trigger availability check
                    chk_avail_filter();
                } else {
                    alert('Please enter a valid number of days to extend.');
                }
            }


            function formatDate(date) {
                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear();

                return year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
            }

            //diable ung room no dropdown pag naka select si "booked" sa booking status

            //check kung available b aung room
            function check_availability(divideValue) {
                let checkin_val = booking_form.elements['checkin'].value;
                let checkout_val = booking_form.elements['checkout'].value;
                let extendDays = document.getElementById('extendDays').value;
                booking_form.elements['pay_button'].setAttribute('disabled', true);


                if (checkin_val != '' && checkout_val != '') {
                    pay_info.classList.add('d-none');
                    pay_info.classList.replace('text-dark', 'text-danger');
                    info_loader.classList.remove('d-none');

                    let data = new FormData();

                    data.append('check_availability', '');
                    data.append('check_in', checkin_val);
                    data.append('check_out', checkout_val);


                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/change_room.php", true);


                    //para maload ung laman nung sa database
                    xhr.onload = function() {
                        let data = JSON.parse(this.responseText);
                        var paymentAmount;
                        var original_price = <?php echo $room_data['price'] ?>;
                        var extended_price = original_price * extendDays;
                        paymentAmount = data.payment - <?php echo $booking_data['discounted_amt']; ?>


                        if (data.status == 'check_in_out_equal') {
                            pay_info.innerText = "You cannot Check-out on the same day!";

                        } else if (data.status == 'check_out_earlier') {
                            pay_info.innerText = "Check-out date is Earlier than Check-in Date!";

                        } else if (data.status == 'check_in_earlier') {
                            pay_info.innerText = "Check-in date is Earlier than today's Date!";

                        } else if (data.status == 'unavailable') {
                            pay_info.innerText = "This Room is already Booked on this Checkout!";
                        } else {
                            pay_info.innerHTML =
                                "Room Type: <span class='indented' style='float: right;'><?php echo $room_data['type'] ?></span><br>" +
                                "Price: <span style='float: right;'>₱<?php echo $room_data['price'] ?></span><br>" +
                                "Previous Check-In: <span class='indented' style='float: right;'><?php echo $formatted_checkin_date ?></span><br>" +
                                "Previous Check-Out: <span class='indented' style='float: right;'><?php echo $formatted_checkout_date ?></span><br><hr>" +
                                "Check-In: <span class='indented' style='float: right;'>" + data.checkin + "</span><br>" +
                                "Check-Out: <span class='indented' style='float: right;'>" + data.checkout + "</span><br>" +
                                "<br>No. of Extension Days: <span class='indented' style='float: right;'>" + extendDays + "</span>" +
                                "<br>Previously Price Paid:<span class='indented' style='float: right;'>₱<?php echo $booking_data['discounted_amt'] ?></span>" +
                                "<br>Price with Extension:<span class='indented' style='float: right;'>₱" + data.payment + "</span>" +
                                "<hr><br>Total Amount to be Paid:<span class='indented' style='float: right;'>₱" + paymentAmount + "</span>";

                            pay_info.classList.replace('text-danger', 'text-dark');
                            booking_form.elements['extendbtn'].removeAttribute('disabled');

                            booking_form.elements['no_extension'].value = extendDays;
                            booking_form.elements['checkin_final'].value = data.checkin;
                            booking_form.elements['checkout_final'].value = data.checkout;
                            booking_form.elements['extended_total_amt'].value = paymentAmount;

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