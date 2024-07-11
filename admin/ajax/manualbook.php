<?php
require('../include/conn.php');
require('../include/essentials.php');

date_default_timezone_set("Asia/Manila");

session_start();

if (isset($_GET['fetch_rooms'])) {

    
    $chk_avail = json_decode($_GET['chk_avail'], true);
    $checkin_date_str = '';
    $checkout_date_str = '';

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

        $checkin_date_str = $checkin_date->format('Y-m-d');
        $checkout_date_str = $checkout_date->format('Y-m-d');
    }

    //guests data json decode
    $guests = json_decode($_GET['guests'], true);
    $adult = ($guests['adult'] != '') ? $guests['adult'] : 0;
    $children = ($guests['children'] != '') ? $guests['children'] : 0;

    // features
    $features_list = json_decode($_GET['feature_list'], true);

    //count the no. of rooms
    $count_rooms = 0;
    $output = "";

    //fetching settings table to check wewbsite if shutdown or not
    $title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=1";
    $values = [1];
    $title_r = mysqli_fetch_assoc(mysqli_query($con, $title_q));


    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=? AND `room_ntype`=?  ORDER BY `room_id` ASC", [$adult, $children, 1, 0,'Room'], 'iiiis');

    while ($room_data = mysqli_fetch_assoc($room_res)) {

        // check availability of room based on quantity
        if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
            //run query if available ung room o hindi

            //if booked
            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` 
                        WHERE (booking_status='Booked' OR booking_status='Reserved') AND room_id=? 
                        AND check_out > ? AND check_in < ?";

            $values = [$room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'iss'));

            //if checked-in
            $tb_query2 = "SELECT COUNT(*) AS `bookings2` FROM `booking_order` 
                        WHERE booking_status=? AND room_id=? 
                        AND check_out > ? AND check_in < ?";

            $values2 = ['Checked-In', $room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch2 = mysqli_fetch_assoc(select($tb_query2, $values2, 'siss'));



            if (($room_data['quantity'] - $tb_fetch['total_bookings']) == 0) {
                continue;
            } else if (($room_data['quantity'] - $tb_fetch2['bookings2']) == 0) {
                continue;
            }
        }

        //GET FEATURES OF ROOM with filters

        $fea_count = 0;

        $fea_q = mysqli_query($con, "SELECT f.name, f.id FROM `features` f 
            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
            WHERE rfea.room_id = '$room_data[room_id]'");

        $features_data = "";
        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            if (in_array(($fea_row['id']), $features_list['features'])) {
                $fea_count++;
            }

            $features_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                $fea_row[name]                            
                            </span>";
        }

        if (count($features_list['features']) != $fea_count) {
            continue;
        }


        // get facilities of room

        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
            WHERE rfac.room_id = '$room_data[room_id]'");

        $facilities_data = "";

        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            $facilities_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                    $fac_row[name]                            
                                </span>";
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

        // Fetch room numbers
        $roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                        INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                        WHERE rnd.room_id = '$room_data[room_id]'");

        $room_numbers = ""; // Initialize room numbers variable

        if ($roomno_q && mysqli_num_rows($roomno_q) > 0) {
            // Fetch the associative array for room numbers
            $roomno_row = mysqli_fetch_assoc($roomno_q);

            // Check if 'room_nos' exists in the fetched row
            if (isset($roomno_row['room_nos'])) {
                $room_numbers = $roomno_row['room_nos'];
            }
        }


        $book_btn = "";
        if (!$title_r['shutdown']) {
            $login = 0;
            if (isset($_SESSION['mngmtLogin']) && $_SESSION['mngmtLogin'] == true) {
                $login = 1;
            }

            // Adjusted the onclick attribute to pass dates as strings
            $book_btn = "<button onclick=\"checkLoginToBook('$room_data[room_id]', '$checkin_date_str', '$checkout_date_str')\" class='btn btn-sm w-100 btn-success rounded shadow-none py-2 px-4 mb-1' data-bs-toggle='modal' data-bs-target='#loginModal'>Book Now </button>";
        }

        //print room card

        if ($count_rooms % 2 == 0) {
            $output .= '</div><div class="row">';
        }

        $output .= "
                    <div class='col-sm-6'>
                        <div class='px-1'>
                            <div class='card mb-3 border-0 shadow'>
                                <div class='g-0 p-2 align-items-center'>
                          
                                        <div class='p-4 mt-2'>
                                            <div class='mb-3'>
                                                <h4 class='mb-1'>$room_data[type]</h4>
                                                <h6 class='mb-1'>₱$room_data[price] per night</h6>
                                            </div>
                                            

                                            <h6 class='mb-1'>Guests</h6>
                                            <div class='mb-3'>
                                                <span class='badge rounded-pill bg-success text-light text-wrap'>
                                                    $room_data[adult] Adult
                                                </span>
                                                <span class='badge rounded-pill bg-success text-light text-wrap'>
                                                    $room_data[children] Children
                                                </span>


                                            </div>
                                            $book_btn
                                        </div>
                               
                                </div>
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

//fetch rooms for room upgrade
if (isset($_GET['fetch_room_upgrade'])) {


    $user_res = select("SELECT *
    FROM `booking_order` AS bo
    INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
    WHERE bo.`booking_id` = ?", [$_GET['book_id']], 'i');
    $booking_data = mysqli_fetch_assoc($user_res);

    
    $chk_avail = json_decode($_GET['chk_avail'], true);
    $checkin_date_str = '';
    $checkout_date_str = '';

    if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($chk_avail['checkin']);
        $checkout_date = new DateTime($chk_avail['checkout']);
        $checkin_date_str = $checkin_date->format('Y-m-d');
        $checkout_date_str = $checkout_date->format('Y-m-d');

        if ($checkin_date_str == $checkout_date_str) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        } else if ($checkout_date_str < $checkin_date_str) {
            echo "<h3 class='text-center text-danger'>Invalid Dates</h3>";
            exit;
        }

    }

    //guests data json decode
    $guests = json_decode($_GET['guests'], true);
    $adult = ($guests['adult'] != '') ? $guests['adult'] : 0;
    $children = ($guests['children'] != '') ? $guests['children'] : 0;

    // features
    $features_list = json_decode($_GET['feature_list'], true);

    //count the no. of rooms
    $count_rooms = 0;
    $output = "";

    //fetching settings table to check wewbsite if shutdown or not
    $title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=1";
    $values = [1];
    $title_r = mysqli_fetch_assoc(mysqli_query($con, $title_q));


    $room_res = select(
        "SELECT * FROM `rooms` WHERE `price` >= ? AND `adult` >= ? AND `children` >= ? AND `status` = ? AND `removed` = ? AND `room_ntype` = ? ORDER BY `room_id` ASC",
        [$booking_data['price'], $adult, $children, 1, 0, 'Room'],
        'iiiiis'
    );
    

    while ($room_data = mysqli_fetch_assoc($room_res)) {

        // check availability of room based on quantity
        if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
            //run query if available ung room o hindi

            //if booked
            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` 
                        WHERE (booking_status='Booked' OR booking_status='Reserved') AND room_id=? 
                        AND check_out > ? AND check_in < ?";

            $values = [$room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'iss'));

            //if checked-in
            $tb_query2 = "SELECT COUNT(*) AS `bookings2` FROM `booking_order` 
                        WHERE booking_status=? AND room_id=? 
                        AND check_out > ? AND check_in < ?";

            $values2 = ['Checked-In', $room_data['room_id'], $chk_avail['checkin'], $chk_avail['checkout']];
            $tb_fetch2 = mysqli_fetch_assoc(select($tb_query2, $values2, 'siss'));



            if (($room_data['quantity'] - $tb_fetch['total_bookings']) == 0) {
                continue;
            } else if (($room_data['quantity'] - $tb_fetch2['bookings2']) == 0) {
                continue;
            }
        }

        //GET FEATURES OF ROOM with filters

        $fea_count = 0;

        $fea_q = mysqli_query($con, "SELECT f.name, f.id FROM `features` f 
            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
            WHERE rfea.room_id = '$room_data[room_id]'");

        $features_data = "";
        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            if (in_array(($fea_row['id']), $features_list['features'])) {
                $fea_count++;
            }

            $features_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                $fea_row[name]                            
                            </span>";
        }

        if (count($features_list['features']) != $fea_count) {
            continue;
        }


        // get facilities of room

        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
            WHERE rfac.room_id = '$room_data[room_id]'");

        $facilities_data = "";

        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            $facilities_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                    $fac_row[name]                            
                                </span>";
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

        // Fetch room numbers
        $roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                        INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                        WHERE rnd.room_id = '$room_data[room_id]'");

        $room_numbers = ""; // Initialize room numbers variable

        if ($roomno_q && mysqli_num_rows($roomno_q) > 0) {
            // Fetch the associative array for room numbers
            $roomno_row = mysqli_fetch_assoc($roomno_q);

            // Check if 'room_nos' exists in the fetched row
            if (isset($roomno_row['room_nos'])) {
                $room_numbers = $roomno_row['room_nos'];
            }
        }


        $book_btn = "";
        if (!$title_r['shutdown']) {
            $login = 0;
            if (isset($_SESSION['mngmtLogin']) && $_SESSION['mngmtLogin'] == true) {
                $login = 1;
            }

            // Adjusted the onclick attribute to pass dates as strings
            $book_btn = "<button onclick=\"checkUpgradeToBook('$room_data[room_id]', '$checkin_date_str', '$checkout_date_str', $_GET[book_id])\" class='btn btn-sm w-100 btn-success rounded shadow-none py-2 px-4 mb-1' data-bs-toggle='modal' data-bs-target='#loginModal'>Book Now </button>";
        }

        //print room card

        if ($count_rooms % 2 == 0) {
            $output .= '</div><div class="row">';
        }

        $output .= "
                    <div class='col-sm-6'>
                        <div class='px-1'>
                            <div class='card mb-3 border-0 shadow'>
                                <div class='g-0 p-2 align-items-center'>
                          
                                        <div class='p-4 mt-2'>
                                            <div class='mb-3'>
                                                <h4 class='mb-1'>$room_data[type]</h4>
                                                <h6 class='mb-1'>₱$room_data[price] per night</h6>
                                            </div>
                                            

                                            <h6 class='mb-1'>Guests</h6>
                                            <div class='mb-3'>
                                                <span class='badge rounded-pill bg-success text-light text-wrap'>
                                                    $room_data[adult] Adult
                                                </span>
                                                <span class='badge rounded-pill bg-success text-light text-wrap'>
                                                    $room_data[children] Children
                                                </span>


                                            </div>
                                            $book_btn
                                        </div>
                               
                                </div>
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






if (isset($_GET['fetch_facility'])) {

    
    $chk_avail = json_decode($_GET['chk_avail'], true);
    $checkin_date_str = '';

    if ($chk_avail['checkin'] != '') {
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($chk_avail['checkin']);


        $checkin_date_str = $checkin_date->format('Y-m-d');
    }

    //guests data json decode
    $guests = json_decode($_GET['guests'], true);
    $adult = ($guests['adult'] != '') ? $guests['adult'] : 0;
    $children = ($guests['children'] != '') ? $guests['children'] : 0;

    // features
    $features_list = json_decode($_GET['feature_list'], true);

    //count the no. of rooms
    $count_rooms = 0;
    $output = "";

    //fetching settings table to check wewbsite if shutdown or not
    $title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=1";
    $values = [1];
    $title_r = mysqli_fetch_assoc(mysqli_query($con, $title_q));


    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=? AND `room_ntype`=?  ORDER BY `room_id` ASC", [$adult, $children, 1, 0,'Facility'], 'iiiis');

    while ($room_data = mysqli_fetch_assoc($room_res)) {

        // check availability of room based on quantity
        if ($chk_avail['checkin'] != '') {
            //run query if available ung room o hindi

            //if booked
            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` 
                        WHERE (booking_status='Booked' OR booking_status='Reserved') AND room_id=? 
                        AND check_in = ?";

            $values = [$room_data['room_id'], $chk_avail['checkin']];
            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'is'));

            //if checked-in
            $tb_query2 = "SELECT COUNT(*) AS `bookings2` FROM `booking_order` 
                        WHERE booking_status=? AND room_id=? 
                        AND check_in = ?";

            $values2 = ['Checked-In', $room_data['room_id'], $chk_avail['checkin']];
            $tb_fetch2 = mysqli_fetch_assoc(select($tb_query2, $values2, 'sis'));



            if (($room_data['quantity'] - $tb_fetch['total_bookings']) == 0) {
                continue;
            } else if (($room_data['quantity'] - $tb_fetch2['bookings2']) == 0) {
                continue;
            }
        }

        //GET FEATURES OF ROOM with filters

        $fea_count = 0;

        $fea_q = mysqli_query($con, "SELECT f.name, f.id FROM `features` f 
            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
            WHERE rfea.room_id = '$room_data[room_id]'");

        $features_data = "";
        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            if (in_array(($fea_row['id']), $features_list['features'])) {
                $fea_count++;
            }

            $features_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                $fea_row[name]                            
                            </span>";
        }

        if (count($features_list['features']) != $fea_count) {
            continue;
        }


        // get facilities of room

        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
            WHERE rfac.room_id = '$room_data[room_id]'");

        $facilities_data = "";

        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            $facilities_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                    $fac_row[name]                            
                                </span>";
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

        // Fetch room numbers
        $roomno_q = mysqli_query($con, "SELECT r.room_nos FROM `room_no` r 
                                        INNER JOIN `room_no_data` rnd ON r.id = rnd.room_no_id 
                                        WHERE rnd.room_id = '$room_data[room_id]'");

        $room_numbers = ""; // Initialize room numbers variable

        if ($roomno_q && mysqli_num_rows($roomno_q) > 0) {
            // Fetch the associative array for room numbers
            $roomno_row = mysqli_fetch_assoc($roomno_q);

            // Check if 'room_nos' exists in the fetched row
            if (isset($roomno_row['room_nos'])) {
                $room_numbers = $roomno_row['room_nos'];
            }
        }


        $book_btn = "";
        if (!$title_r['shutdown']) {
            $login = 0;
            if (isset($_SESSION['mngmtLogin']) && $_SESSION['mngmtLogin'] == true) {
                $login = 1;
            }

            // Adjusted the onclick attribute to pass dates as strings
            $book_btn = "<button onclick=\"checkLoginToBookfacility('$room_data[room_id]', '$checkin_date_str')\" class='btn btn-sm w-100 btn-success rounded shadow-none py-2 px-4 mb-1' data-bs-toggle='modal' data-bs-target='#loginModal'>Book Now </button>";
        }

        //print room card

        if ($count_rooms % 2 == 0) {
            $output .= '</div><div class="row">';
        }

        $output .= "
                    <div class='col-sm-6'>
                        <div class='px-1'>
                            <div class='card mb-3 border-0 shadow'>
                                <div class='g-0 p-2 align-items-center'>
                          
                                        <div class='p-4 mt-2'>
                                            <div class='mb-3'>
                                                <h4 class='mb-1'>$room_data[type]</h4>
                                                <h6 class='mb-1'>₱$room_data[price] minimum (3) hours</h6>
                                            </div>
                                            

                                            <h6 class='mb-1'>Guests</h6>
                                            <div class='mb-3'>
                                                <span class='badge rounded-pill bg-success text-light text-wrap'>
                                                    Up to $room_data[adult] Capacity 
                                                </span>

                                            </div>
                                            $book_btn
                                        </div>
                               
                                </div>
                            </div>
                        </div>
                    </div>
            ";

        $count_rooms++;
    }

    if ($count_rooms > 0) {
        echo $output;
    } else {
        echo "<h3 class='text-center text-danger'>No Facility to Show!</h3>";
    }
}

