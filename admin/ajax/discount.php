<?php
require('../include/conn.php');
require('../include/essentials.php');

date_default_timezone_set("Asia/Manila");

if (isset($_POST['check_discount'])) {
    $frm_data = filteration($_POST);

    $discount_val = $frm_data['discount'];
    $amount = $frm_data['amount'];
    $booking_id = $frm_data['booking_id'];

    $user_res = select("SELECT *
    FROM `booking_order` AS bo
    INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
    WHERE bo.`booking_id` = ?", [$booking_id], 'i');
    $booking_data = mysqli_fetch_assoc($user_res);

    $initial = $booking_data['total_pay'];

    $discounted_val = $initial - ($initial * $discount_val / 100);

    // getting the room price

    $result = json_encode(["discount" => $discount_val, "discounted" => $discounted_val, "initial" => $initial]);
    echo $result;
}
?>
