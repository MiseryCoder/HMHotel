<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';
require 'vendor/autoload.php';




function send_mail($uemail, $token, $type)
{

    $user_res = select("SELECT *
    FROM `guests_users`
    WHERE `email` = ?", [$uemail], 's');


    $booking_data = mysqli_fetch_assoc($user_res);

    if ($type == "email_registration") {
        $page = 'email_confirm.php';
        $subject = "Account Verification Link";
        $content = "Verify your email";
        $message = "To finish setting up your account, we need to make sure that this email address is yours. Click on the button below to verify your email address.";
    } else {
        $page = 'index.php';
        $subject = "Password reset request";
        $content = "Reset your password?";
        $message = "If you requested a password reset, click the button below and confirm the password change.";
    }


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);


    try {

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'management@hmhotel.net';                     //SMTP username
        $mail->Password   = '@Hmhotel123';                                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('management@hmhotel.net', 'HM Hotel Pasig');
        $mail->addAddress($uemail);    //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = ("
        <body style='background-color: #f0f0f0;'>
            <div class='container text-center' style='padding: 20px;'>
                <div class='tbtb' style='max-width: 400px; margin: 0 auto; background-color: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;' >
                    <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                    <p class='title' style='font-size: 15px; font-weight: bold; color: black'>HM Hotel PLP Pasig</p>
                    <hr>
                    <p class='line2' style='margin-top: 10px; text-align: center; color: black'><b>$content</b></p>
                    <p style='text-align: left ; color: black'>$message</p>
                    <p class='button-link' style='text-align: center'>
                    <a href='" . SITE_URL . "$page?$type&email=$uemail&token=$token" . "' style='
                            display: inline-block;
                            padding: 10px 20px;
                            background-color: #198754; /* Button background color */
                            color: #fff; /* Text color */
                            text-decoration: none;
                            border-radius: 5px;
                            transition: background-color 0.3s ease, color 0.3s ease;
                        '>
                        Direct Me
                    </a>
                
                    </p>
                    <p style='text-align: left; color: black'>If you didn't request this, you can safely ignore this email.</p>
                    <p style='text-align: left; color: black'><i> Note: Don't share this link with others. <i></p>
                    <hr width='100px'>
                    </div>
                    <center>
                        <div class='foot' style='max-width: 400px; margin-top: 20px; color: #ffff; background-color: #198754'>
                            <p style='text-align: center'>HM Hotel | PLP Pasig</p>
                        </div>
                    </center>
            </div>
        </body>
    
    
        ");

        if ($mail->send()) {
            // Log a message to the console if the email is sent successfully
            echo '<script>console.log("Email sent successfully");</script>';
        } else {
            // Log an error message to the console if there's an issue with sending the email
            echo '<script>console.error("Error sending email:", ' . json_encode($mail->ErrorInfo) . ');</script>';
        }

        // Instead of "return 1", you can include additional logic or just leave it empty.
        // For demonstration purposes, let's echo a success message.
        echo '<script>console.log("Function completed successfully");</script>';
    } catch (Exception $e) {
        return 0;
    }
}





//for registration purposes for management accounts
function send_mails($uemail, $token, $type, $otp)
{

    if ($type == "email_confirmation") {
        $page = 'email_confirm.php';
        $subject = "HM Hotel Pasig Account Verification Code";
        $content = "Verification Code:";
        $bodyhtml = "
                    <body>
                        <center>
                            <div class='container'>
                                <div class='content'>
                                    <div class='tbtb'>
                        
                                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                                        <p class='title'>HM Hotel PLP Pasig</p>
                                        <hr>
                        
                        
                                        <p class='line2'>$content</p>
                                        <p class='code'><b>" . $otp . "</b></p>
                                        <p><i> Note: OTP is valid for <b>3 minutes only</b>. Do not share this One time Password with anyone. If you didn't request this, you can ignore this email. </i></p>
                        
                                        <hr width='100px'>
                                    </div>
                        
                                    <div class='foot'>
                                        <p>HM Hotel | PLP Pasig</p>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </body>";
    } else {
        $page = 'index.php';
        $subject = "Account Reset Password Link";
        $content = "reset your password";
        $siteurl = SITE_URL;
        $bodyhtml = "
                <body>
                    <center>
                        <div class='container'>
                            <div class='content'>
                                <div class='tbtb'>
                    
                                    <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                                    <p class='title'>HM Hotel PLP Pasig</p>
                                    <hr>
                    
                    
                                    <p class='line2'>$content</p>
                                    <p class='button-link'>
                                        <b>
                                            <a href='$siteurl$page?$type&email=$uemail&token=$token'>
                                                Direct me
                                            </a>
                                        </b>
                                    </p>
                                    <p><i> Note: Dont share this link to others. <i></p>
                    
                                    <hr width='100px'>
                                </div>
                    
                                <div class='foot'>
                                    <p>HM Hotel | PLP Pasig</p>
                                </div>
                            </div>
                        </div>
                    </center>
                </body>
        ";
    }


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);


    try {

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'management@hmhotel.net';                     //SMTP username
        $mail->Password   = '@Hmhotel123';                                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('management@hmhotel.net', 'HM Hotel Pasig');
        $mail->addAddress($uemail);


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        // $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $mail->Subject = $subject;
        $mail->Body    = ("

                <html lang='en'>

                <head>
                    <style>
                        @media (min-width: 1080px) {
                            .container {
                                width: 500px;
                            }
                        }
                        .container {
                            justify-content: center;
                            align-items: center;
                            text-align: center;
                            height: auto;
                        }
                        
                        .content {
                            width: auto;
                            height: auto;
                            padding: 20px;
                            text-align: center;
                        }
                        
                        .tbtb {
                            background-color: white;
                            padding: 10px;
                            text-align: center;
                        }
                        
                        .title {
                            font-weight: bold;
                        }
                        
                        .code {
                            font-size: 50px;
                        }
                        
                        .foot {
                            background-color: #198754;
                            color: white;
                        }
                        
                        hr {
                            border: none;
                            height: 1px;
                            background-color: #198754;
                            /* Change this to the desired color */
                        }

                        /* Style for the button-like link */
                        .button-link a {
                            display: inline-block;
                            padding: 10px 20px;
                            background-color: #198754; /* Button background color */
                            color: #fff; /* Text color */
                            text-decoration: none;
                            border-radius: 5px;
                        }

                        .button-link a:hover {
                            background-color: #E4A11B; /* Button background color on hover */   
                            color: #000;
                        }

                    </style>
                </head>
                
                $bodyhtml
                
                </html>
        ");


        ob_start();


        if ($mail->send()) {
            // Log a message to the console if the email is sent successfully
            echo '<script>console.log("Email sent successfully");</script>';
        } else {
            // Log an error message to the console if there's an issue with sending the email
            echo '<script>console.error("Error sending email:", ' . json_encode($mail->ErrorInfo) . ');</script>';
        }

        // Instead of "return 1", you can include additional logic or just leave it empty.
        // For demonstration purposes, let's echo a success message.
        echo '<script>console.log("Function completed successfully");</script>';


        ob_end_clean();
    } catch (Exception $e) {
        return 0;
    }
}




//for notification for users
function send_notif($booking_id, $uemail, $type)
{

    $user_res = select("SELECT *
    FROM `booking_order` AS bo
    INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
    WHERE bo.`booking_id` = ?", [$booking_id], 'i');


    $booking_data = mysqli_fetch_assoc($user_res);

    $checkin = new DateTime($booking_data['check_in']);
    $checkout = new DateTime($booking_data['check_out']);

    $count_days = $checkin->diff($checkout)->days; // Include the checkout day

    $checkinFormatted = $checkin->format("M-d-Y");
    $checkoutFormatted = $checkout->format("M-d-Y");

    //pag nagbayad na, PAID
    if ($type == "Completed_trans") {
        $subject = "HM Hotel PLPasig - Booking Notification";
        $content = "Booking Notification";
        $bodyhtml = "
        <body>
        <center>
            <div class='container' style='float: center;'>
                <div class='content'>
                    <div class='tbtb'>
                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                        <p class='title' style='text-align: center;'>HM Hotel PLPasig</p>
    
                        <hr>
    
                        <p style='text-align: center;'>$content</p>
    
                        <p><b>Hello, $booking_data[user_name]</b></p>
                        <!-- Align this paragraph text to the left -->
                        <p style='text-align: left;'>Great news! Your booking at HM Hotel Pasig has been successfully paid. We're thrilled to confirm your reservation. If you have any further questions or special requests, feel free to reach out. We look forward to ensuring you have a wonderful stay at HM Hotel Pasig!</p>
                        <table>
                            <tr>
                                <th colspan='2' style='text-align: center;'>Booking Details</th>
    
                            </tr>
                            <tr>
                                <td>Confirmation ID</td>
                                <td>$booking_data[order_id]</td>
                            </tr>
                            <tr>
                                <td>Room Type</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                            <tr>
                                <td>Check-In</td>
                                <td>$checkinFormatted</td>
                            </tr>
                            <tr>
                                <td>Check-Out</td>
                                <td>$checkoutFormatted</td>
                            </tr>
                            <tr>
                                <td>Booking Fees</td>
                                <td>FREE</td>
                            </tr>
                            <tr>
                                <td>No. of Days</td>
                                <td>$count_days</td>
                            </tr>
    
                            <!-- start update change position of price -->
    
                            <tr>
                                <td>Price</td>
                                <td>Php $booking_data[price]</td>
                            </tr>
    
                            <!-- end of update to change position of price -->
    
    
                            <!-- update pangboarder  -->
    
                            <tr>
                                <td colspan='2'>
                                    <hr class='my-4'>
                                </td>
                            </tr>
    
                            <!-- end of update pangboarder  -->
    
                            <tr>
                                <td>Paid Amount</td>
                                <td style='font-size: 20px;'>Php $booking_data[trans_amt]</td>
                            </tr>
                        </table>
                        <br>
                        <p>We respectfully ask that you confirm your reservation before the check-in date for security reasons.</p>
    
                        <p><b>Things you need to do:</b></p>
                        <p>1. Verify the accuracy of your booking details by reviewing them above.</p>
                        <p>2. Verify the details and if there are any inconsistencies or modifications, kindly notify us right away.</p>
                        <p>3. Present this email or your downloaded PDF to the Front Desk.</p>
                        <br>
    
                        <p style='text-align: center;'>We hope that your stay with us will be enjoyable. Please get in touch with us <br>if you need help further or if you have any questions.</p>
    
    
    
                        <hr width='100px'>
                    </div>
                    <div class='foot'>
                        <p>HM Hotel | PLPasig</p>
                    </div>
    
                </div>
            </div>
        </center>
    
    </body>";
    } else if ($type == "User_Cancelled") {
        $subject = "HM Hotel PLPasig - Booking Notification";
        $content = "Booking Notification";
        $bodyhtml = "
        <body>
        <center>
            <div class='container' style='float: center;'>
                <div class='content'>
                    <div class='tbtb'>
                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                        <p class='title' style='text-align: center;'>HM Hotel PLPasig</p>
    
                        <hr>
    
                        <p style='text-align: center;'>$content</p>
    
                        <p><b>Hello, $booking_data[user_name]</b></p>
                        <!-- Align this paragraph text to the left -->
                        <p style='text-align: left;'>Your booking at HM Hotel Pasig has been successfully cancelled. If you have any further questions or need assistance, feel free to contact our customer support. We hope to welcome you again in the future.</p>
                        <table>
                            <tr>
                                <th colspan='2' style='text-align: center;'>Booking Details</th>
    
                            </tr>
                            <tr>
                                <td>Confirmation ID</td>
                                <td>$booking_data[order_id]</td>
                            </tr>
                            <tr>
                                <td>Room Type</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                            <tr>
                                <td>Check-In</td>
                                <td>$checkinFormatted</td>
                            </tr>
                            <tr>
                                <td>Check-Out</td>
                                <td>$checkoutFormatted</td>
                            </tr>
                            <tr>
                                <td>Booking Fees</td>
                                <td>FREE</td>
                            </tr>
                            <tr>
                                <td>No. of Days</td>
                                <td>$count_days</td>
                            </tr>
    
                            <!-- start update change position of price -->
    
                            <tr>
                                <td>Price</td>
                                <td>Php $booking_data[price]</td>
                            </tr>
    
                            <!-- end of update to change position of price -->
    
    
                            <!-- update pangboarder  -->
    
                            <tr>
                                <td colspan='2'>
                                    <hr class='my-4'>
                                </td>
                            </tr>
    
                            <!-- end of update pangboarder  -->
    
                            <tr>
                                <td>Paid Amount</td>
                                <td style='font-size: 20px;'>Php $booking_data[trans_amt]</td>
                            </tr>
                        </table>
                        <br>
                        
                        <hr width='100px'>
                    </div>
                    <div class='foot'>
                        <p>HM Hotel | PLPasig</p>
                    </div>
    
                </div>
            </div>
        </center>
    
    </body>";
    } else if ($type == "Cancelled_Room") {

        $subject = "HM Hotel PLPasig - Booking Notification";
        $content = "Booking Cancelled";
        $bodyhtml = "
        <body>
        <center>
            <div class='container' style='float: center;'>
                <div class='content'>
                    <div class='tbtb'>
                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                        <p class='title' style='text-align: center;'>HM Hotel PLPasig</p>
    
                        <hr>
    
                        <p style='text-align: center;'>$content</p>
    
                        <p><b>Hello, $booking_data[user_name]</b></p>
                        <!-- Align this paragraph text to the left -->
                        <p style='text-align: left;'>We regret to inform you that your booking at HM Hotel PLPasig has been canceled due to non-payment of the reservation fee within the specified 24-hour period. If you have any questions or would like to make a new reservation, please contact our support team. We apologize for any inconvenience and appreciate your understanding.</p>
                        <table>
                            <tr>
                                <th colspan='2' style='text-align: center;'>Booking Details</th>
    
                            </tr>
                            <tr>
                                <td>Confirmation ID</td>
                                <td>$booking_data[order_id]</td>
                            </tr>
                            <tr>
                                <td>Room Type</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                            <tr>
                                <td>Check-In</td>
                                <td>$checkinFormatted</td>
                            </tr>
                            <tr>
                                <td>Check-Out</td>
                                <td>$checkoutFormatted</td>
                            </tr>
                            <tr>
                                <td>Booking Fees</td>
                                <td>FREE</td>
                            </tr>
    
                            <!-- start update change position of price -->
    
                            <tr>
                                <td>Price</td>
                                <td>Php $booking_data[price]</td>
                            </tr>
    
                            <!-- end of update to change position of price -->
    
    
                            <!-- update pangboarder  -->
    
                            <tr>
                                <td colspan='2'>
                                    <hr class='my-4'>
                                </td>
                            </tr>
    
                            <!-- end of update pangboarder  -->
    
                            <tr>
                                <td>Paid Amount</td>
                                <td style='font-size: 20px;'>Php $booking_data[trans_amt]</td>
                            </tr>
                        </table>
                        
    
                        <hr width='100px'>
                    </div>
                    <div class='foot'>
                        <p>HM Hotel | PLPasig</p>
                    </div>
    
                </div>
            </div>
        </center>
    
    </body>";
    } else if ($type == "Extend_trans") {
        $subject = "HM Hotel PLPasig - Booking Notification";
        $content = "Booking Notification";
        $bodyhtml = "
        <body>
        <center>
            <div class='container' style='float: center;'>
                <div class='content'>
                    <div class='tbtb'>
                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                        <p class='title' style='text-align: center;'>HM Hotel PLPasig</p>
    
                        <hr>
    
                        <p style='text-align: center;'>$content</p>
    
                        <p><b>Hello, $booking_data[user_name]</b></p>
                        <!-- Align this paragraph text to the left -->
                        <p style='text-align: left;'>Great news! Your booking at HM Hotel Pasig has been successfully Extended. We're thrilled to confirm your reservation. If you have any further questions or special requests, feel free to reach out. We look forward to ensuring you have a wonderful stay at HM Hotel Pasig!</p>
                        <table>
                            <tr>
                                <th colspan='2' style='text-align: center;'>Booking Details</th>
    
                            </tr>
                            <tr>
                                <td>Confirmation ID</td>
                                <td>$booking_data[order_id]</td>
                            </tr>
                            <tr>
                                <td>Room Type</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                            <tr>
                                <td>Check-In</td>
                                <td>$checkinFormatted</td>
                            </tr>
                            <tr>
                                <td>Check-Out</td>
                                <td>$checkoutFormatted</td>
                            </tr>
                            <tr>
                                <td>Booking Fees</td>
                                <td>FREE</td>
                            </tr>
                            <tr>
                                <td>No. of Extension</td>
                                <td>$booking_data[num_of_extensions]</td>
                            </tr>
    
                            <!-- start update change position of price -->
    
                            <tr>
                                <td>Price</td>
                                <td>Php $booking_data[price]</td>
                            </tr>
    
                            <!-- end of update to change position of price -->
    
    
                            <!-- update pangboarder  -->
    
                            <tr>
                                <td colspan='2'>
                                    <hr class='my-4'>
                                </td>
                            </tr>
    
                            <!-- end of update pangboarder  -->
    
                            <tr>
                                <td>Paid Amount</td>
                                <td style='font-size: 20px;'>Php $booking_data[extended_price]</td>
                            </tr>
                        </table>
                        <br>

    
                        <p style='text-align: center;'>We hope that your stay with us will be enjoyable. Please get in touch with us <br>if you need help further or if you have any questions.</p>
    
    
    
                        <hr width='100px'>
                    </div>
                    <div class='foot'>
                        <p>HM Hotel | PLPasig</p>
                    </div>
    
                </div>
            </div>
        </center>
    
    </body>";
    } else if ($type == "changeRoom") {
        $subject = "HM Hotel PLPasig - Booking Notification";
        $content = "Booking Notification";
        $bodyhtml = "
        <body>
        <center>
            <div class='container' style='float: center;'>
                <div class='content'>
                    <div class='tbtb'>
                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                        <p class='title' style='text-align: center;'>HM Hotel PLPasig</p>
    
                        <hr>
    
                        <p style='text-align: center;'>$content</p>
    
                        <p><b>Hello, $booking_data[user_name]</b></p>
                        <!-- Align this paragraph text to the left -->
                        <p style='text-align: left;'>Great news! Your booking at HM Hotel Pasig has been successfully Proccessed the Changed Room. We're thrilled to confirm your reservation. If you have any further questions or special requests, feel free to reach out. We look forward to ensuring you have a wonderful stay at HM Hotel Pasig!</p>
                        <table>
                            <tr>
                                <th colspan='2' style='text-align: center;'>Booking Details</th>
    
                            </tr>
                            <tr>
                                <td>Confirmation ID</td>
                                <td>$booking_data[order_id]</td>
                            </tr>
                            <tr>
                                <td>Room Type</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                            <tr>
                                <td>Check-In</td>
                                <td>$checkinFormatted</td>
                            </tr>
                            <tr>
                                <td>Check-Out</td>
                                <td>$checkoutFormatted</td>
                            </tr>
                            <tr>
                                <td>Booking Fees</td>
                                <td>FREE</td>
                            </tr>
                            <tr>
                                <td>Previous Room</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                            <tr>
                                <td>New Room</td>
                                <td>$booking_data[room_name_prev]</td>
                            </tr>
    
                            <!-- start update change position of price -->
    
                            <tr>
                                <td>Price</td>
                                <td>Php $booking_data[price]</td>
                            </tr>
    
                            <!-- end of update to change position of price -->
    
    
                            <!-- update pangboarder  -->
    
                            <tr>
                                <td colspan='2'>
                                    <hr class='my-4'>
                                </td>
                            </tr>
    
                            <!-- end of update pangboarder  -->
    
                            <tr>
                                <td>Paid Amount</td>
                                <td style='font-size: 20px;'>Php $booking_data[upgrade_price]</td>
                            </tr>
                        </table>
                        <br>

    
                        <p style='text-align: center;'>We hope that your stay with us will be enjoyable. Please get in touch with us <br>if you need help further or if you have any questions.</p>
    
    
    
                        <hr width='100px'>
                    </div>
                    <div class='foot'>
                        <p>HM Hotel | PLPasig</p>
                    </div>
    
                </div>
            </div>
        </center>
    
    </body>";
    } else { //for pencil booking palang
        $subject = "HM Hotel PLPasig - Booking Notification";
        $content = "Booking Notification";
        $bodyhtml = "
        <body>
        <center>
            <div class='container' style='float: center;'>
                <div class='content'>
                    <div class='tbtb'>
                        <img src='https://drive.google.com/uc?id=14-IK8FcAVI25jEcap_c7Kp0QtwWJ1tAd' alt='PLP Logo' width='100' height='100'>
                        <p class='title' style='text-align: center;'>HM Hotel PLPasig</p>
    
                        <hr>
    
                        <p style='text-align: center;'>$content</p>
                        <div style=''>
                            <h3 style='text-align: center;'>$booking_data[order_id]</h3>
                        </div>
    
                        <p><b>Hello, $booking_data[user_name]</b></p>
                        <!-- Align this paragraph text to the left -->
                        <p style='text-align: left;'>Congratulations on your successful reservation at HM Hotel Pasig! You're one step closer to finalizing your booking. To confirm your reservation, please make a payment of <b>Php $booking_data[trans_amt]</b> within the next <b>24 hours</b>. 
                        Failure to settle this amount within the specified time frame may result in the cancellation of your reservation. We look forward to welcoming you to HM Hotel Pasig!
                        
                        </p>

                        <table>
                            <tr>
                                <th colspan='2' style='text-align: center;'>Booking Details</th>
    
                            </tr>
                            <tr>
                                <td>Reservation ID</td>
                                <td>$booking_data[order_id]</td>
                            </tr>
                            <tr>
                                <td>Room Type</td>
                                <td>$booking_data[room_name]</td>
                            </tr>
                           
                            <tr>
                                <td>Check-In</td>
                                <td>$checkinFormatted</td>
                            </tr>
                            <tr>
                                <td>Check-Out</td>
                                <td>$checkoutFormatted</td>
                            </tr>
                            <tr>
                                <td>Booking Fees</td>
                                <td>FREE</td>
                            </tr>
                            <tr>
                                <td>No. of Days</td>
                                <td>$count_days</td>
                            </tr>
    
                            <!-- start update change position of price -->
    
                            <tr>
                                <td>Price</td>
                                <td>Php $booking_data[price]</td>
                            </tr>
    
                            <!-- end of update to change position of price -->
    
    
                            <!-- update pangboarder  -->
    
                            <tr>
                                <td colspan='2'>
                                    <hr class='my-4'>
                                </td>
                            </tr>
    
                            <!-- end of update pangboarder  -->
    
                            <tr>
                                <td>Paid Amount</td>
                                <td style='font-size: 20px;'>Php $booking_data[trans_amt]</td>
                            </tr>
                        </table>
                        <br>
                        <p>Kindly follow the guidelines provided below to finalize your reservation.</p>
    
                        <p><b>Things you need to do:</b></p>
                        <p>1. Show this email at the front desk of the hotel.</p>
                        <p>2. To guarantee your reservation, please make sure the payment is received prior to the check-in date.</p>
                        <br>
    
                        <p style='text-align: center;'>We hope that your stay with us will be enjoyable. Please get in touch with us <br>if you need help further or if you have any questions.</p>
    
    
    
                        <hr width='100px'>
                    </div>
                    <div class='foot'>
                        <p>HM Hotel | PLPasig</p>
                    </div>
    
                </div>
            </div>
        </center>
    
    </body>";
    }


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);


    try {

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'management@hmhotel.net';                     //SMTP username
        $mail->Password   = '@Hmhotel123';                                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('management@hmhotel.net', 'HM Hotel Pasig');
        $mail->addAddress($uemail);                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('hotelhmpasigplp218@outlook.com', 'HM Hotel Pasig');
        $mail->addAddress($uemail);     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        // $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $mail->Subject = $subject;
        $mail->Body    = ("

                <html>

                <head>
                    <style>

                        
                        .container {
                            height: auto;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 100%;
                            padding: 20px;
                        }
                        
                        .content {
                            width: auto;
                            height: auto;
                            text-align: center;
                        }
                        
                        .tbtb {
                            background-color: white;
                            padding: 10px;
                            text-align: center;
                            margin: 0 auto;
                            /* Center the content */
                        }
                        
                        .title {
                            font-weight: bold;
                            text-align: center;
                        }
                        
                        .code {
                            font-size: 50px;
                        }
                        
                        .foot {
                            background-color: #198754;
                            color: white;
                        }
                        
                        hr {
                            border: none;
                            height: 1px;
                            background-color: #198754;
                            /* Change this to the desired color */
                        }
                        /* Style for the button-like link */
                        
                        .button-link a {
                            display: inline-block;
                            padding: 10px 20px;
                            background-color: #198754;
                            /* Button background color */
                            color: #fff;
                            /* Text color */
                            text-decoration: none;
                            border-radius: 5px;
                        }
                        
                        .button-link a:hover {
                            background-color: #E4A11B;
                            /* Button background color on hover */
                            color: #000;
                        }
                        /* Add this rule to align the text to the left */
                        
                        .tbtb p {
                            text-align: left;
                        }
                        /* Add this rule to center the table */
                        
                        .tbtb table {
                            margin: 0 auto;
                            border-collapse: collapse;
                            width: 100%;
                        }
                        
                        .tbtb th,
                        .tbtb td {
                            padding: 10px;
                            border: 1px solid #ddd;
                            text-align: left;
                        }
                        
                        .tbtb th {
                            background-color: #198754;
                            color: white;
                        }
                    </style>
                </head>
                
                $bodyhtml
                
                </html>
        ");

        ob_start();


        // Assuming you have some code before this point

        // Sending the email
        if ($mail->send()) {
            // Log a message to the console if the email is sent successfully
            echo '<script>console.log("Email sent successfully");</script>';
        } else {
            // Log an error message to the console if there's an issue with sending the email
            echo '<script>console.error("Error sending email:", ' . json_encode($mail->ErrorInfo) . ');</script>';
        }

        // Instead of "return 1", you can include additional logic or just leave it empty.
        // For demonstration purposes, let's echo a success message.
        echo '<script>console.log("Function completed successfully");</script>';



        ob_end_clean();
    } catch (Exception $e) {
        return 0;
    }
}
