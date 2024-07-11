
<?php
require('include/conn.php');
require('include/essentials.php');
require('include/mailer.php');

date_default_timezone_set("Asia/Manila");

error_reporting(E_ALL);
ini_set('display_errors', 1);


mngmtLogin();

if (isset($_POST['paybutton'])) {
    $frm_data = filteration($_POST);

    $checkSum = "";



    $CUST_ID = $_SESSION['mngmtID'];
    $TXN_AMOUNT = $_SESSION['room']['payment'];
    $TYPE = $_SESSION['room']['name'];

    

    $TRN_ID = 'TRN-' . random_int(11111, 9999999);
    $trans_status = "PAID";

    if ($_POST['flexRadioDefault'] == 'paycash') {
        $paymentMethod = "cash";
    } else if ($_POST['flexRadioDefault'] == 'payonline') {
        $paymentMethod = "Online";
    } else {
        $paymentMethod = "Authorized Letter";
    }


    $paymentType = "Walk-in";
    $expiration_time = date('H:i:s');
    $bookingStatus = $frm_data['bookingStatus'];

    $bookedMail = "";

    if ($bookingStatus == "Booked") {
        $arrival = 0;
        $bookedMail = "bookedOnly";
        $directory = "new_bookings.php";
        $ORDER_ID = 'RES-' . random_int(11111, 9999999);
    } else if ($bookingStatus == "Reserved") {
        $arrival = 0;
        $bookedMail = "Completed_trans";
        $directory = "res_bookings.php";
        $ORDER_ID = 'CONF-' . random_int(11111, 9999999);

    } else {
        $arrival = 1;
        $directory = "checkin_booking.php";
        $bookedMail = "Completed_trans";
        $ORDER_ID = 'CONF-' . random_int(11111, 9999999);
    }

    $paramList = array();
    $paramList["ORDER_ID"] = $ORDER_ID;
    $paramList["CUST_ID"] = $CUST_ID;
    $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;

    $checkin_datetime = $frm_data['checkin'] . ' ' . $frm_data['timein'];
    $checkout_datetime = $frm_data['checkin'] . ' ' . $frm_data['timeout'];

    //inserting data in booking_order table
    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`,`booking_status`, `check_in`, `check_out`, `time_slot_start`, `time_slot_end`,`expires_time`,`arrival`, `order_id`,`payment_method`,`payment_type`,`trans_id`,`trans_amt`,`trans_status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    insert($query1, [$CUST_ID, $_SESSION['room']['room_id'], $bookingStatus, $checkin_datetime, $checkout_datetime, $frm_data['timein'], $frm_data['timeout'], $expiration_time, $arrival, $ORDER_ID, $paymentMethod, $paymentType, $TRN_ID, $TXN_AMOUNT, $trans_status], 'isssssssissssss');

    //inserting data in booking_details table
    $booking_id = mysqli_insert_id($con);
    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `email`, `phonenum`, `room_no`) VALUES (?,?,?,?,?,?,?,?)";
    insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['email'], $frm_data['phonenum'], $frm_data['room_no']], 'isssssss');

    //pang send ng email notification
    send_notif($booking_id, $frm_data['email'], $bookedMail);

    if ($bookingStatus == "Checked-In") {
        redirect('checkin_booking.php');
    } else if ($bookingStatus == "Reserved") {
        redirect('res_bookings.php');
    } else {
        redirect('new_bookings.php');
    }
}


?>