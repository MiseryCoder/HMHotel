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

    <title>HM Hotel | Rooms</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Ractive {
            font-weight: bold;
            color: #198754;
        }

        /* Default style for larger screens */
        .mb-2 {
            display: flex;
        }

        /* Change the layout for screens smaller than 576px (adjust as needed) */
        @media (max-width: 575.98px) {
            .mb-2 {
                display: block;
            }
        }

        .feature-checkbox {
            display: none;
        }

        .feature-checkbox.visible {
            display: block;
        }


        .see-more-btn {
            cursor: pointer;
            color: gray;
            font-size: 14px;
            /* Adjust the font size as needed */
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php
    require('include/navigation.php');

    $checkin_default = "";
    $checkout_default = "";
    $adult_default = "";
    $children_default = "";

    if (isset($_GET['check_availability'])) {
        $frm_data = filteration($_GET);



        $checkin_default = $frm_data['checkin'];
        $checkout_default = $frm_data['checkout'];
        $adult_default = $frm_data['adult'];
        $children_default = $frm_data['children'];
    }
    ?>
    <!-- End of Navigation Bar -->

    <!------Content------>


    <!------START OF UPDATES------>


    <!-- Room Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="text-center" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">
            <h1 class="mb-3">Our <span class="text-dark">Rooms</span></h1> <!-- change text to black -->
            <div class="h-line bg-success mb-5"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4 ">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">FILTERS</h4>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#filterdropdown" aria-controls="filterdropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterdropdown">
                            <div class="border bg-light p-3 rounded mb-3" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
                                <!-- Check availability -->
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>CHECK AVAILABILITY</span>
                                    <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                                </h5>


                                <!--  CALENDAR PICKER NAPAPALABAS NA YUNG DAYS -->


                                <label class="form-label" style="font-weight: 500;">Check-in</label>&nbsp;<span style="color: #198754" id="checkinDay"></span> <!--ito yung text para mapalabas yung correspond days --> <!-- Set the min attribute to disable past dates -->
                                <!-- Set the min attribute to disable past dates -->
                                <input type="date" class="form-control shadow-none custom-date-picker" onchange="chk_avail_filter()" value="<?php echo $checkin_default ?>" name="checkin" id="checkin" onchange="chk_avail_filter()" required min="<?php echo date('Y-m-d'); ?>"><br>



                                <label class="form-label" style="font-weight: 500;">Check-out</label>&nbsp;<span style="color: #198754" id="checkoutDay"></span> <!--ito yung text para mapalabas yung correspond days for checkout -->
                                <!-- Set the min attribute to disable past dates -->
                                <input type="date" class="form-control shadow-none custom-date-picker" value="<?php echo $checkout_default ?>" name="checkout" id="checkout" onchange="chk_avail_filter()" required min="<?php echo date('Y-m-d'); ?>">
                            </div>



                            <!-- JAVASCRIPT CALENDAR PICKER NAPAPALABAS NA YUNG DAYS -->

                            <script>
                                // Function to update the day of the week
                                function updateDayOfWeek(inputId, dayId) {
                                    var input = document.getElementById(inputId);
                                    var daySpan = document.getElementById(dayId);

                                    // Check if the input value is not empty
                                    if (input.value) {
                                        var date = new Date(input.value);
                                        var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                                        var dayOfWeek = daysOfWeek[date.getDay()];

                                        // Update the span with the day of the week
                                        daySpan.textContent = dayOfWeek;
                                    } else {
                                        // If input is empty, clear the span
                                        daySpan.textContent = '';
                                    }
                                }


                                // Attach event listeners to input elements
                                document.getElementById('checkin').addEventListener('input', function() {
                                    updateDayOfWeek('checkin', 'checkinDay');
                                });

                                document.getElementById('checkout').addEventListener('input', function() {
                                    updateDayOfWeek('checkout', 'checkoutDay');
                                });
                            </script>


                            <!-- END CALENDAR PICKER NAPAPALABAS NA YUNG DAYS -->




                            <div class="border bg-light p-3 rounded mb-3" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true">
                                <!-- Guests -->
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>CAPACITY</span>
                                    <button id="guests_btn" onclick="guests_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                                </h5>
                                <div class="d-flex w-100">
                                    <div class="me-3">
                                        <label class="form-check-label" for="f1">Adult</label>
                                        <input type="number" min="1" class="form-control shadow-none" value="<?php echo $adult_default ?>" id="adult" oninput="guests_filter()">
                                    </div>
                                    <div hidden>
                                        <label class="form-check-label" for="f1">Children</label>
                                        <input type="number" min="1" class="form-control shadow-none" value="<?php echo $children_default ?>" id="children" oninput="guests_filter()">
                                    </div>
                                </div>
                            </div>



                            <div class="border bg-light p-3 rounded mb-3" data-aos="fade-right" data-aos-duration="1800" data-aos-once="true">
                                <!-- Features -->
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>FEATURES</span>
                                    <div id="seeMoreBtn" class="see-more-btn" onclick="toggleFeatureVisibility()">See More</div>
                                    <button id="features_btn" onclick="features_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                                </h5>


                                <script>
                                    // Move the toggleFeatureVisibility function outside the document ready block
                                    function toggleFeatureVisibility() {
                                        var featureCheckboxes = document.querySelectorAll('.feature-checkbox');
                                        var seeMoreBtn = document.getElementById('seeMoreBtn');

                                        featureCheckboxes.forEach(function(checkbox, index) {
                                            checkbox.classList.toggle('visible');
                                            if (index === 4) {
                                                // Toggle "See More" button text
                                                seeMoreBtn.innerHTML = checkbox.classList.contains('visible') ? 'See More' : 'See Less';
                                            }
                                        });
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Your existing script code
                                        let rooms_data = document.getElementById('rooms-data');
                                        let checkin = document.getElementById('checkin');
                                        // ... (other variables and functions)

                                        window.onload = function() {
                                            fetch_rooms();
                                        };
                                    });
                                </script>

                                <?php
                                $features_q = selectAll('features');
                                $featureCount = 0;

                                while ($row = mysqli_fetch_assoc($features_q)) {
                                    $featureCount++;
                                    $displayClass = $featureCount <= 5 ? 'visible' : '';
                                    echo <<<features
                                            <div class="mb-2 feature-checkbox $displayClass">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" onclick="fetch_rooms()" name="features" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]">
                                                    <label class="form-check-label" for="$row[id]">$row[name]</label>
                                                </div>
                                            </div>
                                        features;
                                }
                                ?>

                                <?php if ($featureCount > 5) : ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4" id="rooms-data" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
                <!-- card -->
                <!-- Your room cards will be displayed here -->
            </div>
        </div>
    </div>
    <!-- Room End -->


    <!-- END OF UPDATES  -->


    <script>
        let rooms_data = document.getElementById('rooms-data');
        let checkin = document.getElementById('checkin');
        let chekout = document.getElementById('checkout');
        let chk_avail_btn = document.getElementById('chk_avail_btn');

        let adult = document.getElementById('adult');
        let children = document.getElementById('children');
        let guests_btn = document.getElementById('guests_btn');

        let features_btn = document.getElementById('features_btn');



        function fetch_rooms() {

            let chk_avail = JSON.stringify({
                checkin: checkin.value,
                checkout: checkout.value
            });

            let guests = JSON.stringify({
                adult: adult.value,
                children: children.value
            });

            let feature_list = {
                "features": []
            };

            let get_features = document.querySelectorAll('[name=features]:checked');
            if (get_features.length > 0) {
                get_features.forEach((features) => {
                    feature_list.features.push(features.value);
                });
                features_btn.classList.remove('d-none');
            } else {
                features_btn.classList.add('d-none');
            }

            feature_list = JSON.stringify(feature_list);


            let xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_avail=" + chk_avail + "&guests=" + guests + "&feature_list=" + feature_list, true);

            xhr.onprogress = function() {
                rooms_data.innerHTML = `<div class="spinner-border text-success mb-3 mx-auto" id="loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`;
            }

            xhr.onload = function() {
                rooms_data.innerHTML = this.responseText;
            }

            xhr.send();
        }

        function chk_avail_filter() {
            if (checkin.value != '' && checkout.value != '') {
                fetch_rooms();
                chk_avail_btn.classList.remove('d-none');
            }
        }

        function chk_avail_clear() {
            checkin.value = '';
            checkout.value = '';
            chk_avail_btn.classList.remove('d-none');
            fetch_rooms();

        }

        function guests_filter() {
            if (adult.value > 0 || children.value > 0) {
                fetch_rooms();
                guests_btn.classList.remove('d-none');
            }
        }

        function guests_clear() {
            adult.value = '';
            children.value = '';
            guests_btn.classList.add('d-none');
            fetch_rooms();
        }

        function features_clear() {
            let get_features = document.querySelectorAll('[name=features]:checked');
            get_features.forEach((features) => {
                features.checked = false;
            });
            features_btn.classList.add('d-none');
            fetch_rooms();
        }

        window.onload = function() {
            fetch_rooms();
        }
    </script>

    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->


    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

    <!---START OF UPDATE---->


    <script>
        function hideFeatures(roomId) {
            var featuresList = document.getElementById('featuresList_' + roomId);
            if (featuresList) {
                featuresList.style.display = 'none';
            }
        }

        function showFeatures(roomId) {
            var featuresList = document.getElementById('featuresList_' + roomId);
            if (featuresList) {
                featuresList.style.display = 'block';
            }
        }
    </script>

    <script>
        function hideFacilities(roomId) {
            var facilitiesList = document.getElementById('facilitiesList_' + roomId);
            if (facilitiesList) {
                facilitiesList.style.display = 'none';
            }
        }

        function showFacilities(roomId) {
            var facilitiesList = document.getElementById('facilitiesList_' + roomId);
            if (facilitiesList) {
                facilitiesList.style.display = 'block';
            }
        }
    </script>



    <!---END OF UPDATE---->

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

    <script>
        function showAllFeatures(roomId, type) {
            // Your implementation here
            console.log("Show all features for room ID", roomId, "and type", type);
            // You may want to implement a modal or another way to display additional features
        }
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