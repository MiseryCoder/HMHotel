<?php
require('admin/include/conn.php');
require('admin/include/essentials.php');
require_once 'paypalConfig.php';

date_default_timezone_set("Asia/Manila");

// Once the transaction has been approved, we need to complete it.
if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    $transaction = $gateway->completePurchase(array(
        'payer_id'             => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));

    $response = $transaction->send();

    if ($response->isSuccessful()) {
        // The customer has successfully paid. para sa paypal payment na table to
        $arr_body = $response->getData();

        $payment_id = $arr_body['id'];
        $customer_id = $_SESSION['uId'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = PAYPAL_CURRENCY;
        $payment_status = $arr_body['state'];

        if (!isset($_GET['booking_id'])) {
            redirect('index.php');
        }
        $data = filteration($_GET);
        $book_id = $data['booking_id'];

        //pang kuha nung id sa sql
        $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `booking_id`='$book_id'";
        $slct_res = mysqli_query($con, $slct_query);
        $slct_fetch = mysqli_fetch_assoc($slct_res);

        //booking_order data
        $bookingsuccess = "Reserved";
        $trans_status = "PAID";
        $trans_failed = "FAILED";
        $trans_id = $_GET['paymentId'];
        

        //insert into paypal_payments table
        $con->query("INSERT INTO paypal_payments(payment_id, customer_id, booking_id, payer_id, payer_email, amount, currency, payment_status) VALUES('" .
            $payment_id . "', '" . $customer_id . "', '" . $slct_fetch['booking_id'] . "', '" . $payer_id . "', '" . $payer_email . "', '" . $amount . "', '" . $currency . "', '" . $payment_status .
            "')");


        $upd_query = "UPDATE `booking_order` SET `booking_status`='$bookingsuccess',`trans_id`='$trans_id',`trans_amt`='$amount',`trans_status`='$trans_status' WHERE `booking_id`='$book_id'";
        mysqli_query($con, $upd_query);

        // echo "Payment is successful. Your transaction id is: " . $payment_id;
        redirect('paypalStatus.php?order=' . $payment_id);
        // print_r($data['booking_id']);
    } else {
        echo $response->getMessage();
        redirect('paypalStatus.php?order=' . $payment_id);
    }
} else {
    redirect('paypalStatus.php?order=' . $payment_id);
}
