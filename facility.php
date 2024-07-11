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

    <title>HM Hotel | Facility</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Factive {
            font-weight: bold;
            color: #198754;
        }

        .picture-frame {
            border: 0px solid #333;
            /* Border color and width */
            padding: 10px;
            /* Padding around the image */
            border-radius: 8px;
            /* Optional: Add rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Optional: Add a subtle shadow */
        }


        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid gray;
            /* Set border color to white */
        }

        th,
        td {
            border: 1px solid gray;
            /* Set border color to white */
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #198754;
            color: white;
            padding: 10px;
            text-align: center;
        }

        @media screen and (max-width: 480px) {

            th,
            td {

                width: 100%;
            }
        }

        .two-column {
            display: flex;
            justify-content: space-evenly;
            font-size: 18px;

        }

        .column {
            width: 48%;
            /* Adjust the width as needed */
        }


        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        img {
            animation: fadeIn 5.0s ease-out;
        }

        table.table-text thead {
            background-color: #198754;
            color: #fff;
        }

        ul,
        p {
            text-align: justify;
        }

        li {
            text-align: justify;
            margin-bottom: 2px;
            /* Adjust as needed for spacing between items */
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php
    require('include/navigation.php');

    ?>
    <!-- End of Navigation Bar -->

    <!------Content------>


    <!-- Room Start -->


    <div class="container-fluid py-5 mt-5">
        <div class="text-center">
            <h1 class="mb-3" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">Our <span class="text-dark">Facilities</span></h1> <!-- Change Text into black -->
            <div class="h-line bg-success mb-3"></div>
        </div>
        <!-- FUNCTION -->
        <div class='card mb-4 border-0 shadow'>
            <div class='row g-0 p-2 align-items-center' data-aos="zoom-in" data-aos-duration="1000" data-aos-once="true">
                <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                    <img src="img/facilities/functionhall.jpg" alt="School Image" class="img-fluid" alt="Responsive Image" width="500">
                </div>
                <div class='col-md-7 px-lg-3 px-md-0 px-0'>
                    <b>
                        <h2 class="mb-3 text-success text-center">THE <span class="text-success">FUNCTION HALL</span></h2>
                    </b>
                    <p class="text-justify" style="font-size: 20px; margin-left: 30px; margin-right: 30px;">
                        It holds all kinds of events other than private parties and celebrations of personal
                        occasions.
                        Just like the banquet halls they can also be big or small in size.
                        A function hall may have a dais or an elevated platform built inside to facilitate
                        the events.
                    </p><br>
                    <div class="row align-items-center px-4">
                        <div class="col-md-4">
                            <div class="column1" style="display: flex; align-items: center;">
                                <p>
                                    <i class="bi bi-person-fill-check" style="color: #198754; font-size: 20px; margin-right: 5px;"></i>
                                    <b>:</b> Up to 100 Pax
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="column1" style="display: flex; align-items: center;">
                                <p>
                                    <i class="bi bi-clock-fill" style="color: #198754; font-size: 18px; margin-right: 5px;"></i>
                                    <b>:</b> 8:00 AM - 9:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center px-4">
                        <div class="col-md-8">
                            <div class="column1" style="display: flex; align-items: center;">
                                <p style="color: #616161;">
                                    <i class="bi bi-info-circle"></i>
                                    Bookings of facilities should be made in person as academic activity is given priority, and requests are subject to availability.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="column1" style="display: flex; align-items: center; justify-content: flex-end;">
                                <button type="button" class="btn btn-success"><a href="#" data-bs-toggle="modal" data-bs-target="#price2Modal" style="text-decoration: none; color: white;">More Details</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROOMS EX -->
        <div class='card mb-4 border-0 shadow'>
            <div class='row g-0 p-2 align-items-center' data-aos="zoom-in" data-aos-duration="1500" data-aos-once="true">
                <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                    <img src="img/facilities/banquethall.jpg" alt="School Image" class="img-fluid" alt="Responsive Image" width="500">
                </div>
                <div class='col-md-7 px-lg-3 px-md-0 px-0'>
                    <b>
                        <h2 class="mb-3 text-success text-center">THE <span class="text-success">BANQUET HALL</span></h2>
                    </b>
                    <p class="text-justify" style="font-size: 20px; margin-left: 30px; margin-right: 30px;">
                        A banquet hall, function hall, or reception hall, is a special purpose room, or a building,
                        used for hosting large social and business events. Typically a banquet hall
                        is capable of serving dozens to hundreds of people a meal in a timely fashion.
                    </p><br>
                    <div class="row align-items-center px-4">
                        <div class="col-md-4">
                            <div class="column1" style="display: flex; align-items: center;">
                                <p>
                                    <i class="bi bi-person-fill-check" style="color: #198754; font-size: 20px; margin-right: 5px;"></i>
                                    <b>:</b> Up to 150 Pax
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="column1" style="display: flex; align-items: center;">
                                <p>
                                    <i class="bi bi-clock-fill" style="color: #198754; font-size: 18px; margin-right: 5px;"></i>
                                    <b>:</b> 8:00 AM - 9:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center px-4">
                        <div class="col-md-8">
                            <div class="column1" style="display: flex; align-items: center;">
                                <p style="color: #616161;">
                                    <i class="bi bi-info-circle"></i>
                                    Bookings of facilities should be made in person as academic activity is given priority, and requests are subject to availability.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="column1" style="display: flex; align-items: center; justify-content: flex-end;">
                                <button type="button" class="btn btn-success"><a href="#" data-bs-toggle="modal" data-bs-target="#priceModal" style="text-decoration: none; color: white;">More Details</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-12 col-md-12 mb-1">
                <div class="card border-0 offset-lg-0 shadow-sm rounded-3 px-2">
                    <div class="card-body">

                        <div class="row justify-content-center mb-4" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
                        <div class='col-md-7 mb-lg-0 mb-md-0 mb-3'>
                                <b>
                                    <h2 class="mb-3 text-success text-center">THE <span class="text-success">FUNCTION
                                            HALL</span></h2>
                                </b>
                                <p class="text-justify" style="font-size: 20px; margin-left: 30px; margin-right: 30px;">
                                    It holds all kinds of events other than private parties and celebrations of personal
                                    occasions.
                                    Just like the banquet halls they can also be big or small in size.
                                    A function hall may have a dais or an elevated platform built inside to facilitate
                                    the events.
                                </p><br>
                                <p><i class="bi bi-person-fill-check" style="color: #198754; font-size: 20px;"></i><b>:</b> Up to 100 Pax</p>


                                <div class="row align-items-center px-4">
                                            <div class="col-md-4">
                                                <div class="column1">
                                                    <p>
                                                        <i class="bi bi-person-fill-check" style="color: #198754; font-size: 20px;"></i>
                                                        <b>:</b> Up to 100 Pax
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="column1">
                                                    <p>
                                                        <i class="bi bi-clock-fill" style="color: #198754; font-size: 18px;"></i>
                                                        <b>:</b> 8:00 AM - 9:00 PM
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="column2">
                                                <button type="button" class="btn btn-success"><a href="#" data-bs-toggle="modal" data-bs-target="#price2Modal" style="text-decoration: none; color: white;">More Details</a></button>
                                                </div>
                                            </div>
                                        </div>
                                 </div>

                            <div class="col-lg-4 col-md-5 mb-4 order-lg-1 order-md-2 order-2 shadow-sm"><br>
                                <img src="img/facilities/functionhall.jpg" alt="School Image" class="img-fluid"
                                    alt="Responsive Image" width="500">
                            </div>
                        </div>

                    </div>
                </div>
                <br> -->

        <!------pic 2------>

        <!-- <div class="row">
                    <div class="col-lg-12 col-md-12 mb-1">
                        <div class="card border-0 offset-lg-0 shadow-sm rounded-3 px-2">
                            <div class="card-body">

                                <div class="row justify-content-center mb-4" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
                                    <div class="col-lg-8 col-md-7 mb-4 order-lg-1 order-md-1 order-1">

                                        <b>
                                            <h2 class="mb-3 text-success text-center">THE <span
                                                    class="text-success">BANQUET HALL</span></h2>
                                        </b> <!-- Change Text into black -->


        <!-- <p class="text-justify"
                                            style="font-size: 20px; margin-left: 30px; margin-right: 30px;">
                                            A banquet hall, function hall, or reception hall, is a special purpose room,
                                            or a building,
                                            used for hosting large social and business events. Typically a banquet hall
                                            is capable of
                                            serving dozens to hundreds of people a meal in a timely fashion.
                                        </p><br>


                                        <div class="row align-items-center px-4">
                                            <div class="col-md-4">
                                                <div class="column1">
                                                    <p>
                                                        <i class="bi bi-person-fill-check" style="color: #198754; font-size: 20px;"></i>
                                                        <b>:</b> Up to 150 Pax
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="column1">
                                                    <p>
                                                        <i class="bi bi-clock-fill" style="color: #198754; font-size: 18px;"></i>
                                                        <b>:</b> 8:00 AM - 9:00 PM
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="column2">
                                                <button type="button" class="btn btn-success"><a href="#" data-bs-toggle="modal" data-bs-target="#priceModal" style="text-decoration: none; color: white;">More Details</a></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div> -->



        <!-- <div class="col-lg-4 col-md-5 mb-4 order-lg-2 order-md-2 order-2 shadow-sm"><br>

                                        <img src="img/facilities/banquethall.jpg" alt="School Image"
                                            class="img-fluid" alt="Responsive Image" width="500">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <br> -->
        <!-- </div> -->
    </div>
    <br>

    <!-- Banquet Modal -->
    <div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="priceModalLabel">Banquet Hall</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <center> -->
                    <div class="col-lg-12 col-md-12 mb-1 px-4 py-2">
                        <h6>Prices</h6>
                        <div class="table-responsive">
                            <table class="table-text">
                                <thead>
                                    <tr>
                                        <td class="text-center fw-bold">PLP Facility - Banquet Hall</td>
                                        <td class="text-center fw-bold">Pasigueños</td>
                                        <td class="text-center fw-bold">Non-Pasigueños</td>
                                    </tr>
                                </thead>
                                <tr>
                                    <td class="text-center">First three (3) hours</td>
                                    <td class="text-center fw-bold">₱ 10,000.00</td>
                                    <td class="text-center fw-bold">₱ 15,000.00</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Every succeeding hour/fraction thereof</td>
                                    <td class="text-center fw-bold">₱ 1,000.00</td>
                                    <td class="text-center fw-bold">₱ 2,000.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <h6 class>Guidelines</h6>
                        <ul>
                            <li>Letter of request for venue availability must be processed and approved prior to consumption of the facility.</li>
                            <li>Venue Set up – Aesthetic is not included. Any improvement and/or designing needed is not covered in the request. Installation of décor in the ceiling, walls and windows are strictly prohibited – violation can forfeit deposit. </li>
                            <li>Venue Capacity is 150 pax only.</li>
                            <li>There must be a designated approved utility assigned at all event.</li>
                            <li>Renter will be required to surrender a security deposit of Five Thousand Pesos (P5,000), which will be used for any damages, loss or for exceeding hour/s. This will be returned after two working days after the clearance is processed.</li>
                            <li>Renter will be allowed two hours’ time for Ingress (set up) and another Two hours Egress (pull out). However, any exceeding fraction of time will be charged to the client.</li>
                            <li>Minimum of three (3) hours rent is equivalent to P10,000 and additional P1,000 per exceeding hour.</li>
                            <li>The University will not be liable to any loss or damage of personal property of the client and their guest.</li>
                            <li>Utility personnel that will be assigned to the event will be personally compensated by the client.</li>
                            <li>For outside catering service, sound System, and other outsource suppliers – a deposit of P5,000 is required for any damages and or loss in facilities related to the catering company. This will be returned after two working days after the clearance is processed.</li>
                            <li>Any damages or loss in the facility and adjoining areas resulted from the negligence of the renter are subject to monetary payment.</li>
                            <li>All activities and preparation must be within the time period of 8:00 am to 9:00 pm only.</li>
                            <li>A maximum of 5 parking slots are allotted in the HRM Building for the paying client event. Plate Number will be requested from the client for building access.</li>
                            <li>Strictly NO Smoking in the entire premises and a fine of P3,000 on each violator and incident.</li>
                            <li>There is NO Designated Smoking Area.</li>
                            <li>Loitering is not allowed.</li>
                            <li>Guests and participants are not allowed to stay in ANY other areas but the approved venue only.</li>
                        </ul>
                    </div>
                    <!-- </center> -->
                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
            </div>
        </div>
    </div>

    <!-- Function Hall Prices2 Modal -->
    <div class="modal fade" id="price2Modal" tabindex="-1" aria-labelledby="price2ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="priceModalLabel">Function Hall</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <center> -->
                    <div class="col-lg-12 col-md-12 mb-1 px-4 py-2">
                        <h6>Prices</h6>
                        <div class="table-responsive">
                            <table class="table-text">
                                <thead>
                                    <tr>
                                        <td class="text-center fw-bold">PLP Facility - Function Hall</td>
                                        <td class="text-center fw-bold">Pasigueños</td>
                                        <td class="text-center fw-bold">Non-Pasigueños</td>
                                    </tr>
                                </thead>
                                <tr>
                                    <td class="text-center">First three (3) hours</td>
                                    <td class="text-center fw-bold">₱ 5,000.00</td>
                                    <td class="text-center fw-bold">₱ 10,000.00</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Every succeeding hour/fraction thereof</td>
                                    <td class="text-center fw-bold">₱ 1,000.00</td>
                                    <td class="text-center fw-bold">₱ 2,000.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <h6>Guidelines</h6>
                        <ul>
                            <li>Letter of request for venue availability must be processed and approved prior to consumption of the facility.</li>
                            <li>Venue Set up – Aesthetic is not included. Any improvement and/or designing needed is not covered in the request. Installation of décor in the ceiling, walls and windows are strictly prohibited – violation can forfeit deposit. </li>
                            <li>Venue Capacity is 150 pax only.</li>
                            <li>There must be a designated approved utility assigned at all event.</li>
                            <li>Renter will be required to surrender a security deposit of Five Thousand Pesos (P5,000), which will be used for any damages, loss or for exceeding hour/s. This will be returned after two working days after the clearance is processed.</li>
                            <li>Renter will be allowed two hours’ time for Ingress (set up) and another Two hours Egress (pull out). However, any exceeding fraction of time will be charged to the client.</li>
                            <li>Minimum of three (3) hours rent is equivalent to P10,000 and additional P1,000 per exceeding hour.</li>
                            <li>The University will not be liable to any loss or damage of personal property of the client and their guest.</li>
                            <li>Utility personnel that will be assigned to the event will be personally compensated by the client.</li>
                            <li>For outside catering service, sound System, and other outsource suppliers – a deposit of P5,000 is required for any damages and or loss in facilities related to the catering company. This will be returned after two working days after the clearance is processed.</li>
                            <li>Any damages or loss in the facility and adjoining areas resulted from the negligence of the renter are subject to monetary payment.</li>
                            <li>All activities and preparation must be within the time period of 8:00 am to 9:00 pm only.</li>
                            <li>A maximum of 5 parking slots are allotted in the HRM Building for the paying client event. Plate Number will be requested from the client for building access.</li>
                            <li>Strictly NO Smoking in the entire premises and a fine of P3,000 on each violator and incident.</li>
                            <li>There is NO Designated Smoking Area.</li>
                            <li>Loitering is not allowed.</li>
                            <li>Guests and participants are not allowed to stay in ANY other areas but the approved venue only.</li>
                        </ul>
                    </div>
                    <!-- </center> -->
                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
            </div>
        </div>
    </div>
    <!------Table for Items, Per Event & Unit------>


    <div class="text-center">
        <h1 class="mb-3">ITEMS <span class="text-dark">RENTAL FOR EVENT</span></h1>
        <!-- Change Text into black -->
        <div class="h-line bg-success mb-2"></div>
    </div>

    <center>
        <div class="col-lg-8 col-md-12 mb-5" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
            <div class="card border-0 offset-lg-0 shadow-sm rounded-3 px-2">
                <div class="card-body">


                    <table>
                        <tr>
                            <th>Items</th>
                            <th>Per Event</th>
                            <th>Unit</th>
                        </tr>
                        <tr>
                            <td>Grand Piano</td>
                            <td>₱5,000.00</td>
                            <td>per day</td>
                        </tr>
                        <tr>
                            <td>Upright Piano</td>
                            <td>₱5,000.00</td>
                            <td>per day</td>
                        </tr>
                        <tr>
                            <td>LCD Projector and Screen</td>
                            <td>₱5,000.00</td>
                            <td>per day</td>
                        </tr>
                        <tr>
                            <td>Long Tables</td>
                            <td>₱100.00</td>
                            <td>per piece</td>
                        </tr>
                        <tr>
                            <td>Microphones and Speaker</td>
                            <td>₱5,000.00</td>
                            <td>per day</td>
                        </tr>
                        <tr>
                            <td>Misting Fan</td>
                            <td>₱500.00</td>
                            <td>per piece</td>
                        </tr>
                        <tr>
                            <td>Monolithic Chair</td>
                            <td>₱10.00</td>
                            <td>per piece</td>
                        </tr>
                        <tr>
                            <td>Tifanny Chair</td>
                            <td>₱20.00</td>
                            <td>per piece</td>
                        </tr>
                    </table>
    </center>





    </div>
    </div>
    </div>
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

    <script src="css/animation/aos.js"></script>
    <script>
        AOS.init({
            duration: 3000,
            once: true,
        });
    </script>


    <!---- carousel javascript ----->
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
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