<?php


date_default_timezone_set("Asia/Manila");

session_start();


if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

use Omnipay\Omnipay;

require 'include/paypal/vendor/autoload.php';


$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);

$gateway->setTestMode(true); // Set to false if you want to use the live environment.
