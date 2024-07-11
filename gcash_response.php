<?php
require('admin/include/conn.php');
require('admin/include/essentials.php');

date_default_timezone_set("Asia/Manila");

session_start();
unset($_SESSION['room']);

//generate panibagong session para maset sa 0 ung mga rooms na pinili nya kasi babalik na sa index
function regenrate_session($uid)
{
    $user_q = select("SELECT * FROM `guests_users` WHERE `id`=? LIMIT 1", [$uid], 'i');
    $user_fetch = mysqli_fetch_assoc($user_q);

    $_SESSION['login'] = true;
    $_SESSION['uId'] = $user_fetch['id'];
    $_SESSION['uName'] = $user_fetch['name'];
    $_SESSION['uPic'] = $user_fetch['idpic'];
    $_SESSION['uPhone'] = $user_fetch['phonenum'];
}


//mga messages na ilalagay sa db
$isValidChecksum = "TRUE";
$STATUS = "SUCCESS";
$orderid = $_GET['order_id'];
$amount = $_GET['amount'];
$TRN_ID = 'TRN-' . $_SESSION['uId'] . random_int(11111, 9999999);
$trans_status = "PAID";
$trans_failed = "FAILED";
$paramList = $_POST;
$bookingsuccess = "Reserved";
$bookingfailed = "Payment Failed";


$slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`='$orderid'";

$slct_res = mysqli_query($con, $slct_query);

if (mysqli_num_rows($slct_res) == 0) {
    redirect('index.php');
}

$slct_fetch = mysqli_fetch_assoc($slct_res);

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    regenrate_session($slct_fetch['user_id']);
}

if ($STATUS == "SUCCESS") {
    $upd_query = "UPDATE `booking_order` SET `booking_status`='$bookingsuccess',`trans_id`='$TRN_ID',`trans_amt`='$amount',`trans_status`='$trans_status' WHERE `booking_id`='$slct_fetch[booking_id]'";

    mysqli_query($con, $upd_query);
} else {
    $upd_query = "UPDATE `booking_order` SET = `booking_status`='$bookingfailed',`trans_id`='$TRN_ID',`trans_amt`='$amount',`trans_status`='$trans_status' WHERE `booking_id`='$slct_fetch[booking_id]'";

    mysqli_query($con, $upd_query);
}
redirect('pay_status.php?order=' . $orderid);
