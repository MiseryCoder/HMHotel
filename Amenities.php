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


    <title>HM Hotel | Services</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.AMactive {
            font-weight: bold;
            color: #198754;
        }

        .pop {
            height: 250px;
            width: auto;
        }

        @media screen and (max-width: 480px) {
            .pop {
                height: auto;
            }
        }

        .pop:hover {
            transform: scale(1.03);
            transition: all 0.3s;
        }

        .box:hover {
            transform: scale(1.10);
            /* Increase the size of the image on hover */
            transition: transform 0.2s ease;
            /* Add a smooth transition effect */
            cursor: pointer;
            /* Change the cursor to a pointer on hover */
        }

        .box {
            position: relative;
            overflow: hidden;
        }

        .details {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            /* Adjust the background color and transparency */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: justify;
            opacity: 0;
            transition: opacity 0.3s ease;
            font-size: 14px;

        }

        .box:hover .details {
            opacity: 1;
        }

        .details p {
            margin: 0;
            font-size: 55px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bolder;
            color: #198754;
        }

        .mb-4 {
            text-align: justify;
        }

        .h1 {
            text-align: center;
        }

        img {
            transition: transform 0.3s ease-in-out;
        }

        img:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php require('include/navigation.php') ?>
    <!-- End of Navigation Bar -->


    <!------Content------>
    <!-- Facilities Start -->
    <div class="our-services mt-5">
        <div class="container">
            <div class="text-center" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">
                <h1 class="mb-3">Welcome to <span class="text-dark text-uppercase">Services</span></h1>
                <div class="h-line bg-success mb-3"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 ">

                <div class="container">
                    <div class="row">
                        <div class="col-md-4 mt-3 col-lg-4" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
                            <img src="img/services/gym1.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                        </div>
                        <div class="col-md-4 mt-3 col-lg-4" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true">
                            <img src="img/services/gym6.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                        </div>
                        <div class="col-md-4 mt-3 col-lg-4" data-aos="fade-right" data-aos-duration="1600" data-aos-once="true">
                            <img src="img/services/spa5.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                        </div>
                        <div class="col-md-4 mt-3 col-lg-6" data-aos="fade-right" data-aos-duration="1800" data-aos-once="true">
                            <img src="img/services/spa4.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                        </div>
                        <div class="col-md-4 mt-3 col-lg-6" data-aos="fade-right" data-aos-duration="2000" data-aos-once="true">
                            <img src="img/services/gym3.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
                <h3 class="mb-3 text-success text-end">Our Services Offered</h3>
                <p class="text-justify">
                    The Pamantasan ng Lungsod ng Pasig Hospitality Management Hotel offers services that can
                    provide the satisfaction and needs of our dear guests. It consists of a gym, spa, and parking.
                    It also has a lobby which is the nerve center and main highlight of hotel.
                </p>
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 px-4" data-aos="slide-up" data-aos-duration="1600" data-aos-once="true">
                <div class="bg-white rounded shadow p-2 border-success border-top border-4 text-center box">
                    <img src="img/services/gym1.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                    <div class="details">
                        <p>GYM</p>
                        <p2>
                            A gym is a place where people go to train and <br>exercise, but also to unwind, socialize, and <br> recharge.
                            It is a facility that promotes physical <br>activity, provides a safe, functional, and <br> comfortable workout environment.
                        </p2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 px-4" data-aos="slide-up" data-aos-duration="1800" data-aos-once="true">
                <div class="bg-white rounded shadow p-2 border-success border-top border-4 text-center box">
                    <img src="img/services/parking1.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                    <div class="details">
                        <p>PARKING</p>
                        <p2 class="mb-0">
                            A location that is designated for parking, either <br>paved or unpaved.
                            It can be in a parking garage,<br> in a parking lot or on a city street.
                            The space <br>may be delineated by road surface markings.
                        </p2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 px-4" data-aos="slide-up" data-aos-duration="2000" data-aos-once="true">
                <div class="bg-white rounded shadow p-2 border-success border-top border-4 text-center box">
                    <img src="img/services/spa.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
                    <div class="details">
                        <p>SPA</p>
                        <p2>
                            A spa is a fancy hotel or resort, especially one <br> that offers health and beauty treatments or <br> is located near a natural mineral spring.
                        </p2>
                    </div>
                </div>
            </div>
        </div>


        <!------Navigation Bar
                        <div class="container">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-lg-4 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                                    
                                    <p class="mb-4 text-justify">
                                    A gym is a place where people go to train and exercise, but also to unwind, socialize, and recharge.
                                    It is a facility that promotes physical
                                     activity, provides a safe, functional, and comfortable workout environment.

                                    </p>
                                </div>

                                <div class="col-lg-4 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                                    <p class="mb-4"> a location that is designated for parking, either paved or unpaved.
                                         It can be in a parking garage, in a parking lot or on a city street. 
                                         The space may be delineated by road surface markings. </p>
                                </div>

                                <div class="col-lg-4 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                                    <p class="mb-4"> The Pamantasan ng Lungsod ng Pasig is a local university run by the Pasig city 
                                government in the Philippines, and the HM Hotel is associated with this school.</p>
                                </div>

                                
                                </div>
                            </div>
                            
                            ------>
        <br>
        <br>

    </div>
    </div>




    <!-- Facilities End -->


    <!-- pagdisplay ng data from database -->
    <?php


    // $res = selectAll('facilities');
    // $path = FACILITIES_IMG_PATH;

    // while ($row = mysqli_fetch_assoc($res)) {
    //     echo <<<data

    //                             <!--Drinks-->
    //                             <div class="tab-pane fade show active" id="drinks" role="tabpanel" aria-labelledby="drinks-tab">
    //                                 <div class="p-5">
    //                                     <div class="row gap100">

    //                                         <div class="col-md-6">
    //                                             <div class="position-relative">
    //                                                 <div class="card">
    //                                                     <div class="demo">
    //                                                         <img class="img-fluid" src="$path$row[icon]" width="100%" />


    //                                                     </div>
    //                                                 </div>
    //                                             </div>
    //                                         </div>

    //                                         <div class="col-md-6">
    //                                         <div class="d-flex justify-content-between mb-3">
    //                                             <h5 class="mb-0">$row[name]</h5>

    //                                         </div>

    //                                         <p class="text-break text-start">
    //                                         $row[description]
    //                                          </p>

    //                                     </div>
    //                                 </div>
    //                             </div>
    //                         data;
    // }
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