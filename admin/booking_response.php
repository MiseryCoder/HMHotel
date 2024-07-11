
<?php
require('include/conn.php');
require('include/essentials.php');
require('include/mailer.php');

date_default_timezone_set("Asia/Manila");

error_reporting(E_ALL);
ini_set('display_errors', 1);


mngmtLogin();
//paybtn manual
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
        $paymentMethod = "Fifty-Fifty";
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

    $current_timess = date('H:i:s');
    $pre_checkout_time = '14:00:00';


    $checkin_datetime = $frm_data['checkin'] . ' ' . date('H:i:s');
    $checkout_datetime = $frm_data['checkout'] . ' ' . $pre_checkout_time;

    //inserting data in booking_order table
    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`,`booking_status`, `check_in`, `check_out`,`expires_time`,`arrival`, `order_id`,`payment_method`,`payment_type`,`trans_id`,`trans_amt`,`trans_status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    insert($query1, [$CUST_ID, $_SESSION['room']['room_id'], $bookingStatus, $checkin_datetime, $checkout_datetime, $expiration_time, $arrival, $ORDER_ID, $paymentMethod, $paymentType, $TRN_ID, $TXN_AMOUNT, $trans_status], 'isssssissssss');

    //inserting data in booking_details table
    $booking_id = mysqli_insert_id($con);
    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `email`, `phonenum`) VALUES (?,?,?,?,?,?,?)";
    insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['email'], $frm_data['phonenum']], 'issssss');

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

//change room btn
if (isset($_POST['upgradebtn'])) {

    //initialiaze variables
    $frm_data = filteration($_POST);
    $book_id = $frm_data['book_id'];
    $Room_num = $frm_data['room_no'];
    $room_id = $frm_data['room_id'];
    $upgrade_price = $frm_data['change_payment'];
    $room_type_upgrade = $frm_data['change_room_type'];
    
    $current_timess = date('H:i:s');
    $pre_checkout_time = '14:00:00';
    
    $checkin_datetime = $frm_data['checkin'] . ' ' . date('H:i:s');
    $checkout_datetime = $frm_data['checkout'] . ' ' . $pre_checkout_time;

    $user_res = select("SELECT *
        FROM `booking_order` AS bo
        INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
        WHERE bo.`booking_id` = ?", [$book_id], 'i');

    $booking_data = mysqli_fetch_assoc($user_res);

    $emailSender = $booking_data['email'];

    // Update the SQL query to use placeholders
    $query = "UPDATE `booking_order` bo
          INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
          SET bd.room_name_prev = ?, bd.room_name = ?, bo.room_upgrade = ?, bo.upgrade_price = ?, bd.room_no_upgrade = ?, bo.check_in = ?, bo.check_out = ?, bo.room_id=?
          WHERE bo.booking_id = ?";


    $values = [
        $booking_data['room_name'],
        $room_type_upgrade,
        1,
        $upgrade_price,
        $Room_num,
        $checkin_datetime,
        $checkout_datetime,
        $room_id,
        $frm_data['book_id']
    ];

    // $res = update($query, $values, 'siiissi');
    // Output the SQL query for testing

    try {
        $res = update($query, $values, 'ssiiissii');

        if ($res === false) {
            // Log the SQL error
            error_log(mysqli_error($con));  // Assuming $con is your database connection
            echo 0; // Failure
        } else {
            $typeSend = "changeRoom";
            send_notif($frm_data['book_id'], $emailSender, $typeSend);
            

            redirect('checkin_booking.php');
 
        }
    } catch (Exception $e) {
        // Handle the exception, e.g., log or display an error message
        error_log($e->getMessage());
        echo 0;
    }


    //pang send ng email notification
    // send_notif($booking_id, $frm_data['email'], $bookedMail);

    // redirect('checkin_booking.php');
}



//for extension
if (isset($_POST['extendbtn'])) {
    $frm_data = filteration($_POST);

    // Fetch the current booking details
    $user_res = select("SELECT *
        FROM `booking_order` AS bo
        INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
        WHERE bo.`booking_id` = ?", [$frm_data['booking_id']], 'i');

    $booking_data = mysqli_fetch_assoc($user_res);

    $emailSender = $booking_data['email'];

    // Booking status
    $bookingStatus = $booking_data['booking_status'];

    // Format the check-in and check-out dates
    $checkin_date = new DateTime($frm_data['checkin_final']);
    $checkout_date = new DateTime($frm_data['checkout_final']);
    $checkin_date_formatted = $checkin_date->format('Y-m-d H:i:s');
    $checkout_date_formatted = $checkout_date->format('Y-m-d H:i:s');

    // Update the SQL query to use placeholders
    $query = "UPDATE `booking_order` bo
              INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
              SET bo.num_of_extensions = ?, bo.extended_price = ?, bo.check_in = ?, bo.check_out = ?
              WHERE bo.booking_id = ?";

    $values = [
        $frm_data['no_extension'],
        $frm_data['extended_total_amt'],
        $checkin_date_formatted,
        $checkout_date_formatted,
        $frm_data['booking_id']
    ];

    // Output the SQL query for testing

    try {
        $res = update($query, $values, 'iissi');

        if ($res === false) {
            // Log the SQL error
            error_log(mysqli_error($con));  // Assuming $con is your database connection
            echo 0; // Failure
        } else {
            $typeSend = "Extend_trans";
            send_notif($frm_data['booking_id'], $emailSender, $typeSend);

            if ($bookingStatus == "Checked-In") {
                redirect('checkin_booking.php');
            } else if ($bookingStatus == "Reserved") {
                redirect('res_bookings.php');
            } else {
                redirect('new_bookings.php');
            }
        }
    } catch (Exception $e) {
        // Handle the exception, e.g., log or display an error message
        error_log($e->getMessage());
        echo 0;
    }
}



?>