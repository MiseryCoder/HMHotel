<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image" href="img/logo.png">
    <link rel="stylesheet" href="css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    <title>HM Hotel | Paypal Payment</title>
</head>

<body>


    <?php
    require('admin/include/conn.php');
    require('admin/include/essentials.php');
    require('include/gcash/vendor/autoload.php');
    require('admin/include/mailer.php');
    require_once 'paypalConfig.php';

    date_default_timezone_set("Asia/Manila");

    $client = new \GuzzleHttp\Client();

    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('index.php');
    }

    if (isset($_POST['pay_now'])) {
        $checkSum = "";


        $CUST_ID = $_SESSION['uId'];
        $TXN_AMOUNT = $_SESSION['room']['payment'];
        $TYPE = $_SESSION['room']['name'];

        $ORDER_ID = "";

        $paramList = array();
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;

        //para makuha ung mga datasa form
        $frm_data = filteration($_POST);

        $currentTime = date("H:i:s");
        $checkinData = $frm_data['checkin'];
        $checkouData = $frm_data['checkout'];
        $paymentType = "Online Booking";

        //kunganong payment method ang ginamit, online,50-50,cash
        if ($_POST['flexRadioDefault'] == 'online') {
            $paymentMethod = "paypal";

            $ORDER_ID = 'CONF-' . $_SESSION['uId'] . random_int(11111, 9999999);

            $current_timess = date('H:i:s');
            $pre_checkout_time = '14:00:00';


            $checkin_datetime = $frm_data['checkin'] . ' ' . date('H:i:s');
            $checkout_datetime = $frm_data['checkout'] . ' ' . $pre_checkout_time;


            try {
                $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`expires_time`, `order_id`,`payment_method`,`payment_type`) VALUES (?,?,?,?,?,?,?,?)";
                insert($query1, [$CUST_ID, $_SESSION['room']['room_id'], $checkin_datetime, $checkout_datetime, $currentTime, $ORDER_ID, $paymentMethod, $paymentType], 'isssssss');

                $booking_id = mysqli_insert_id($con);
                $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `email`, `phonenum`) VALUES (?,?,?,?,?,?,?)";
                insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['email'], $frm_data['phonenum']], 'issssss');


                $response = $gateway->purchase(array(
                    'amount' => $TXN_AMOUNT,
                    'currency' => PAYPAL_CURRENCY,
                    'returnUrl' => PAYPAL_RETURN_URL . "?booking_id=" . $booking_id,
                    'cancelUrl' => PAYPAL_CANCEL_URL,
                ))->send();

                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not successful
                    echo $response->getMessage();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else if ($_POST['flexRadioDefault'] == 'online_gcash') {
            //magbabago si paymentMethod tsaka magdidivide to 2 si amount
            $TXN_AMOUNT2 = $TXN_AMOUNT * 100;
            $paymentMethod = "gcash";
            $bookinggcash = "Reserved";

            $ORDER_ID = 'CONF-' . $_SESSION['uId'] . random_int(11111, 9999999);

            $current_timess = date('H:i:s');
            $pre_checkout_time = '14:00:00';


            $checkin_datetime = $frm_data['checkin'] . ' ' . date('H:i:s');
            $checkout_datetime = $frm_data['checkout'] . ' ' . $pre_checkout_time;


            try {
                $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`expires_time`, `order_id`,`payment_method`,`payment_type`) VALUES (?,?,?,?,?,?,?,?)";
                insert($query1, [$CUST_ID, $_SESSION['room']['room_id'], $checkin_datetime, $checkout_datetime, $currentTime, $ORDER_ID, $paymentMethod, $paymentType], 'isssssss');

                $booking_id = mysqli_insert_id($con);
                $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `email`, `phonenum`) VALUES (?,?,?,?,?,?,?)";
                insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['email'], $frm_data['phonenum']], 'issssss');



                $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
                    'body' => '{"data":{"attributes":{"amount":' . $TXN_AMOUNT2 . ',"redirect":{"success":"' . SITE_URL . 'gcash_response.php?order_id=' . $ORDER_ID . '&amount=' . $TXN_AMOUNT . '","failed":"' . SITE_URL . 'pay_status.php?order=' . $ORDER_ID . '"},"type":"gcash","currency":"PHP"}}}',
                    'headers' => [
                        'accept' => 'application/json',
                        // test mode key
                        // 'authorization' => 'Basic c2tfdGVzdF9MTGcyUm5BeUhZY1BCaDJITHdCeFlMOEY6',
                        // live key
                        'authorization' => 'Basic c2tfbGl2ZV9tRjdCUGd4RlJDelNxMUFBeVRRbjZQdzU6',
                        'content-type' => 'application/json',
                    ],
                ]);

                $data = json_decode($response->getBody(), true);

                $redirect = $data['data']['attributes']['redirect']['checkout_url'];
                // print_r($data['data']['id']);

                echo "Redirecting in 3 seconds...";

                header('Refresh: 3;URL=' . $redirect);
            } catch (GuzzleHttp\Exception\ClientException $e) {
                $value = $TXN_AMOUNT;
                $amount = $value * 100;
                $response = $e->getResponse();
                $responseBody = $response->getBody()->getContents();

                $error = json_decode($responseBody, true);

                print_r($error['errors'][0]['detail']);
            }
        } else if ($_POST['flexRadioDefault'] == 'cash') { //pag cash
            $expiration_time = date('H:i:s');
            $paymentMethod = "cash";


            //mga messages na ilalagay sa db
            $isValidChecksum = "TRUE";
            $STATUS = "SUCCESS";
            $ORDER_ID = 'RES-' . $_SESSION['uId'] . random_int(11111, 9999999);
            $TRN_ID = 'TRN-' . $_SESSION['uId'] . random_int(11111, 9999999);
            $trans_status = "PAID";
            $trans_failed = "FAILED";
            $bookingsuccess = "Booked";
            $bookingfailed = "Payment Failed";

            $current_timess = date('H:i:s');
            $pre_checkout_time = '14:00:00';


            $checkin_datetime = $frm_data['checkin'] . ' ' . date('H:i:s');
            $checkout_datetime = $frm_data['checkout'] . ' ' . $pre_checkout_time;


            // Check if a file was uploaded
            if (isset($_FILES['idpic']) && $_FILES['idpic']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['idpic']['tmp_name'];
                $file_name = $_FILES['idpic']['name'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                // Generate a unique filename to avoid conflicts
                $photo_path = uniqid() . '.' . $file_ext;

                // Move the uploaded file to the desired directory
                $target_dir = 'img/users/proof/';
                $target_path = $target_dir . $photo_path;
                if (move_uploaded_file($tmp_name, $target_path)) {
                    // Insert the photo path into the database
                    $sql = "UPDATE `guests_users` SET `idpic` = '$photo_path' WHERE `id` = '$CUST_ID'";
                    if ($con->query($sql) === TRUE) {
                        echo "";
                    } else {
                        echo "";
                    }
                } else {
                    echo "";
                }
            } else {
                echo "";
            }





            $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`expires_time`, `order_id`,`payment_method`,`payment_type`, `trans_id`, `booking_status`, `trans_amt`, `trans_status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            insert($query1, [$CUST_ID, $_SESSION['room']['room_id'], $checkin_datetime, $checkout_datetime, $expiration_time, $ORDER_ID, $paymentMethod, $paymentType, $TRN_ID, $bookingsuccess, $TXN_AMOUNT, $trans_status], 'isssssssssss');

            $booking_id = mysqli_insert_id($con);
            $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `email` , `phonenum`) VALUES (?,?,?,?,?,?,?)";
            insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['email'], $frm_data['phonenum']], 'issssss');


            $bookedMail = "bookedOnly";
            send_notif($booking_id, $frm_data['email'], $bookedMail);

            //redirect to success page
            redirect('pay_status.php?order=' . $ORDER_ID);
        }
    }

    ?>

</body>

</html>