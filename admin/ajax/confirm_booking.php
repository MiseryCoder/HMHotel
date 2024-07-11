<?php
require('../include/conn.php');
require('../include/essentials.php');

date_default_timezone_set("Asia/Manila");

//for room
if (isset($_POST['check_availability'])) {
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    $checkin_date_str = "";
    $checkout_date_str = "";

    //pancheck ng dates sa check in and check out if available or not
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    $checkin_date_str = $checkin_date->format('M-d-Y');
    $checkout_date_str = $checkout_date->format('M-d-Y');

    if ($checkin_date == $checkout_date) {
        $status = 'check_in_out_equal';
        $result = json_encode(["status" => $status]);
    } else if ($checkout_date < $checkin_date) {
        $status = 'check_out_earlier';
        $result = json_encode(["status" => $status]);
    } else if ($checkin_date < $today_date) {
        $status = 'check_in_earlier';
        $result = json_encode(["status" => $status]);
    }

    //check booking availability kung wala laman si status magrereturn error
    if ($status != '') {
        echo $result;
    } else {
        session_start();
        $_SESSION['room'];

        //run query if available ung room o hindi

        //if Booked
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
             WHERE (booking_status='Booked' OR booking_status='Reserved' OR booking_status='Checked-In')
             AND room_id=? 
             AND check_out >= ? AND check_in <= ?";


        $values = [$_SESSION['room']['room_id'], $frm_data['check_in'], $frm_data['check_out']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'iss'));

        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `room_id`=?", [$_SESSION['room']['room_id']], 'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);



        if (($rq_fetch['quantity'] - $tb_fetch['total_bookings']) == 0) {
            $status = 'unavailable';
            $result = json_encode(['status' => $status]);
            echo $result;
            exit;
        } else {
            $count_days = $checkin_date->diff($checkout_date)->days; // Include the checkout day
            $payment = $_SESSION['room']['price'] * $count_days;

            $_SESSION['room']['payment'] = $payment;
            $_SESSION['room']['available'] = true;

            $result = json_encode(["status" => 'available', "checkin" => $checkin_date_str, "checkout" => $checkout_date_str, "days" => $count_days, "payment" => $payment]);
            echo $result;
        }
    }
}




//for room upgrade
if (isset($_POST['check_room_upgrade'])) {
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    $checkin_date_str = "";
    $checkout_date_str = "";

    //pancheck ng dates sa check in and check out if available or not
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    $checkin_date_str = $checkin_date->format('M-d-Y');
    $checkout_date_str = $checkout_date->format('M-d-Y');

    if ($checkin_date == $checkout_date) {
        $status = 'check_in_out_equal';
        $result = json_encode(["status" => $status]);
    } else if ($checkout_date < $checkin_date) {
        $status = 'check_out_earlier';
        $result = json_encode(["status" => $status]);
    }

    //check booking availability kung wala laman si status magrereturn error
    if ($status != '') {
        echo $result;
    } else {
        session_start();
        $_SESSION['room'];

        //run query if available ung room o hindi

        //if Booked
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
             WHERE (booking_status='Booked' OR booking_status='Reserved' OR booking_status='Checked-In')
             AND room_id=? 
             AND check_out >= ? AND check_in <= ?";


        $values = [$_SESSION['room']['room_id'], $frm_data['check_in'], $frm_data['check_out']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'iss'));

        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `room_id`=?", [$_SESSION['room']['room_id']], 'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);



        if (($rq_fetch['quantity'] - $tb_fetch['total_bookings']) == 0) {
            $status = 'unavailable';
            $result = json_encode(['status' => $status]);
            echo $result;
            exit;
        } else {
            $count_days = $checkin_date->diff($checkout_date)->days; // Include the checkout day
            $payment = $_SESSION['room']['price'] * $count_days;

            $_SESSION['room']['payment'] = $payment;
            $_SESSION['room']['available'] = true;

            $result = json_encode(["status" => 'available', "checkin" => $checkin_date_str, "checkout" => $checkout_date_str, "days" => $count_days, "payment" => $payment]);
            echo $result;
        }
    }
}



//for facility
if (isset($_POST['check_availability_facility'])) {
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    $checkin_date_str = "";




    //pancheck ng dates sa check in and check out if available or not
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $timein_time = new DateTime($frm_data['time_in']);
    $timeout_time = new DateTime($frm_data['time_out']);


    $timeout_limit = new DateTime("21:00:00");
    $timein_min = new DateTime("09:00:00");


    // Check if time_in and time_out are equal
    if ($timein_time == $timeout_time) {
        $status = 'time_in_out_equal';
        $result = json_encode(["status" => $status]);
    }
    // Check if time_out is earlier than time_in
    else if ($timeout_time < $timein_time) {
        $status = 'time_out_earlier';
        $result = json_encode(["status" => $status]);
    }
    // Check if time_out exceeds the limit
    else if ($timeout_time > $timeout_limit) {
        $status = 'time_out_exceeded';
        $result = json_encode(["status" => $status]);
    }
    // Check if time_in is earlier than the minimum
    else if ($timein_time < $timein_min) {
        $status = 'time_in_minimum';
        $result = json_encode(["status" => $status]);
    }
    // Check if the duration is less than 3 hours
    else if ($timein_time->diff($timeout_time)->h < 3) {
        $status = 'duration_less_than_3hrs';
        $result = json_encode(["status" => $status]);
    }



    $checkin_date_str = $checkin_date->format('M-d-Y || D');


    //check booking availability kung wala laman si status magrereturn error
    if ($status != '') {
        echo $result;
    } else {
        session_start();
        $_SESSION['room'];

        //run query if available ung room o hindi

        //if Booked
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
             WHERE (booking_status='Booked' OR booking_status='Reserved' OR booking_status='Checked-In')
             AND room_id=? AND check_in = ?";


        $values = [$_SESSION['room']['room_id'], $frm_data['check_in']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'is'));

        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `room_id`=?", [$_SESSION['room']['room_id']], 'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);





        if (($rq_fetch['quantity'] - $tb_fetch['total_bookings']) == 0) {
            $status = 'unavailable';
            $result = json_encode(['status' => $status]);
            echo $result;
            exit;
        } else {

            $room_res = select("SELECT * FROM `rooms` WHERE `room_id` = ?", [$_SESSION['room']['room_id']], 'i');
            $room_data = mysqli_fetch_assoc($room_res);


            // Calculate the difference between time_out and time_in
            $time_difference = $timeout_time->diff($timein_time);

            // Get the total minutes from the difference
            $total_minutes = $time_difference->i + $time_difference->h * 60;

            // Calculate the total hours
            $total_hours = floor($total_minutes / 60);

            // Calculate the remaining minutes
            $remaining_minutes = $total_minutes % 60;

            // Format the total duration
            if ($total_hours > 0) {
                $formatted_hours = "$total_hours hrs";
            } else {
                $formatted_hours = "";
            }

            if ($remaining_minutes > 0) {
                $formatted_minutes = "$remaining_minutes mins";
            } else {
                $formatted_minutes = "";
            }

            // Concatenate hours and minutes
            if ($total_hours > 0 && $remaining_minutes > 0) {
                $formatted_duration = "$formatted_hours and $formatted_minutes";
            } elseif ($total_hours > 0) {
                $formatted_duration = $formatted_hours;
            } elseif ($remaining_minutes > 0) {
                $formatted_duration = $formatted_minutes;
            } else {
                $formatted_duration = "0 mins";
            }

            // Calculate the payment for the first 3 hours
            $base_payment = $_SESSION['room']['price']; // Replace with your base payment for the first 3 hours
            $additional_hourly_rate = 1000; // Replace with your additional hourly rate

            // Check if the duration is less than or equal to 3 hours
            if ($total_hours <= 3) {
                $payment = $base_payment;
            } else {
                // Calculate the additional hours beyond the first 3 hours
                $additional_hours = $total_hours - 3;

                // Calculate the additional payment
                $additional_payment = $additional_hours * $additional_hourly_rate;

                // Total payment including the base payment and additional payment
                $payment = $base_payment + $additional_payment;
            }
            

            $_SESSION['room']['payment'] = $payment;
            $_SESSION['room']['available'] = true;

            $result = json_encode(["status" => 'available', "checkin" => $checkin_date_str, "duration" => $formatted_duration, "payment" => $payment]);
            echo $result;
        }
    }
}
