<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image" href="img/logo.png">
    <link rel="stylesheet" href="css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    <title>HM Hotel | Confirm Booking</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Ractive {
            font-weight: bold;
            color: #198754;
        }

        .form_radio {
            display: inline-block;
            margin-right: 20px;
            /* Adjust the margin as needed */
        }

        .rounded-fill {
            background-color: #198754;
            /* Green color */
            color: white;
            /* Text color */
            padding: 10px;
            /* Adjust padding as needed */
            border-radius: 10px;
            /* Rounded corners */
            display: inline-block;
            /* Make it an inline block to contain the padding */

        }

        .nav-tabs .nav-link {
            color: #495057;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #198754;
            border: 1px solid #28a745;
        }

        .text-color {
            color: #198754;
            /* Text color */
        }
    </style>

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

</head>

<body>
    <!------Navigation Bar------>
    <?php require('include/navigation.php') ?>
    <!-- End of Navigation Bar -->

    <!------Content------>

    <?php

    /*
        Check room id from url if present or not
        Shutdown mode is active or not
        user is login or not
    */

    $checkin_default = " ";
    $checkout_default = " ";

    if (!isset($_GET['room_id']) || $title_r['shutdown'] == true) {
        redirect('rooms.php');
    } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('rooms.php');
    }

    $data = filteration($_GET);

    // Check if 'checkin' and 'checkout' keys exist in the $data array
    if (isset($data['checkin']) && isset($data['checkout'])) {
        // Both 'checkin' and 'checkout' keys are present
        $checkin_default = $data['checkin'];
        $checkout_default = $data['checkout'];
    } else {
        // Handle the case where one or both keys are missing
        // You can set default values or show an error message, depending on your requirements
        $checkin_default = 'default_checkin_value';
        $checkout_default = 'default_checkout_value';
    }

    $room_res = select("SELECT * FROM `rooms` WHERE `room_id`=? AND `status`=? AND `removed`=?", [$data['room_id'], 1, 0], 'iii');



    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                        INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                        WHERE rnd.room_id = '$room_data[room_id]'");

    $room_numbers = ""; // Initialize room numbers variable

    if ($roomno_q && mysqli_num_rows($roomno_q) > 0) {
        // Fetch the associative array for room numbers
        $roomno_row = mysqli_fetch_assoc($roomno_q);

        // Check if 'room_nos' exists in the fetched row
        if (isset($roomno_row['room_nos'])) {
            $room_numbers = $roomno_row['room_nos'];
        }
    }

    $_SESSION['room'] = [
        "room_id" => $room_data['room_id'],
        "name" => $room_data['type'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => null,
    ];

    $user_res = select("SELECT * FROM `guests_users` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
    $user_data = mysqli_fetch_assoc($user_res);


    //pagnaka on ang online payment
    $is_payment = mysqli_fetch_assoc(mysqli_query($con, "SELECT `Online_payment` FROM `about_details`"));

    ?>


    <!-- Room Start -->


    <div class="container py-3 mt-1">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="mb-3">CONFIRM BOOKING</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-success text-decoration-none">Home</a>
                    <span class="text-success"> > </span>
                    <a href="rooms.php" class="text-success text-decoration-none">Rooms</a>
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none"><?php echo $room_data['type'] ?></a> <!-- Dagdag lang update sa Breadcrumbs -->
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none">Confirm Booking</a>
                </div>
            </div>


            <!-- left card -->
            <div class="col-lg-7 col-md-12 px-4 mb-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="paypalCharge.php" method="POST" id="booking_form" enctype="multipart/form-data">
                            <h6 class="mb-3">BOOKING DETAILS</h6>
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="phonenum" type="text" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" id="email" type="email" value="<?php echo $user_data['email'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Re-type Email</label>
                                    <input name="email2" id="email2" type="email" value="<?php echo $user_data['email'] ?>" class="form-control shadow-none" required>
                                    <div id="emailMismatchError" class="text-danger d-none">Emails do not match.</div>
                                </div>
                                <!-- id upload -->

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Upload Valid ID</label>
                                    <input name="idpic" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                                    <p class="text-secondary fs-7 fst-italic">
                                        Make sure your Valid ID have photo, Name, and Address. List of Preffered Valid IDs
                                    </p>
                                    <ul class="text-secondary fst-italic">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <li>SSS</li>
                                                <li>Philsys ID</li>
                                                <li>UMID</li>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <li>Driver's license</li>
                                                <li>Voters ID</li>
                                                <li>Student ID</li>
                                            </div>
                                        </div>
                                    </ul>
                                </div>



                                <div class="col-md-12 mb-3">
                                    <p class="fw-bold">Payment Method</p>


                                    <?php
                                    if (!$is_payment['Online_payment']) {

                                        echo <<<data
                                                <div class="col-12 px-4">
                                                    <p class="fw-bold alert alert-warning">
                                                        <i class="bi bi-exclamation-traaingle-fill"></i>
                                                        Gcash and Paypal is Turned Off.
                                                        <br>
                                                    </p>
                                                </div>
                                            data;

                                        echo <<<data
                
                                                <div class="container" hidden>
                                                    <div class="form-check rounded shadow-sm p-1 px-4 mb-2">
                                                        <div class="form-check"> 
                                                            <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="OnlineGcash" value="online_gcash" required>
                                                            <label class="form-check-label" for="OnlineGcash">
                                                            <img src="img/payment_logo/gcash_logo.png" alt="" height='30' width='35'>
                                                                    GCash
                                                            </label>      
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                
                                                <div class="container" hidden>
                                                    <div class="form-check rounded shadow-sm p-1 px-4 mb-2">
                                                        <div class="form-check"> 
                                                            <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="OnlinePayment" value="online" required>
                                                            <label class="form-check-label" for=" OnlinePayment">
                                                            <img src="img/payment_logo/paypal_logo.png" alt="" height='30' width='35'>
                                                                    Paypal
                                                            </label> 
                                                        </div>
                                                    </div>
                                                </div>
                               
                                            data;
                                    } else {
                                        echo <<<data
                
                                            <div class="container">
                                                <div class="form-check rounded shadow-sm p-1 px-4 mb-2">
                                                    <div class="form-check"> 
                                                        <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="OnlineGcash" value="online_gcash" required>
                                                        <label class="form-check-label" for="OnlineGcash">
                                                        <img src="img/payment_logo/gcash_logo.png" alt="" height='30' width='35'>
                                                                GCash
                                                        </label>      
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            
                                            <div class="container">
                                                <div class="form-check rounded shadow-sm p-1 px-4 mb-2">
                                                    <div class="form-check"> 
                                                        <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="OnlinePayment" value="online" required>
                                                        <label class="form-check-label" for=" OnlinePayment">
                                                        <img src="img/payment_logo/paypal_logo.png" alt="" height='30' width='35'>
                                                                Paypal
                                                        </label> 
                                                    </div>
                                                </div>
                                            </div>
                               
                                         data;
                                    }
                                    ?>

                                    <div class="container">
                                        <div class="form-check rounded shadow-sm p-1 px-4">
                                            <div class="form-check">
                                                <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="Cash" value="cash" required>
                                                <label class="form-check-label" for="Cash">
                                                    <img src="img/payment_logo/cash_logo.png" alt="" height='28' width='35'>
                                                    Cash
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

            </div>





            <div class="col-lg-5 col-md-12 px-4 mb-3">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body">

                        <div class="row">
                            <h6 class="text-center">Check Availability</h6>
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


                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">

                        <h2>Billing Statement</h2>

                        <div class="col-md-12 ps-0" id="notetxt"></div>

                        <div class="spinner-border text-success mb-3 d-none" id="info_loader" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <div style="padding: 10px; max-width: 300px; margin: 0 auto;">
                            <h6 class="text-danger fw-bold" id="pay_info">
                                Pick a Payment Method and Provide check-in & check-out date!<br><br>

                                <span class="text-secondary">Room Type: <span style="float: right;"><?php echo $room_data['type'] ?></span><br>
                                    <span class="text-secondary">No. of Days: <span style="float: right;">0</span> <br>

                                        <!-- start update change position of price -->

                                        <span class="text-secondary">Price: <span style="float: right;">₱<?php echo $room_data['price'] ?></span><br>

                                            <!-- end of update to change position of price -->

                                            <span class="text-secondary">Discounts: <span style="float: right;"> 0% </span><br>
                                                <span class="text-secondary">Booking Fees: <span class="text-secondary" style="float: right;">FREE</span>

                                                    <!-- update pangboarder  -->

                                                    <hr class='my-4'>

                                                    <!-- end of update pangboarder  -->

                                                    <span class="text-secondary">Total Amout to Pay: <span style="font: size 20px; float: right;"> ₱00.00</span>


                        </div>
                        <button type="button" id="pay_button" class="btn btn-success w-100 shadow-none mb-1" data-bs-dismiss="modal" aria-label="static" data-bs-toggle="modal" data-bs-target="#payModal" disabled>Pay Now</button>
                        <center>
                            <p><i>Before proceeding you acknowledge that you have read and agree to our <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>.</i></p>
                        </center>
                    </div>


                    <!-- Logout Confirmation Modal -->
                    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="payModalLabel">Booking Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to Book this Room?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <button type="submit" name="pay_now" class="btn btn-success">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>


            <!-- modal for T&C -->
            <div class="modal fade" id="termsModal" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Your content goes here -->
                            <div class="container">
                                <div class="row">
                                    <!--Tabs-->
                                    <div>
                                        <nav>
                                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                <button class="nav-link active fw-bold" id="foods-tab" data-bs-toggle="tab" data-bs-target="#foods" type="button" role="tab" aria-controls="foods" aria-selected="true">Guests Rooms</button>
                                                <!-- <button class="nav-link fw-bold" id="drinks-tab" data-bs-toggle="tab" data-bs-target="#drinks" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Facilities</button> -->
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">

                                            <!-- Foods -->
                                            <div class="tab-pane fade show active mb-5" id="foods" role="tabpanel" aria-labelledby="foods-tab">
                                                <div class="p-5 border">
                                                    <div class="row gap100">
                                                        <div class="col-md-12">
                                                            <h6><b>GUEST HOUSE RULES:</b></h6>
                                                            <p>
                                                                1. Guest check in time is <b>2:00 in the afternoon</b> while check out time is <b>12:00 noon</b> the following day.<br>
                                                                2. No pets allowed.<br>
                                                                3. All guest is required to register prior checking in and must have valid id to be photocopied.<br>
                                                                4. Room designation will be conformed upon arrival.<br>
                                                                5. Each room capacity will be based on the room layout.<br>
                                                                6. Additional guest per room will incur charges.<br>
                                                                7. Visitor is allowed till <b>8pm only</b>. Beyond the time approve will incur charges. <b>(P1,000/Pax)</b><br>
                                                                8. Late check out and early check in is subject to additional charges. <b>(P500/Hour)</b><br>
                                                                9. Any damages and or loss during the stay will be charge to the registered guest.<br>
                                                                10. Guest must keep their valuable secured at all times.<br>
                                                                11. A deposit per night will be required.<br><br>


                                                                <!-- START OF UPDATE -->

                                                            <h6><b>PARKING:</b></h6>
                                                            <p>
                                                                Every room reserved by a hotel guest is entitled to <b>one (1)
                                                                    complimentary parking space.</b>
                                                                We can refer you to <b>Bonifacio Park,</b> while you choose
                                                                to stay with us.
                                                            </p><br>

                                                            <!-- END OF UPDATE -->


                                                            <h6><b>FOR CANCELLATION:</b></h6>
                                                            <p>
                                                                <b>Reserved already</b> - You should call the hotel management at least two (2) days before the check-in date, as it has already been paid.<br><br>

                                                                <b>Booked</b> - You can cancel your booking two (2) days prior to the check-in date. But if you plan to cancel it
                                                                on the same day or a day before the check-in date, you should call the hotel management. <br></br>

                                                            </p>
                                                            <i>
                                                                <center>
                                                                    <h6 class="text-color"><b>THE PAMANTASAN NG LUNGSOD NG PASIG IS NOT LIABLE TO ANY LOST OR DAMAGES ON THE PERSONAL BELONGINGS OF THE CLIENT AND THEIR GUEST.</b></h6>
                                                                </center><br>
                                                            </i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Drinks -->
                                            <div class="tab-pane fade mb-5" id="drinks" role="tabpanel" aria-labelledby="drinks-tab">
                                                <div class="p-5 border">
                                                    <div class="row gap100">
                                                        <div class="col-md-12">
                                                            <p>
                                                                1. Request is subject to availability, prioritizing Academic Activity.
                                                                <br>2. Letter of request for venue availability must be processed and approved prior to consumption of the facility.
                                                                <br>3. Venue Set up – Aesthetic is not included. Any improvement and/or designing needed is not covered in the request. Installation of décor in the ceiling, walls and windows are strictly prohibited – violation can forfeit deposit.
                                                                <br>4. Venue maximum capacity is as follow;
                                                                <br>&emsp;&emsp;<b>a. HM Banquet Hall – 150 Pax only</b>
                                                                <br>&emsp;&emsp;<b>b. HM Function Room – 100 Pax only</b>
                                                                <br>5. There must be a designated approved utility assign at all event.
                                                                <br>6. Renter will be required to surrender a security deposit of <b>five thousand pesos (P5,000)</b>, which will be used for any damages, loss or for exceeding hour/s. This will be return after two working days after the clearance is processed.

                                                                <br>7. Renter will be allowed two hours’ time for Ingress (set up) and another two hours Egress (pull out). However, any exceeding fraction of time will be charge to the client.
                                                                <br>8. <b>Minimum of three (3) hours</b> rent is equivalent to <b>P10,000</b> and additional <b>P1,000</b> per exceeding hour.
                                                                <br>9. The University will not be liable to any loss or damage of personal property of the client and their guest.
                                                                <br>10. Utility personnel that will be assign to the event will be personally compensated by the client.
                                                                <br>11. For outside catering service, sound system and other outsource suppliers– a deposit of <b>P5, 000</b> is required for any damages and or loss in facilities related to catering company. This will be return after two working days after the clearance is processed.
                                                                <br>12. Any damages or loss in the facility and adjoining areas resulted from the negligence of the renter is subject to monetary payment.
                                                                <br>13. All activities and preparation must be within the time period of <b>8:00am to 9:00pm only</b>.
                                                                <br>14. A maximum of <b>5 Parking slot</b> is allotted in the HRM Building for the paying client event. Plate Number will be requested from the client for building access
                                                                <br>15. Strictly <b>NO Smoking</b> in the entire premises and a fine of <b>P3,000</b> on each violator and incident.
                                                                <br>16. There is NO Designated Smoking Area.
                                                                <br>17. Loitering is not Allowed.
                                                                <br>18. Guests and participants are not allowed to stay in ANY other Areas but the approved venue only.
                                                                <br>19. No pets allowed.
                                                                <br>
                                                                <br>



                                                                <i>
                                                                    <center>
                                                                        <h6 class="text-color"><b>THE PAMANTASAN NG LUNGSOD NG PASIG IS NOT LIABLE TO ANY LOST OR DAMAGES ON THE PERSONAL BELONGINGS OF THE CLIENT AND THEIR GUEST.</b></h6>
                                                                    </center><br>
                                                                </i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of your content -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room End -->
        </div>
    </div>
    </div>
    </div>
    </div>



    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->

    </script>

    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');


        var radiobtnOnline = document.getElementById("OnlinePayment");
        var radiobtngcash = document.getElementById("OnlineGcash");
        var radiobtnCash = document.getElementById("Cash");
        var radiobtn5050 = document.getElementById("fiftyFifty");
        var selectedRadiobtn = document.querySelector('input[name="flexRadioDefault"]:checked');
        var pay_button = document.getElementById("pay_button");
        var passnmatch = document.getElementById('passnmatch');
        var passmatch = document.getElementById('passmatch');
        var note = document.getElementById('notetxt');


        const emailField = document.getElementById('email');
        const email2Field = document.getElementById('email2');
        const emailMismatchError = document.getElementById('emailMismatchError');

        // Function to check if the emails match
        function checkEmailMatch() {
            if (emailField.value !== email2Field.value) {
                emailMismatchError.classList.remove('d-none');
                return false;
            } else {
                emailMismatchError.classList.add('d-none');
                return true;
            }
        }

        function chk_avail_filter() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;

            // Check if either check-in or check-out values are not empty
            if (checkin_val !== '' && checkout_val !== '') {
                check_availability(1);
            }
        }

        // Add event listeners to the email input fields
        emailField.addEventListener('input', checkEmailMatch);
        email2Field.addEventListener('input', checkEmailMatch);

        // Form submission validation
        function validateForm() {
            if (!checkEmailMatch()) {
                // Emails do not match, prevent form submission
                return false;
            }
            // Form is valid, allow submission
            return true;
        }

        //radio button ng payment
        function PaymentMethod() {
            var form = document.getElementById("booking_form");
            var selectedRadio = document.querySelector('input[name="flexRadioDefault"]:checked');

            if (selectedRadio && selectedRadio.id === "fiftyFifty") {
                check_availability(2); // Pass the divide value as 2
            } else {
                check_availability(1); // Pass the divide value as 1
            }
        }

        document.getElementById('checkin').value = "<?php echo $checkin_default ?>";
        document.getElementById('checkout').value = "<?php echo $checkout_default ?>";

        // Call check_availability on page load
        window.onload = function() {
            check_availability(1);
        };

        function check_availability(divideValue) {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            document.getElementById('pay_button').setAttribute('disabled', true);



            var selectedRadio;
            if (radiobtnOnline.checked) {
                selectedRadio = 'online';
                pay_button.innerText = 'Pay Now';
                passnmatch.hidden = false;
                note.innerHTML = `<p class="fst-italic alert alert-info">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            Note: You have to make a full payment if you're <b><i>Paying Online.</i></b>
                            The Management will remind you about the reservation fee <b>2 days before check-in</b> date to avoid <b>cancellation</b>.
                          </p>`;

                // document.getElementById('pay_button').removeAttribute('disabled');

            } else if (radiobtngcash.checked) {
                selectedRadio = 'online';
                pay_button.innerText = 'Pay Now';
                passnmatch.hidden = false;
                note.innerHTML = `<p class="fst-italic alert alert-info">
                    <i class="bi bi-exclamation-circle-fill"></i>
                            Note: You have to make a full payment if you're <b><i>Paying Online.</i></b>
                            The Management will remind you about the reservation fee <b>2 days before check-in</b> date to avoid <b>cancellation</b>.
                        </p>`;
                // document.getElementById('pay_button').removeAttribute('disabled');

            } else if (radiobtnCash.checked) {
                selectedRadio = 'cash';
                pay_button.innerText = 'Book Now';
                passnmatch.hidden = true;
                note.innerHTML = `<p class="fst-italic alert alert-info">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            Note: If you do not settle the payment,
                            it will be <b>cancelled</b>.&nbsp;You can either <b>download the pdf</b> or <b>check your email</b> for your booking details.
                            &nbsp;If your <b>check-in date is within 24 hours,</b>&nbsp;make your payment at the
                            <b>Hotel's Finance Office within the day</b> to guarantee the reservation.
                          </p>`;
                // document.getElementById('pay_button').removeAttribute('disabled');
            }

            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                //oopen muna si confirm_booking.php para maretrieve data sa database (booking_order)
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);



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
                        pay_info.innerText = "Room is not available for this check-in Date!";
                    } else {
                        pay_info.innerHTML = // update start sa billing statement

                            "Room Type: <span class='indented' style='float: right;'><?php echo $room_data['type'] ?></span><br>" +
                            "Check-In: <span class='indented' style='float: right;'>" + data.checkin + "</span><br>" +
                            "Check-Out: <span class='indented' style='float: right;'>" + data.checkout + "</span><br>" +
                            "No. of Days: <span class='indented' style='float: right;'>" + data.days + "</span><br>" +
                            "Price: <span style='float: right;'>₱<?php echo $room_data['price'] ?></span><br>" +
                            "Booking Fees: <span class='text-success' style='float: right;'> FREE </span>" +



                            "<hr class='my-2'>" + // update na dinagdag para magkaroon ng boarder 
                            "Total Amount to Pay:<span class='indented' style='font-size: 20px; float: right;'>₱" + paymentAmount + "</span>";
                        //update para lumaki font-size ng total amount to pay

                        // end of update sa billing statement

                        pay_info.classList.replace('text-danger', 'text-dark');
                        document.getElementById('pay_button').removeAttribute('disabled');

                    }

                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }

                xhr.send(data);
            }
        }
    </script>



    <!---- carousel javascript ----->
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