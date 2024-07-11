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
        .collapse .navbar-nav .nav-item .nav-link.Factive {
            font-weight: bold;
            color: #198754;
        }

    </style>

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var facilityLink = document.getElementById('facilityLink');

        if (facilityLink) {
            facilityLink.addEventListener('mouseenter', function () {
                facilityLink.classList.add('Ractive');
            });

            facilityLink.addEventListener('mouseleave', function () {
                facilityLink.classList.remove('Ractive');
            });
        }
    });
</script>

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

    //filter and get room and user data

    $data = filteration($_GET);
    //fetching checkin and checkout dates
    $checkin_default = $data['checkin'];
    $checkout_default = $data['checkout'];

    $room_res = select("SELECT * FROM `rooms` WHERE `room_id`=? AND `status`=? AND `removed`=?", [$data['room_id'], 1, 0], 'iii');



    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

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


    <div class="container py-5 mt-1">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="mb-3">CONFIRM BOOKING</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-success text-decoration-none">HOME</a>
                    <span class="text-success"> > </span>
                    <a href="rooms.php" class="text-success text-decoration-none">FACILITIES</a>
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none">CONFIRM</a>
                </div>
            </div>

            <!-- <div class="col-lg-7 col-md-12 px-4">
                <?php
                // $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                // $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                //             WHERE `room_id`='$room_data[room_id]' 
                //             AND `thumb`='1'");

                // if (mysqli_num_rows($thumb_q) > 0) {
                //     $thumb_res = mysqli_fetch_assoc($thumb_q);
                //     $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                // }

                // echo <<<data
                //         <div class="card p-2 shadow-sm rounded mb-3">
                //             <img src="$room_thumb" class="img-fluid rounded mb-3">
                //             <h5>$room_data[type]</h5>
                //             <h5>₱$room_data[price] per night</h5>
                //         </div>

                //     data;
                ?>
            </div> -->

            <!-- left card -->
            <div class="col-lg-7 col-md-12 px-4 mb-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="paypalCharge.php" method="POST" id="booking_form">
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




                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <!-- Set the min attribute to disable past dates -->
                                    <input type="date" onchange="check_availability()" value="<?php echo $checkin_default ?>" class="form-control shadow-none" name="checkin" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-out</label>
                                    <!-- Set the min attribute to disable past dates -->
                                    <input type="date" onchange="check_availability()" value="<?php echo $checkout_default ?>" class="form-control shadow-none" name="checkout" required min="<?php echo date('Y-m-d'); ?>">
                                </div>


                                <div class="col-md-12 mb-3">
                                    <p class="fw-bold">Payment Method</p>

                                    <?php
                                    if (!$is_payment['Online_payment']) {

                                        echo <<<data
                                                <div class="form-check" hidden>
                                                    
                                                    <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="OnlinePayment" value="online" required>
                                                    <label class="form-check-label" for="OnlinePayment">
                                                        Online Payment
                                                    </label>
                                                </div>
                                            data;
                                    } else {
                                        echo <<<data
                                                <div class="form-check">
                                                    
                                                    <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="OnlinePayment" value="online" required>
                                                    <label class="form-check-label" for="OnlinePayment">
                                                        Online Payment
                                                    </label>
                                                </div>
                                            data;
                                    }
                                    ?>

                                    <div class="form-check">
                                        <input class="form-check-input" onchange="PaymentMethod()" type="radio" name="flexRadioDefault" id="Cash" value="cash" required>
                                        <label class="form-check-label" for="Cash">
                                            Cash
                                        </label>
                                    </div>
                                </div>



                            </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-5 col-md-12 px-4 mb-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h2>Billing Statement</h2>

                        <div class="col-md-12 ps-0" id="notetxt">

                        </div>

                        <h5 class="fw-bold"><?php echo $room_data['type'] ?></h5>
                        <h5>₱<?php echo $room_data['price'] ?> per night</h5>
                        <div class="spinner-border text-success mb-3 d-none" id="info_loader" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <h6 class="text-danger fw-bold" id="pay_info">Pick a Payment Method or Provide check-in & check-out date!</h6>
                        </h6>

                        <button onclick="modalalert()" name="pay_now" id="pay_button" class="btn btn-success w-100 shadow-none mb-1" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#payModal" disabled>Pay Now</button>
                        <p><i>Before proceeding you acknowledge that you have read and agree to our <a href="T&C.php" target="_blank">Terms and Conditions</a>.</i></p>
                    </div>
                </div>
            </div>
            </form>




        </div>
    </div>


    <!-- Room End -->



    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->

    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        var radiobtnOnline = document.getElementById("OnlinePayment");
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

        function check_availability(divideValue) {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            booking_form.elements['pay_now'].setAttribute('disabled', true);


            var selectedRadio;
            if (radiobtnOnline.checked) {
                selectedRadio = 'online';
                pay_button.innerText = 'Pay Now';
                passnmatch.hidden = false;
                note.innerHTML = `<p class="fst-italic alert alert-info">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            Note: You Have to Pay at least 50% if you're <b><i>Paying Online</i></b>
                          </p>`;
            } else if (radiobtnCash.checked) {
                selectedRadio = 'cash';
                pay_button.innerText = 'Book Now';
                passnmatch.hidden = true;
                note.innerHTML = `<p class="fst-italic alert alert-info">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            Note: The Management will reminds you to pay reservation fee <b>2 days before check-in</b> date to avoid <b>cancellation</b>.
                          </p>`;
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
                        pay_info.innerHTML = "No. of Days: " + data.days + "<br>Total Amout to Pay: ₱" + paymentAmount;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        booking_form.elements['pay_now'].removeAttribute('disabled');
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