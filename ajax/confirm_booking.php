<?php
require('../admin/include/conn.php');
require('../admin/include/essentials.php');

date_default_timezone_set("Asia/Manila");


if (isset($_POST['check_availability'])) {
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    $checkin_date_str = "";
    $checkout_date_str = "";

    //pancheck ng dates sa check in and check out if available or not
    $today_date = new DateTime(date("M-d-Y"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    $checkin_date_str = $checkin_date->format('M-d-Y || D');
    $checkout_date_str = $checkout_date->format('M-d-Y || D');

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
