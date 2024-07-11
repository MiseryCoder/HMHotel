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
    <title>HM Hotel | Room Details</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Ractive {
            font-weight: bold;
            color: #198754;
        }

        .progress-label-left {
            float: left;
            margin-right: 0.5em;
            line-height: 1em;
        }

        .progress-label-right {
            float: right;
            margin-left: 0.3em;
            line-height: 1em;
        }

        .star-light {
            color: #e9ecef;
        }


        .dropdown-accordion {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .dropdown .btn {
            width: 100%;
            text-align: left;
            border-radius: 0.25rem;
        }

        .dropdown .collapse {
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php require('include/navigation.php') ?>
    <!-- End of Navigation Bar -->

    <!------Content------>

    <?php
    if (!isset($_GET['room_id'])) {
        redirect('rooms.php');
    }

    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `room_id`=? AND `status`=? AND `removed`=?", [$data['room_id'], 1, 0], 'iii');

    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);



    //fetching checkin and checkout dates
    $frm_data = filteration($_GET);
    $checkin_default = isset($frm_data['checkin']) ? $frm_data['checkin'] : '';
    $checkout_default = isset($frm_data['checkout']) ? $frm_data['checkout'] : '';

    ?>


    <!-- Room Start -->


    <div class="container py-1 mt-1">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="mb-3"><?php echo $room_data['type'] ?></h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-success text-decoration-none">Home</a>
                    <span class="text-success"> > </span>
                    <a href="rooms.php" class="text-success text-decoration-none">Rooms</a>
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none"><?php echo $room_data['type'] ?></a>
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none">More Details</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        //get thumbnail photo

                        $room_img = ROOMS_IMG_PATH . "thumbnail.jpg";
                        $img_q = mysqli_query($con, "SELECT * FROM `room_images` 
                            WHERE `room_id`='$room_data[room_id]'");

                        if (mysqli_num_rows($img_q) > 0) {
                            $active_class = 'active';
                            while ($img_res = mysqli_fetch_assoc($img_q)) {
                                echo "
                                    <div class='carousel-item $active_class'>
                                        <img src='" . ROOMS_IMG_PATH . $img_res['image'] . "' class='d-block w-100 rounded'>
                                    </div>
                                ";
                                $active_class = '';
                            }
                        } else {
                            echo "
                                <div class='carousel-item active'>
                                    <img src='$room_img' class='d-block w-100'>
                                </div>                           
                            ";
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo <<<price
                                <h4>₱$room_data[price] per night</h4>
                            price;

                        //fetching the ratings and reviews
                        $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
								WHERE `room_id`='$room_data[room_id]' ORDER BY `rating_id` DESC LIMIT 20";

                        $rating_res = mysqli_query($con, $rating_q);
                        $rating_fetch = mysqli_fetch_assoc($rating_res);

                        $rating_data = "";

                        if ($rating_fetch['avg_rating'] != Null) {

                            for ($i = 1; $i <= $rating_fetch['avg_rating']; $i++) {
                                $rating_data .= "<small class='fa fa-star text-success'></small>";
                            }
                        }

                        echo <<<rating
                                <div class="mb-3">
                                    $rating_data
                                </div>
                            rating;

                        //getting features

                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                        INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
                        WHERE rfea.room_id = '$room_data[room_id]'");

                        $features_data = "<ul style='list-style: none; padding: 0; margin: 0;'>";
                        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                            $features_data .= "<li style='display: inline;'>• <span class='text-secondary'>$fea_row[name]</span> </li>";
                        }
                        $features_data .= "</ul>";

                        //displaying features
                        echo <<<features
                            <h6 class="mb-1">Features</h6>
                            <div class="mb-3">
                                $features_data
                            </div>
                        features;

                        //getting facilities
                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                         INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                         WHERE rfac.room_id = '$room_data[room_id]'");

                        $facilities_data = "<ul style='list-style: none; padding: 0; margin: 0;'>";

                        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                            $facilities_data .= "<li style='display: inline;'>• <span class='text-secondary'>$fac_row[name]</span> </li>";
                        }

                        //displaying facilities
                        echo <<<facilities
                            <h6 class="mb-1">Amenities</h6>
                            <div class="mb-3">
                                $facilities_data
                            </div>
                        facilities;

                        //displaying guests
                        echo <<<guests
                                <h6 class="mb-1">Guests</h6>
                                <div class="mb-3">
                                <li style='display: inline;'>• <span class='text-secondary'> $room_data[adult] Adult</span> </li>
                                <li style='display: inline;'>• <span class='text-secondary'>  $room_data[children] Children</span> </li>
                                </div>
                        guests;


                        //Displaying size
                        echo <<<area
                            <h6 class="mb-1">Size</h6>
                            <div class="mb-5">
                            <li style='display: inline;'>• <span class='text-secondary'>$room_data[area] sq. ft.</span> </li>
                            </div>
                        area;

                        $book_btn = "";
                        if (!$title_r['shutdown']) {
                            $login = 0;
                            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                                $login = 1;
                            }
                            $checkin = $checkin_default;
                            $checkout = $checkout_default;

                            // Format dates as 'Y-m-d' strings
                            $checkinFormatted = date('Y-m-d', strtotime($checkin));
                            $checkoutFormatted = date('Y-m-d', strtotime($checkout));

                            $login_js = json_encode($login);
                            $room_id_js = json_encode($room_data['room_id']);

                            echo <<<book
                                        <button onclick='checkLoginToBook1($login_js, $room_id_js, "$checkin", "$checkout")' class='btn btn-sm w-100 btn-success rounded shadow-none py-2 px-4 mb-1' data-bs-toggle='modal'>Book Now </button>
                                    book;
                        }



                        ?>





                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 px-4">
                <div class="mb-5">
                    <h5 class="text-success">&nbsp;&nbsp;Description</h5>
                    <p>
                        &nbsp;&nbsp;<?php echo $room_data['description'] ?>
                    </p>
                </div>


                <div class="col-lg-12 col-md-12 px-3" id="rooms-data">
                    <!-- card -->
                </div>



                <div class="row">
                    <!-- House rules details -->
                    <div class="col-12 col-md-8 mt-4 px-4"> <!-- Adjust the column width for medium-sized screens -->
                        <div class="mb-3">
                            <h5 class="mb-3 text-success">House Rules</h5>

                            <div class="card mb-4 border-0 shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="table-responsive"> <!-- Make the table responsive -->
                                        <table class="table">

                                            <tbody>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-calendar-check-fill"></i></th>
                                                    <td>Check-In:</td>
                                                    <td>2:00 PM Afternoon</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-calendar2-x-fill"></i></th>
                                                    <td>Check-Out:</td>
                                                    <td>12:00 PM Noon</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-x-circle-fill"></i></th>
                                                    <td>Cancellation:</td>
                                                    <td>Cancellation policies vary according to accomodation type.<br>
                                                        Please click the Terms and Condition when you confirm booking</td>

                                                </tr>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-person-lines-fill"></i></th>
                                                    <td>Child Policies:</td>
                                                    <td>Children of any age are welcome</td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-exclamation-square-fill"></i></th>
                                                    <td>Pet Policies:</td>
                                                    <td>Even though we adore pets, we cannot accommodate them <br>in our rooms or public spaces.</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-person-fill-exclamation"></i></th>
                                                    <td>Age Restriction:</td>
                                                    <td>There is no age requirements for check-in</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-person-fill-exclamation"></i></th>
                                                    <td>Parking Slot:</td>
                                                    <td>Every room reserved by a hotel guest is entitled to one (1) <br> complimentary parking space.<br>
                                                        We can refer you to Bonifacio Park, while you choose <br>to stay with us.



                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><i class="bi bi-wallet-fill"></i></th>
                                                    <td>Accepted Payments:</td>
                                                    <td><img src="img/payment_logo/gcash_logo.png" alt="" height='25' width='30'>
                                                        <img src="img/payment_logo/paypal_logo.png" alt="" height='25' width='30'>
                                                        <img src="img/payment_logo/cash_logo.png" alt="" height='25' width='30'><br>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of House Rules Details-->


                    <!-- ADDITIONAL LALAGYAN NA LANG BOARDER -->

                    <!-- Frequently Asked Question -->
                    <div class="col-12 col-md-4 mt-4 px-4">
                        <div class="mb-3">
                            <h5 class="mb-3 text-success">Frequently Asked Questions</h5>

                            <div class="dropdown-accordion" id="accordion">

                                <!-- Question 1 -->
                                <div class="dropdown">
                                    <div class="mb-2 p-2" id="heading1">
                                        <h6 class="mb-0">
                                            <button class="btn btn-success shadow-none text-center" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                What's the time for my Check-in and Check-out? <i class="fas fa-caret-down ms-2"></i>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Standard check-in time is at 2pm and check-out is at 12pm.
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2 -->
                                <div class="dropdown">
                                    <div class="mb-2 p-2" id="heading2">
                                        <h6 class="mb-0">
                                            <button class="btn btn-success shadow-none text-center" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                Do you allow early check-in and late check-out? <i class="fas fa-caret-down ms-2"></i>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse2" class="collapse" aria-labelledby="heading2" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            We honor requests for early check-in and late check-out, but availability is subject to confirmation and availability. Please note that applicable charges apply for the succeeding hours. (P500/Hour)
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3 -->
                                <div class="dropdown">
                                    <div class="mb-2 p-2" id="heading3">
                                        <h6 class="mb-0">
                                            <button class="btn btn-success shadow-none text-center" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                Do you have a smoking policy in this hotel? <i class="fas fa-caret-down ms-2"></i>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse3" class="collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            There is NO designated smoking area. Therefore, it is forbidden to use cigarettes, vape pens, or electronic cigarettes in any guest room. A fine of P3,000 for each offender and incident.
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 4 -->
                                <div class="dropdown">
                                    <div class="mb-2 p-2" id="heading4">
                                        <h6 class="mb-0">
                                            <button class="btn btn-success shadow-none text-center" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                Do you provide parking for hotel guests? <i class="fas fa-caret-down ms-2"></i>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse4" class="collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Yes, although parking is dependent on availability, every room reserved by a hotel guest is entitled to one (1) complimentary parking space. We can refer you to Bonifacio Park, while you choose to stay with us.
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 5 -->
                                <div class="dropdown">
                                    <div class="mb-2 p-2" id="heading5">
                                        <h6 class="mb-0">
                                            <button class="btn btn-success shadow-none text-center" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                What are the rooms offered by the hotel? <i class="fas fa-caret-down ms-2"></i>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse5" class="collapse" aria-labelledby="heading5" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            It offers a Presidential Suite, Deluxe Room, Standard Room, Bedroom Suite, and Suite Room.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End of FAQ -->

            <!-- END OFADDITIONAL LALAGYAN NA LANG BOARDER -->



            <!-- reviews -->
            <div class="mb-3"><br>
                <h5 class="mb-3 text-success">&nbsp;&nbsp;Reviews & Ratings</h5>

                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <h1 class="text-warning mt-4 mb-4">
                                    <b><span id="average_rating">0.0</span> / 5</b>
                                </h1>
                                <div class="mb-3">
                                    <i class="fas fa-star star-light mr-1 main_star"></i>
                                    <i class="fas fa-star star-light mr-1 main_star"></i>
                                    <i class="fas fa-star star-light mr-1 main_star"></i>
                                    <i class="fas fa-star star-light mr-1 main_star"></i>
                                    <i class="fas fa-star star-light mr-1 main_star"></i>
                                </div>
                                <h3><span id="total_review">0</span> Review</h3>
                            </div>
                            <div class="col-sm-4">
                                <p>
                                <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                                <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                                </div>
                                </p>
                                <p>
                                <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                                <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                                </div>
                                </p>
                                <p>
                                <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                                <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                                </div>
                                </p>
                                <p>
                                <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                                <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                                </div>
                                </p>
                                <p>
                                <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                                <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5" id="review_content"></div>

            </div>

            <div class="col-12">
                <h5 class="mb-3 text-success">&nbsp;&nbsp;Payment Instructions</h5>
            </div>
            <img src="img/roadmap.png" alt="roadmap picture" class="img-fluid mb-3">

        </div>
    </div>
    </div>

    <!-- <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star star-light me-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light me-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light me-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light me-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light me-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <input type="text" name="user_name" id="user_name" class="form-control mb-2" placeholder="Enter Your Name" />
                    </div>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <input type="text" name="user_name" id="user_name" class="form-control mb-2" placeholder="Enter Your Name" />
                    </div>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-success" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room End -->





    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->


    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

    <!-- Javascript for Book Now Rooms para pumunta sa confirm_booking -->
    <script>
        function checkLoginToBook1(isLoggedIn, roomId, checkin, checkout) {
            if (isLoggedIn) {
                // Check if checkin and checkout are not null

                // Redirect to confirm_booking.php with room_id, checkin, and checkout parameters
                window.location.href = 'confirm_booking.php?room_id=' + roomId + '&checkin=' + checkin + '&checkout=' + checkout;
            } else {
                // Show login modal if not logged in
                $('#loginModal').modal('show');
            }
        }
    </script>

    <!-- End of Javascript for Book Now Rooms para pumunta sa confirm_booking -->


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


        //ratings review script
        $(document).ready(function() {
            var rating_data = 0;

            $('#add_review').click(function() {
                $('#review_modal').modal('show');
            });

            $(document).on('mouseenter', '.submit_star', function() {
                var rating = $(this).data('rating');
                reset_background();
                for (var count = 1; count <= rating; count++) {
                    $('#submit_star_' + count).addClass('text-warning');
                }
            });

            function reset_background() {
                for (var count = 1; count <= 5; count++) {
                    $('#submit_star_' + count).addClass('star-light');
                    $('#submit_star_' + count).removeClass('text-warning');
                }
            }

            $(document).on('mouseleave', '.submit_star', function() {
                reset_background();
                for (var count = 1; count <= rating_data; count++) {
                    $('#submit_star_' + count).removeClass('star-light');
                    $('#submit_star_' + count).addClass('text-warning');
                }
            });

            $(document).on('click', '.submit_star', function() {
                rating_data = $(this).data('rating');
            });

            $('#save_review').click(function() {
                var user_name = $('#user_name').val();
                var user_review = $('#user_review').val();

                if (user_name == '' || user_review == '') {
                    alert("Please fill out both fields.");
                    return false;
                } else {
                    $.ajax({
                        url: "ajax/submit_rating.php",
                        method: "POST",
                        data: {
                            rating_data: rating_data,
                            user_name: user_name,
                            user_review: user_review,
                            room_id: room_id
                        },
                        success: function(data) {
                            $('#review_modal').modal('hide');
                            load_rating_data();
                            alert(data);
                        }
                    });
                }
            });

            load_rating_data();

            function load_rating_data() {
                $.ajax({
                    url: "ajax/submit_rating.php",
                    method: "POST",
                    data: {
                        action: 'load_data',
                        room_id: <?php echo json_encode($room_data['room_id']); ?>
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#average_rating').text(data.average_rating);
                        $('#total_review').text(data.total_review);

                        var count_star = 0;

                        $('.main_star').each(function() {
                            count_star++;
                            if (Math.ceil(data.average_rating) >= count_star) {
                                $(this).addClass('text-warning');
                                $(this).addClass('star-light');
                            }
                        });

                        $('#total_five_star_review').text(data.five_star_review);
                        $('#total_four_star_review').text(data.four_star_review);
                        $('#total_three_star_review').text(data.three_star_review);
                        $('#total_two_star_review').text(data.two_star_review);
                        $('#total_one_star_review').text(data.one_star_review);

                        $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');
                        $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');
                        $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');
                        $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');
                        $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');

                        if (data.review_data.length > 0) {
                            var html = '';

                            for (var count = 0; count < data.review_data.length; count++) {
                                html += '<div class="row mb-3">';
                                html += '<div class="col-sm-1">';
                                html += '<div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">';
                                html += '<h3 class="m-0">' + data.review_data[count].user_id.charAt(0) + '</h3>';
                                html += '</div>';
                                html += '</div>';
                                html += '<div class="col-sm-11">';
                                html += '<div class="card mb-3">';
                                html += '<div class="card-header no-shadow"><b>' + data.review_data[count].user_id + '</b></div>';
                                html += '<div class="card-body">';

                                for (var star = 1; star <= 5; star++) {
                                    var class_name = '';
                                    if (data.review_data[count].rating >= star) {
                                        class_name = 'text-warning';
                                    } else {
                                        class_name = 'star-light';
                                    }
                                    html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                                }

                                html += '<br />';
                                html += data.review_data[count].review;
                                html += '</div>';
                                html += '<div class="card-footer text-end">On ' + data.review_data[count].datentime + '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }



                            $('#review_content').html(html);
                        }
                    }
                });
            }
        });
    </script>



</body>

</html>