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

    <title>HM Hotel | FAQ</title>
</head>

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

    <!------Content------>
    <!-- Facilities Start -->
    <div class="our-services mt-5">
        <div class="container">
            <div class="text-center" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">
                <h1 class="mb-3">Frequently Asked Questions</span></h1>
                <div class="h-line bg-success"></div>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="card-body justify-content-center mb-4">
            <div id="accordion" class="accordion-style">
                <div class="card mb-1">
                    <div class="card-header" id="headingOne" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><span class="text-theme-secondary me-2">Q.</span>What time can I check in and check out?</button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                        <div class="card-body">
                            Standard check-in time is at 2 PM and check-out is at noon.
                            <div class="body" id="fback"><b>Was this helpful?</b>
                                <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingTwo" data-aos="slide-up" data-aos-duration="1400" data-aos-once="true">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><span class="text-theme-secondary me-2">Q.</span>Do you allow early check-in and late check-out? </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                        <div class="card-body">
                            We honor requests for early check-in and late check-out, but availability is subject to confirmation and availability. Please note that applicable charges apply for the succeeding hours. (P500/Hour)
                            <div class="body" id="fback"><b>Was this helpful?</b>
                                <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingThree" data-aos="slide-up" data-aos-duration="1800" data-aos-once="true">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><span class="text-theme-secondary me-2">Q.</span> Can I bring my pet to the hotel?</button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                        <div class="card-body">
                            Even though we adore pets, we cannot accommodate them in our rooms or public spaces.
                            <div class="body" id="fback"><b>Was this helpful?</b>
                                <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingFour" data-aos="slide-up" data-aos-duration="2000" data-aos-once="true">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"><span class="text-theme-secondary me-2">Q.</span>What is your smoking policy?</button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-bs-parent="#accordion">
                        <div class="card-body">
                            There is NO designated smoking area. Therefore, it is forbidden to use cigarettes, vape pens, or electronic cigarettes in any guest room. A fine of P3,000 for each offender and incident.
                            <div class="body" id="fback"><b>Was this helpful?</b>
                                <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive" data-aos="slide-up" data-aos-duration="2100" data-aos-once="true">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"><span class="text-theme-secondary me-2">Q.</span> Do you provide parking for hotel guests?</button>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#accordion">
                        <div class="card-body">
                            Yes, although parking is dependent on availability, every room reserved by a hotel guest is entitled to one (1) complimentary parking space. We can refer you to Bonifacio Park, while you choose to stay with us.
                            <div class="body" id="fback"><b>Was this helpful?</b>
                                <div id="emojiRating" class="emoji-rating" onclick=""> 😊😐😟 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Facilities End -->


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