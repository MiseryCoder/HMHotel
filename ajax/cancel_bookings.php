<?php
require('../admin/include/conn.php');
require('../admin/include/essentials.php');
require('../admin/include/mailer.php');

date_default_timezone_set("Asia/Manila");
session_start();


if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}



if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);
    $typeSend = "User_Cancelled";

    // Make sure $frm_data['booking_id'] is set and has a value
    if (isset($frm_data['id']) && $frm_data['id'] != '') {
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id` = ? AND `user_id`=?";
        $values = ['Cancelled', 1, $frm_data['id'],$_SESSION['uId']];

        $res = update($query, $values, 'siii');

        $user_res = select("SELECT *
            FROM `booking_order` AS bo
            INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
            WHERE bo.booking_id = ?", [$frm_data['id']], 'i');

        $booking_data = mysqli_fetch_assoc($user_res);

        $emailSender = $booking_data['email'];

        send_notif($frm_data['id'], $emailSender, $typeSend);
        echo ($res);
    } else {
        echo "Invalid or missing booking_id";
    }
}
?>