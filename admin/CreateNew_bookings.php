<?php
require('include/conn.php');
require('include/essentials.php');

//session nasa include/essential.php
mngmtLogin();

$nxt_nxt_day = "";

$date = date("Y-m-d");
$lastday = date("Y-m-t", strtotime($date));

$date = date("Y-m-d");
$nxt_day = date("Y-m-d", strtotime($date . " +1 day"));


if ($date == $nxt_day) {
    // Current date is the last day of the month
    $nxt_nxt_day = date("Y-m-d", strtotime($nxt_day . " +1 day"));
    
} else{
    $nxt_nxt_day = date("Y-m-d", strtotime($date . " +1 day"));
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <link rel="icon" type="image" href="../img/logo.png">
    <link rel="stylesheet" href="../css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <title>HM Hotel | Create New Bookings</title>
</head>

<style>
    #CNactive {
        font-weight: bolder;
        color: #198754;
    }

    #CNactive:hover {
        color: #198754;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <div class="d-flex justify-content-between">
                    <button disabled class="shadow-none mb-3 w-100 btn btn-outline-success fw-bold text-center me-2">Bookings for Rooms</button>
                    <a href="new_bookings_facility.php" class="shadow-none mb-3 w-100 btn btn-success fw-bold text-center ">Bookings for Facility</a>
                </div>

                <div class="row">
                    <!-- content -->
                    <div class="mb-4 ps-4">
                        <div class="flex-lg-column align-items-stretch">
                            <div class="align-items-stretch">
                                <div class="bg-white shadow p-3 rounded mb-3">
                                    <!-- check availability -->
                                    <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                        <span>CHECK AVAILABILITY</span>
                                        <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                                    </h5>
                                    <label class="form-label">Check-in</label>
                                    <input type="date" class="form-control shadow-none mb-3" value="<?php echo $date ?>" id="checkin" onchange="chk_avail_filter()" min="<?php echo date('Y-m-d'); ?>">
                                    <label class="form-label">Check-out</label>
                                    <input type="date" class="form-control shadow-none" value="<?php echo $nxt_nxt_day ?>" id="checkout" onchange="chk_avail_filter()" min="<?php echo date('Y-m-d'); ?>">
                                </div>


                                <div class="border bg-light p-3 rounded mb-3" hidden>
                                    <!-- <h5 class="mb-3" style="font-size: 18px;">TYPE OF ROOM</h5> -->
                                    <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                        <span>Features</span>
                                        <button id="features_btn" onclick="features_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                                    </h5>

                                    <?php
                                    $features_q = selectAll('features');
                                    while ($row = mysqli_fetch_assoc($features_q)) {
                                        echo <<<features
                                            <div class="mb-2">
                                                <input type="checkbox" onclick="fetch_rooms()" name="features" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]">
                                                <label class="form-check-label" for="$row[id]">$row[name]</label>
                                            </div>
                                        features;
                                    }
                                    ?>
                                </div>



                                <div class="border bg-light p-3 rounded mb-3" hidden>
                                    <!-- <h5 class="mb-3" style="font-size: 18px;"></h5> -->
                                    <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                        <span>GUESTS</span>
                                        <button id="guests_btn" onclick="guests_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                                    </h5>
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <label class="form-check-label" for="f1">Adult</label>
                                            <input type="number" min="1" class="form-control shadow-none" value="<?php echo $adult_default ?>" id="adult" oninput="guests_filter()">
                                        </div>

                                        <div>
                                            <label class="form-check-label" for="f1" hidden>Children</label>
                                            <input type="number" min="1" class="form-control shadow-none" value="<?php echo $children_default ?>" id="children" oninput="guests_filter()">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-secondary text-center mb-1">
                        <h3 class="text-dark">Booking for Rooms</h3>
                        <h6 class="">Available Rooms</h6>
                    </div>


                    <div id="rooms-data">
                        <!-- card -->



                    </div>
                </div>


            </div>
        </div>
    </div>


    <!-- JavaScript Bundle with Popper -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

    <!-- alertbox lang to -->

    <?php require('include/scripts.php'); ?>

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
            xhr.open("GET", "ajax/manualbook.php?fetch_rooms&chk_avail=" + chk_avail + "&guests=" + guests + "&feature_list=" + feature_list, true);

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

    <script>
        function loadDoc() {
            setInterval(function() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("noti_number").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "include/notifications/bookings.php", true);
                xhttp.send();
            }, 1000);
        }
        loadDoc();
    </script>
</body>

</html>