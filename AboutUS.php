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

    <title>HM Hotel | About Us</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Aactive {
            font-weight: bold;
            color: #198754;
        }


        .mb-4 {
            text-align: justify;
            /* Set text justification */
            text-justify: inter-word;
            /* Specify the justification method */
        }

        .box {
            transition: transform 0.3s ease-in-out;
        }

        .box:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php require('include/navigation.php') ?>
    <!-- End of Navigation Bar -->


    <!-- eto ung pangkuha nung data sa database sa table na about_details-->
    <?php
    $about_q = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
    $values = [1];
    $about_r = mysqli_fetch_assoc(select($about_q, $values, 'i')); //select function sa admin/include/conn.php
    ?>

    <!------Content------>
    <!-- About Start -->
    <div id="about" class="container-xxl py-5 mt-5">

        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="text-center" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">
                        <h1>About <span class="text-dark">Us</span></h1>
                        <div class="h-line bg-success mb-1"></div>
                    </div>
                </div>

                <div class="container">
                    <div class="row justify-content-between align-items-center" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
                        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                            <h3 class="mb-3 text-success">Our Linked University</h3>
                            <p style="font-size: 18px;">
                                The Pamantasan ng Lungsod ng Pasig is a local
                                university run by the Pasig City government in the Philippines,
                                and the Hospitality Management Hotel is associated with this school.
                            </p>
                        </div>

                        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1" data-aos="zoom-in" data-aos-duration="2000" data-aos-once="true">

                            <img src="img/services/plp_school.jpg" alt="School Image" class="img-fluid" alt="Responsive Image" width="500">
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4 px-4" data-aos="zoom-in" data-aos-duration="1000" data-aos-once="true">
                            <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                <img src="img/about/hotel.svg" width="70">
                                <h4 class="mt-3">10 GUESTS ROOMS</h4>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4 px-4" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true">
                            <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                <img src="img/about/customers.svg" width="70">
                                <h4 class="mt-3">100+ CUSTOMERS</h4>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4 px-4" data-aos="zoom-in" data-aos-duration="1800" data-aos-once="true">
                            <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                <img src="img/about/rating.svg" width="70">
                                <h4 class="mt-3">50+ REVIEWS</h4>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4 px-4" data-aos="zoom-in" data-aos-duration="2000" data-aos-once="true">
                            <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                <img src="img/about/staff.svg" width="70">
                                <h4 class="mt-3">15 Staff</h4>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mb-3">Management <span class="text-dark">Team</span></h1>
                        <div class="h-line bg-success mb-5"></div>
                    </div>
                </div>

                <div class="container px-4">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper mb-5">
                            <?php
                            $res = selectAll('team_details');

                            while ($row = mysqli_fetch_assoc($res)) {
                                $path = ABOUT_IMG_PATH;
                                echo <<< data
                                        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                                            <img src="$path$row[picture]" width="400" height="400">
                                            <h5 class="mt-2">$row[name]</h5>
                                        </div>  
                                    data;
                            }
                            ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                            <h3 class="mb-3 text-success">About HM Hotel</h3>
                            <p class="mb-4" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true"><?php echo $about_r['site_about']; ?></p>
                        </div>

                        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                            <h1 class="mb-4"><span class="text-success text-uppercase">VISION</span></h1>
                            <p class="mb-4" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true"><?php echo $about_r['site_vision']; ?></p>

                            <h1 class="mb-4"><span class="text-success text-uppercase">MISSION</span></h1>
                            <p class="mb-4" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true"><?php echo $about_r['site_mission']; ?> </p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- floor plan of hotel -->
            <div class="container">
                <div class="text-center">
                    <h1 class="mb-3">The Floor<span class="text-dark"> Plan</span></h1>
                    <div class="h-line bg-success mb-5"></div>
                </div>
                <img src="img/roadmap.png" alt="roadmap picture" class="img-fluid mb-3" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
            </div>

        </div>
    </div>
    <!-- About End -->



    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 4,
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },

                640: {
                    slidesPerView: 1,
                },

                768: {
                    slidesPerView: 3,
                },

                1024: {
                    slidesPerView: 3,
                },

            }
        });
    </script>
    <script src="css/animation/aos.js"></script>
    <script>
        AOS.init({
            duration: 3000,
            once: true,
        });
    </script>
</body>

</html>