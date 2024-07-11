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
    <link rel="stylesheet" href="css/animation/aos.css">

    <title>HM Hotel | T&C</title>

<body>
    <!------Navigation Bar------>
    <?php require('include/navigation.php'); ?>
    <!-- End of Navigation Bar -->
    <style>
        .pop {
            height: 250px;
            width: auto;
        }

        .pop:hover {
            transform: scale(1.03);
            transition: all 0.3s;
        }

        .accordion-style .card {
            background: transparent;
            box-shadow: none;
            margin-bottom: 15px;
            margin-top: 0 !important;
            border: none;
        }

        .accordion-style .card:last-child {
            margin-bottom: 0;
        }

        .accordion-style .card-header {
            border: 0;
            background: none;
            padding: 0;
            border-bottom: none;
        }

        .accordion-style .btn-link {
            color: #ffffff;
            position: relative;
            background: #198754;
            border: 1px solid #198754;
            display: block;
            width: 100%;
            font-size: 18px;
            border-radius: 3px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            text-align: left;
            white-space: normal;
            box-shadow: none;
            padding: 15px 55px;
            text-decoration: none;
        }

        .accordion-style .btn-link:hover {
            text-decoration: none;
        }

        .accordion-style .btn-link.collapsed {
            background: #ffffff;
            border: 1px solid #198754;
            color: #1e2022;
            border-radius: 3px;
        }

        .accordion-style .btn-link.collapsed:after {
            background: none;
            border-radius: 3px;
            content: "+";
            left: 16px;
            right: inherit;
            font-size: 20px;
            font-weight: 600;
            line-height: 26px;
            height: 26px;
            transform: none;
            width: 26px;
            top: 15px;
            text-align: center;
            background-color: #198754;
            color: #fff;
        }

        .accordion-style .btn-link:after {
            background: #fff;
            border: none;
            border-radius: 3px;
            content: "-";
            left: 16px;
            right: inherit;
            font-size: 20px;
            font-weight: 600;
            height: 26px;
            line-height: 26px;
            transform: none;
            width: 26px;
            top: 15px;
            position: absolute;
            color: #198754;
            text-align: center;
        }

        .accordion-style .card-body {
            padding: 20px;
            border-top: none;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-left: 1px solid #198754;
            border-right: 1px solid #198754;
            border-bottom: 1px solid #198754;
        }

        @media screen and (max-width: 767px) {
            .accordion-style .btn-link {
                padding: 15px 40px 15px 55px;
            }
        }

        @media screen and (max-width: 575px) {
            .accordion-style .btn-link {
                padding: 15px 20px 15px 55px;
            }
        }

        .card-style1 {
            box-shadow: 0px 0px 10px 0px rgb(89 75 128 / 9%);
        }

        .border-0 {
            border: 0 !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #198754;
            border-radius: 0.25rem;
        }

        section {
            padding: 120px 0;
            overflow: hidden;
            background: #fff;
        }

        .mb-2-3,
        .my-2-3 {
            margin-bottom: 2.3rem;
        }

        .section-title {
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .text-primary {
            color: #ceaa4d !important;
        }

        .emoji-rating {
            font-size: 20px;
            cursor: pointer;
        }

        .emoji-rating,
        #fback {
            text-align: right;
        }
    </style>




    </head>

    <!------Content------>

    <!-- Terms and Condition Start -->
    <div class="our-services mt-5">
        <div class="container">
            <div class="text-center" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">
                <h1 class="mb-3">Terms and Conditions</span></h1>
                <div class="h-line bg-success"></div><br>
            </div>
        </div>
    </div>


    <!------Pet Policy------>

    <div class="row">
        <div class="col-lg-5 col-md-12 mb-3">
            <div class="card border-0 offset-lg-1 shadow-sm rounded-3 px-6">
                <div class="card-body">
                    <div class="card-body justify-content-center mb-4">


                        <div class="accordion-style">
                            <div class="card mb-1">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" id="detailsButton" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true" onclick="toggleDetails()">Check-in & Check-out Policy</button><br>
                                        <button class="btn btn-link" id="detailsButton1" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" onclick="toggleDetails1()">Payment Policy</button><br>
                                        <button class="btn btn-link" id="detailsButton2" data-aos="fade-right" data-aos-duration="1800" data-aos-once="true" onclick="toggleDetails2()">Cancellation Policy</button><br>
                                        <button class="btn btn-link" id="detailsButton3" data-aos="fade-right" data-aos-duration="2000" data-aos-once="true" onclick="toggleDetails3()">Guest Belongings</button><br>
                                        <button class="btn btn-link" id="detailsButton4" data-aos="fade-right" data-aos-duration="2000" data-aos-once="true" onclick="toggleDetails4()">Other Policies</button>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------Details Pet Policy------>

        <div class="col-lg-6 col-md-12 mb-3">
            <div id="detailsContent" style="display: none;" class="card border-0 shadow-sm rounded-3">
                <div class="card-body" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
                    <h5>Guest Rooms:</h5>
                    <ul>
                        <li>Guest check-in time is 2:00 in the afternoon while check-out time is 12:00 noon the following day.</li>
                        <li>All guests are required to register prior to checking in and must have a valid ID to be photocopied.</li>
                        <li>Room designation will be confirmed upon arrival.</li>
                        <li>Late check-out and early check-in are subject to additional charges (P500/Hour).</li>
                        <li>A deposit per night will be required.</li>
                    </ul>
                    <br><br>

                    <div class="body" id="fback"><b>Was this helpful?</b>
                        <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                    </div>
                </div>

                <div class="card-body" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true">
                    <h5>Facilities:</h5>
                    <ul>
                        <li>Request is subject to availability, prioritizing Academic Activity.</li>
                        <li>Letter of request for venue availability must be processed and approved prior to consumption of the facility.</li>
                        <li>Renter will be required to surrender a security deposit of five thousand pesos (P5,000), which will be used for any damages, loss or for exceeding hour/s. This will be return after two working days after the clearance is processed.</li>
                        <li>Renter will be allowed two hours’ time for Ingress (set up) and another two hours Egress (pull out). However, any exceeding fraction of time will be charge to the client.</li>
                        <li>All activities and preparation must be within the time period of 8:00am to 9:00pm only.</li>
                    </ul>
                    <br><br>

                    <div class="body" id="fback"><b>Was this helpful?</b>
                        <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                    </div>
                </div>
            </div>
            <!------End Pet Policy------>

            <!------Details Payment Policy------>
            <div class="col-lg-12 col-md-12 mb-3">
                <div id="detailsContent1" style="display: none;" class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h5>Facilities:</h5>
                        <ul>
                            <li>Minimum of three (3) hours rent is equivalent to P10,000 and additional P1,000 per exceeding hour.</li>
                            <li>For outside catering service, sound system and other outsource suppliers – a deposit of P5, 000 is required for any damages and or loss in facilities related to catering company. This will be return after two working days after the clearance is processed.</li>
                        </ul>
                        <br>

                        <h6 style="color:#198754;">Capacity</h6>
                        <ul>
                            <li><b>For Guest Rooms:</b> &nbsp;Each room capacity will be based on the room layout.<br></li>
                            <li><b>For Facilities:</b><br> &nbsp;&nbsp;&nbsp;&nbsp;<i>a. HM Banquet Hall – 150 pax only.</i> <br> &nbsp;&nbsp;&nbsp;&nbsp;<i>b. HM Function Room – 100 pax only</i></li>
                        </ul>
                        <br>
                        <h6 style="color:#198754;">Visitors</h6>
                        <ul>
                            <li>Additional guest per room will incur charges.<br></li>
                            <li>Visitor is allowed till 8pm only. Beyond the time approve will incur charges. (P1,000/Pax)</li>
                        </ul>
                        <br>
                        <div class="body" id="fback"><b>Was this helpful?</b>
                            <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------End Details Payment Policy------>

            <!------Details Cancellation Policy------>

            <div class="col-lg-12 col-md-12 mb-3">
                <div id="detailsContent2" style="display: none;" class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h6>If the payment is not settled within the day, your booking will be canceled;</h6> <br>
                        <h6>If the Booking is:</h6>
                        <ul>
                            <li><b><span style="color:#198754;">Reserved</span></b> already - You should directly contact the hotel at least two (2) days before</li></b>
                            the check-in date, as it has already been paid.<br><br>
                            <li><b><span style="color:#198754;">Booked</span></b> - You can cancel your booking two (2) days prior to the check-in date. But if you plan to cancel it on the same day
                                or a day before the check-in date, you should directly contact the hotel.</li>
                        </ul>
                        <br><br>
                        <div class="body" id="fback"><b>Was this helpful?</b>
                            <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------End Details Cancellation Policy------>

            <!------Reservation Policy ------>

            <div class="col-lg-12 col-md-12 mb-3">
                <div id="detailsContent3" style="display: none;" class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <ul>
                            <li>Guest must keep their valuable secured at all times. </li>
                            <li>Any damages or loss in the facility and adjoining areas resulted from the negligence of the renter is subject to monetary payment.</li>
                        </ul>

                        <br><br>

                        <div class="body" id="fback"><b>Was this helpful?</b>
                            <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------End Details of Guest Belongings------>

            <!------Details Other Policies Belongings ------>

            <div class="col-lg-12 col-md-12 mb-3">
                <div id="detailsContent4" style="display: none;" class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <ul>
                            <li>Strictly <b>NO Smoking</b> in the entire premises and a fine of <b>P3,000</b> on each violator and incident.</li>
                            <li> There is <b>NO Designated Smoking Area.</b></li>
                            <li>Loitering is not allowed.</li>
                            <li>Guests and participants are not allowed to stay in ANY other areas but the approved venue only.</li>
                            <li>No pets allowed.</li>
                        </ul>
                        <br>

                        <div class="body" id="fback"><b>Was this helpful?</b>
                            <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------End Details of Other Policies Belongings------>

        </div>
    </div>
    </div>

    <!------  javascript for t&C -------->


    <script>
        //function for check-in check-out policy
        function toggleDetails() {
            var detailsContent = document.getElementById("detailsContent");
            if (detailsContent.style.display === "none") {
                detailsContent.style.display = "block";
                document.getElementById("detailsButton").innerText = "Hide Details";
            } else {
                detailsContent.style.display = "none";
                document.getElementById("detailsButton").innerText = "Check-in & Check-out Policy";
            }
        }

        window.onload = function() {
            toggleDetails();
        };

        //function for payment policy
        function toggleDetails1() {
            var detailsContent = document.getElementById("detailsContent1");
            if (detailsContent.style.display === "none") {
                detailsContent.style.display = "block";
                document.getElementById("detailsButton1").innerText = "Hide Details";
            } else {
                detailsContent.style.display = "none";
                document.getElementById("detailsButton1").innerText = "Payment Policy";
            }
        }


        //function for cancellation policy
        function toggleDetails2() {
            var detailsContent = document.getElementById("detailsContent2");
            if (detailsContent.style.display === "none") {
                detailsContent.style.display = "block";
                document.getElementById("detailsButton2").innerText = "Hide Details";
            } else {
                detailsContent.style.display = "none";
                document.getElementById("detailsButton2").innerText = "Cancellation Policy";
            }
        }


        //function for guest Belongings policy
        function toggleDetails3() {
            var detailsContent = document.getElementById("detailsContent3");
            if (detailsContent.style.display === "none") {
                detailsContent.style.display = "block";
                document.getElementById("detailsButton3").innerText = "Hide Details";
            } else {
                detailsContent.style.display = "none";
                document.getElementById("detailsButton3").innerText = "Guest Belongings";
            }
        }


        //function for guest Belongings policy
        function toggleDetails4() {
            var detailsContent = document.getElementById("detailsContent4");
            if (detailsContent.style.display === "none") {
                detailsContent.style.display = "block";
                document.getElementById("detailsButton4").innerText = "Hide Details";
            } else {
                detailsContent.style.display = "none";
                document.getElementById("detailsButton4").innerText = "Other Policies";
            }
        }
    </script>
    </div>


    <!-- pagdisplay ng data from database -->
    <?php
    //Footer Start
    require('include/footer.php');
    //Footer End
    ?>

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

    <script src="css/animation/aos.js"></script>
    <script>
        AOS.init({
            duration: 3000,
            once: true,
        });
    </script>

</body>

</html>