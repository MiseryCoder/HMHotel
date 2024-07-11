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
    <title>HM Hotel | Booking Status</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Ractive {
            font-weight: bold;
            color: #198754;
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php
    require('include/navigation.php');
    //eto ung pangkuha nung data sa database sa table na contact_details
    $contact_q = "SELECT * FROM `contact_details` WHERE `contact_ID`=?";
    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));

    // eto ung pangkuha nung data sa database sa table na about_details
    $title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
    $values = [1];
    $title_r = mysqli_fetch_assoc(select($title_q, $values, 'i')); //select function sa admin/include/conn.php


    ?>
    <!-- End of Navigation Bar -->

    <!------Content------>


    <!-- Room Start -->


    <div class="container py-5 mt-1">
        <div class="row">
            <div class="col-12 my-5 mb-3 px-4">
                <h2 class="mb-3">Booking Status</h2>

            </div>

            <?php
            $frm_data = filteration($_GET);

            if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
                redirect('index.php');
            }

            $booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo 
                INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
                WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status!=?";

            $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['uId'], 'pending'], 'sis');

            if (mysqli_num_rows($booking_res) == 0) {
                redirect('index.php');
            }

            $booking_fetch = mysqli_fetch_assoc($booking_res);

            $roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                        INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                        WHERE rnd.room_id = '$booking_fetch[room_id]'");

            $room_numbers = ""; // Initialize room numbers variable

            if ($roomno_q && mysqli_num_rows($roomno_q) > 0) {
                // Fetch the associative array for room numbers
                $roomno_row = mysqli_fetch_assoc($roomno_q);

                // Check if 'room_nos' exists in the fetched row
                if (isset($roomno_row['room_nos'])) {
                    $room_numbers = $roomno_row['room_nos'];
                }
            }



            //START OF UPDATE NOTES

            if ($booking_fetch['booking_status'] == "Booked" || $booking_fetch['booking_status'] == "Reserved") {
                echo <<<data
                        <div class="col-12 px-4">
                        <p class="fst-italic alert alert-warning">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            Note: The Management will reminds you to pay reservation fee <b>2 days before check-in</b> date to avoid <b>cancellation</b>. <br>
                            You can either <b>download the pdf</b> or <b>check your email</b> for your booking details.
                            
                        </p>
                        <p class="fw-bold alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        Booking Successful!
                                <br><br>
                                 <a href='generate_pdf.php?gen_pdf&id=$booking_fetch[booking_id]' class='btn btn-success shadow-none me-2' style='margin:4px;'>
                                    <i class='bi bi-filetype-pdf me-1'></i>Download PDF
                                </a>
                
                                <a href='bookings.php' class='btn btn-warning shadow-none' style='margin:2px;'>
                                    <i class="bi bi-box-arrow-right me-1"></i>Go To Bookings
                                </a>
                            </p>

                        </div>
                    data; //END OF UPDATE NOTES
            } else {
                echo <<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-traaingle-fill"></i>
                                Payment failed!
                                <br><br>
                                <a href='bookings.php' class='btn btn-warning shadow-none'>
                                    <i class="bi bi-box-arrow-right me-1"></i>Go To Bookings
                                </a>
                            </p>
                        </div>
                    data;
            }




            $query = "SELECT bo.*, bd.*, uc.* FROM `booking_order` bo
                INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                INNER JOIN `guests_users` uc ON bo.user_id = uc.id
                WHERE bo.order_id = '$frm_data[order]'";

            $res = mysqli_query($con, $query);

            $total_rows = mysqli_num_rows($res);

            $data = mysqli_fetch_assoc($res);

            $date = date("h:ia | d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));
            $checkin_d = new DateTime($data['check_in']);
            $checkout_d = new DateTime($data['check_out']);

            $interval = $checkin_d->diff($checkout_d);
            $count_days = $interval->days;
            ?>
        </div>

        <div class='container'>
            <div class='row'>
                <div class='col-lg-12'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='invoice-title'>
                                <h4 class='float-end font-size-15'><b>Order ID: </b><?php echo $data['order_id'] ?><span class='badge bg-success font-size-12 ms-2'><?php echo $data['booking_status'] ?></span></h4>
                                <div class='mb-4'>
                                    <h2 class='mb-1 text-muted'>
                                        <?php echo $title_r['site_title'] ?>
                                    </h2>
                                </div>
                                <div class='text-muted'>
                                    <p class='mb-1'><?php echo $contact_r['address'] ?></p>
                                    <p class='mb-1'><i class='uil uil-envelope-alt me-1'></i><?php echo $contact_r['email'] ?></p>
                                    <p><i class='uil uil-phone me-1'></i><?php echo $contact_r['pn1'] ?></p>
                                </div>
                            </div>

                            <hr class='my-4'>

                            <div class='row'>
                                <div class='col-sm-6'>
                                    <div class='text-muted'>
                                        <h5 class='font-size-16 mb-3'>Billed To:</h5>
                                        <h5 class='font-size-15 mb-2'><?php echo $data['user_name'] ?></h5>
                                        <p class='mb-1'><?php echo $data['address'] ?></p>
                                        <p class='mb-1'><?php echo $data['email'] ?></p>
                                        <p><?php echo $data['phonenum'] ?></p>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class='col-sm-6'>
                                    <div class='text-muted text-sm-end'>
                                        <div class='mt-4'>
                                            <h5 class='font-size-15 mb-1'>Invoice Date:</h5>
                                            <p><?php echo $date ?></p>
                                        </div>
                                        <div class='mt-4'>
                                            <h5 class='font-size-15 mb-1'>Order No:</h5>
                                            <p><?php echo $data['order_id'] ?></p>
                                        </div>
                                        <div class='mt-4'>
                                            <h5 class='font-size-15 mb-1'>Mode of Payment:</h5>
                                            <p><?php echo $data['payment_method'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->



                        <!-- START OF UPDATE  -->



                        <hr class='my-4'>

                        <div class='row'>
                            <div class='col-lg-12'><br>
                                <h3 class='mb-1 text-muted'>
                                    &nbsp;&nbsp;&nbsp;Booking Summary
                                </h3>

                            </div>
                        </div>
                        <br>

                        <div style="border: 1px solid #ccc; padding: 30px;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 class="text-start">Room/Facility</h6>
                                       
                                            <h6 class="text-start">Price</h6>
                                            
                                            <h6 class="text-start">Check-in</h6>
                                            
                                            <h6 class="text-start">Check-out</h6>
                                            
                                            <h6 class="text-start">No. of days</h6>
                                          
                                        </div>

                                        <div class="col-6">
                                            <h6 class="text-end"><?php echo $data['room_name'] ?></h6>
                                            
                                            <h6 class="fw-normal text-end">₱ <?php echo $data['price'] ?></h6>
                                           
                                            <h6 class="fw-normal text-end"><?php echo $checkin ?></h6>
                                           
                                            <h6 class="fw-normal text-end"><?php echo $checkout ?></h6>
                                         
                                            <h6 class="fw-normal text-end"><?php echo $count_days ?></h6>
                                         
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 class="text-start"><b>Details</b></h6>
                                         
                                            <!-- <h6 class="fw-normal">Tax</h6><br> -->
                                            <h6 class="text-start">Booking Fee</h6>
                                        
                                            <h6 class="text-start">Sub Total</h6>
                                            <br>
                                            <h6 class="text-start">Total Amount</h6>
                                        </div>

                                        <div class="col-6 text-end">
                                            <h6 class="text-end font"><b>Total</b></h6>
                                            <h6 class="hidden-text"> </h6>
                                         
                                            <!-- <h6 class="fw-normal">₱00.00</h6><br> -->
                                            <h6><span class="text-success">FREE</span></h6>
                                         
                                            <h6 class="fw-normal">₱00.00</h6>
                                            <hr>
                                            <h4>₱<?php echo $data['trans_amt'] ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->


        <!-- END  OF UPDATE  -->


    </div>
    </div>

    <div class="container">
        <img src="img/roadmap.png" alt="roadmap picture" class="img-fluid">
    </div>
    </div>


    <!-- Room End -->



    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>


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