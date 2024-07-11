<?php
require('../admin/include/conn.php');
require('../admin/include/essentials.php');

date_default_timezone_set("Asia/Manila");

session_start();





// fetch all the rooms only
if (isset($_GET['fetch_rooms'])) {

    $chk_avail = json_decode($_GET['chk_avail'], true);


    if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($chk_avail['checkin']);
        $checkout_date = new DateTime($chk_avail['checkout']);

        if ($checkin_date == $checkout_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        } else if ($checkout_date < $checkin_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        } else if ($checkin_date < $today_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        }
    }

    //guests data decode
    $guests = json_decode($_GET['guests'], true);
    $adult = ($guests['adult'] != '') ? $guests['adult'] : 0;
    $children = ($guests['children'] != '') ? $guests['children'] : 0;

    // features
    $features_list = json_decode($_GET['feature_list'], true);

    //count the no. of rooms
    $count_rooms = 0;
    $output = "";

    //fetching settings rable to check wewbsite if shutdown or not
    $title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=1";
    $values = [1];
    $title_r = mysqli_fetch_assoc(mysqli_query($con, $title_q));


    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=? AND `room_ntype`=? ORDER BY `room_id` ASC", [$adult, $children, 1, 0, 'Room'], 'iiiis');

    while ($room_data = mysqli_fetch_assoc($room_res)) {

        // check availability of room based on quantity
        if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
            //run query if available ung room o hindi

            //if Booked
            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
             WHERE (booking_status='Booked' OR booking_status='Reserved' OR booking_status='Checked-In')
             AND room_id=? 
             AND check_out > ? AND check_in < ?";

            $values = [$room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'iss'));


            $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `room_id`=?", [$room_data['room_id']], 'i');
            $rq_fetch = mysqli_fetch_assoc($rq_result);


            if (($room_data['quantity'] - $tb_fetch['total_bookings']) == 0) {
                continue;
            }
        }

         //GET FEATURES OF ROOM with filters

         $fea_count = 0;

         $fea_q = mysqli_query($con, "SELECT f.name, f.id FROM `features` f 
             INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
             WHERE rfea.room_id = '$room_data[room_id]'");
 
                     $features_data = "<ul id='featuresList_$room_data[room_id]' style='list-style: none; padding: 0; margin: 0;'>";
                     while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                         if (in_array(($fea_row['id']), $features_list['features'])) {
                             $fea_count++;
                         }
 
                         $features_data .= "<li style='display: inline;'>• <span class='text-secondary'>$fea_row[name]</span> </li>"; 
                     }
 
                     $features_data .= "</ul><br>";
 
                     // Add hide and show buttons
                     $features_data .= "<span style= 'cursor: pointer; color: #198754;' onclick=\"showFeatures('$room_data[room_id]')\">Show Features...</span>&nbsp;&nbsp;";
                     $features_data .= "<span style='cursor: pointer; color: #198754;' onclick=\"hideFeatures('$room_data[room_id]')\">Hide Features...</span>";
                     // ... Your existing PHP code
 
                     echo "<script>
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
                     </script>";
 
                     if (count($features_list['features']) != $fea_count) {
                         continue;
                     }
 
 
 
 
        // Get facilities of room
                 $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                 INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                 WHERE rfac.room_id = '$room_data[room_id]'");
 
                 $facilities_data = "<ul id='facilitiesList_$room_data[room_id]' style='list-style: none; padding: 0; margin: 0;'>";
 
                 while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                 $facilities_data .= "<li style='display: inline;'>• <span class='text-secondary'>$fac_row[name]</span> </li>";
                 }
 
                 $facilities_data .= "</ul><br>";
 
                 // Add hide and show buttons for facilities
                 $facilities_data .= "<span onclick=\"showFacilities('$room_data[room_id]')\" style='cursor: pointer; color: #198754;'>Show Amenities...</span>&nbsp;&nbsp;";
                 $facilities_data .= "<span onclick=\"hideFacilities('$room_data[room_id]')\" style='cursor: pointer; color: #198754;'>Hide Amenities...</span>";
 
                 // JavaScript to handle hide and show functionality for facilities
                 echo "<script>
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
                 </script>";
                 
 
         
           //END OF MY UPDATE    
 

        //get thumbnail photo

        $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
        $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
            WHERE `room_id`='$room_data[room_id]' 
            AND `thumb`='1'");

        if (mysqli_num_rows($thumb_q) > 0) {
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
        }


        $book_btn = "";
        if (!$title_r['shutdown']) {
            $login = 0;
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $login = 1;
            }
            $book_btn = "<button onclick='checkLoginToBook($login,$room_data[room_id])' class='btn btn-sm w-100 btn-success rounded shadown-none py-2 px-4 mb-1' data-bs-toggle='modal' data-bs-target='#loginModal'>Book Now </button>";
        }

        //print room card

        //START OF UPDATE


        $output .= "
        <div class='card mb-4 border-0 shadow'>
            <div class='row g-0 p-2 align-items-center'>
                <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                    <img src='$room_thumb' class='img-fluid rounded' alt='...'>
                </div>
                <div class='col-md-5 px-lg-3 px-md-0 px-0'>
                    <div class='p-4 mt-2'>
                        <div class='mb-3'>

                        

                        <h5 class='mb-1 fs-4 fw-bold'>$room_data[type]</h5>


                        <h6 class='mb-2 fs-6 fw-bold'>₱$room_data[price] Per Night</h6>
                        </div>

                        <h6 class='mb-1'>Features</h6>
                        <div class='container-fluid'>
                            <div class='mb-3'>
                                $features_data
                            </div>
                        </div>


                        
                        <h6 class='mb-1'>Amenities</h6>
                        <div class='container-fluid'>
                            <div class='mb-3'>
                                $facilities_data
                            </div>
                        </div>

                        <h6 class='mb-1'>Guests</h6>
                        <div class='mb-3'>
                        <li style='display: inline;'>• <span class='text-secondary'> $room_data[adult] Capacity</span> </li>
                        <li hidden style='display: inline;'>• <span class='text-secondary'>  $room_data[children] Children</span> </li>

                        

                        </div>
                    </div>
                </div>
                <div class='col-md-2 text-center'>
                    <a class='btn btn-sm w-100 btn-success shadow-none rounded py-2 px-4' href='room_details.php?room_id=$room_data[room_id]&checkin=$chk_avail[checkin]&checkout=$chk_avail[checkout]'>More Details</a>
                </div>
            </div>
        </div>
    ";

$count_rooms++;
}

if ($count_rooms > 0) {
echo $output;
} else {
echo "<h3 class='text-center text-danger'>No Rooms to Show!</h3>";
}
}


//END OF UPDATE




// fetch all the facilities only
if (isset($_GET['fetch_facilities'])) {

    $chk_avail = json_decode($_GET['chk_avail'], true);

    if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($chk_avail['checkin']);
        $checkout_date = new DateTime($chk_avail['checkout']);

        if ($checkin_date == $checkout_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        } else if ($checkout_date < $checkin_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        } else if ($checkin_date < $today_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        }
    }

    //guests data decode
    $guests = json_decode($_GET['guests'], true);
    $adult = ($guests['adult'] != '') ? $guests['adult'] : 0;
    $children = ($guests['children'] != '') ? $guests['children'] : 0;

    // features
    $features_list = json_decode($_GET['feature_list'], true);

    //count the no. of rooms
    $count_rooms = 0;
    $output = "";

    //fetching settings rable to check wewbsite if shutdown or not
    $title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=1";
    $values = [1];
    $title_r = mysqli_fetch_assoc(mysqli_query($con, $title_q));


    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=? AND `room_ntype`=? ORDER BY `room_id` ASC", [$adult, $children, 1, 0, 'Facility'], 'iiiis');

    while ($room_data = mysqli_fetch_assoc($room_res)) {

        // check availability of room based on quantity
        if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
            //run query if available ung room o hindi

            //if Booked
            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` 
                        WHERE booking_status=? AND room_id=? 
                        AND check_out > ? AND check_in < ?";

            $values = ['Booked', $room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'siss'));



            //if checked-in
            $tb_query2 = "SELECT COUNT(*) AS `bookings2` FROM `booking_order` 
                        WHERE booking_status=? AND room_id=? 
                        AND check_out > ? AND check_in < ?";

            $values2 = ['Checked-In', $room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch2 = mysqli_fetch_assoc(select($tb_query2, $values2, 'siss'));

            $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `room_id`=?", [$_SESSION['room']['room_id']], 'i');
            $rq_fetch = mysqli_fetch_assoc($rq_result);


            if (($room_data['quantity'] - $tb_fetch['total_bookings']) == 0) {
                continue;
            } else if (($rq_fetch['quantity'] - $tb_fetch2['bookings2']) == 0) {
                continue;
            }
        }

        //GET FEATURES OF ROOM with filters

        $fea_count = 0;

        $fea_q = mysqli_query($con, "SELECT f.name, f.id FROM `features` f 
            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
            WHERE rfea.room_id = '$room_data[room_id]'");

        $features_data = "<ul style='list-style: none; padding: 0; margin: 0;'>";
        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            if (in_array(($fea_row['id']), $features_list['features'])) {
                $fea_count++;
            }

            $features_data .= "<li style='display: inline;'>• <span class='text-secondary'>$fea_row[name]</span> </li>";
        }

        $features_data .= "</ul>";


        if (count($features_list['features']) != $fea_count) {
            continue;
        }


        // get facilities of room

        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
            WHERE rfac.room_id = '$room_data[room_id]'");

        $facilities_data = "";

        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            $facilities_data .= "<li style='display: inline;'>• <span class='text-secondary'>$fac_row[name]</span> </li>";
        }

        //get thumbnail photo

        $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
        $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
            WHERE `room_id`='$room_data[room_id]' 
            AND `thumb`='1'");

        if (mysqli_num_rows($thumb_q) > 0) {
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
        }


        $book_btn = "";
        if (!$title_r['shutdown']) {
            $login = 0;
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $login = 1;
            }
            $book_btn = "<button onclick='checkLoginToBook($login,$room_data[room_id])' class='btn btn-sm w-100 btn-success rounded shadown-none py-2 px-4 mb-1' data-bs-toggle='modal' data-bs-target='#loginModal'>Book Now </button>";
        }

        //print room card

        $output .= "
                <div class='card mb-4 border-0 shadow'>
                    <div class='row g-0 p-2 align-items-center'>
                        <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                            <img src='$room_thumb' class='img-fluid rounded' alt='...'>
                        </div>
                        <div class='col-md-5 px-lg-3 px-md-0 px-0'>
                            <div class='p-4 mt-2'>
                                <div class='mb-3'>

                                

                                    <h5 class='mb-1'>$room_data[type]</h5>
                                    <div class='mb-1'>
                                        <small class='fa fa-star text-success'></small>
                                        <small class='fa fa-star text-success'></small>
                                        <small class='fa fa-star text-success'></small>
                                        <small class='fa fa-star text-success'></small>
                                        <small class='fa fa-star text-success'></small>
                                    </div>
                                    <h6 class='mb-2 fs-5 fw-bold'>₱$room_data[price] per night</h6>
                                </div>
                                <h6 class='mb-1'>Features</h6>
                                <div class='container-fluid'>
                                    <div class='mb-3'>
                                        $features_data
                                    </div>
                                </div>
                                <h6 class='mb-1'>Amenities</h6>
                                <div class='container-fluid'>
                                    <div class='mb-3'>
                                        $facilities_data
                                    </div>
                                </div>

                                <h6 class='mb-1'>Guests</h6>
                                <div class='mb-3'>
                                <li style='display: inline;'>• <span class='text-secondary'> $room_data[adult] Adult</span> </li>
                                <li style='display: inline;'>• <span class='text-secondary'>  $room_data[children] Children</span> </li>

                                </div>
                            </div>
                        </div>
                        <div class='col-md-2 text-center'>
                            <a class='btn btn-sm w-100 btn-success shadow-none rounded py-2 px-4' href='facility_details.php?room_id=$room_data[room_id]'>More Details</a>
                        </div>
                    </div>
                </div>
            ";

        $count_rooms++;
    }

    if ($count_rooms > 0) {
        echo $output;
    } else {
        echo "<h3 class='text-center text-danger'>No Facilities to Show!</h3>";
    }
}